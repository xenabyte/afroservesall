<?php

namespace App\Http\Controllers;

use App\Events\CustomerActivity;
use App\Notifications\PaymentCheckout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductType;
use App\Models\Transaction;
use App\Models\Address;

use App\Mail\PaymentSuccess;
use App\Mail\SupportMail;

use SweetAlert;
use Mail;
use Alert;
use Log;
use Carbon\Carbon;
use Notification;

class BusinessController extends Controller
{
    //

    public function landing() {
        session()->forget('cart');
        $customer = Auth::guard('customer')->user();

        if($customer){
            $customerId = $customer->id;
            $cartItem = Cart::where('customer_id', $customerId)->whereNull('status')->forceDelete();
        }

        return view('welcome');
    }

    public function foodOrder(Request $request){
        session(['previous_url' => $request->url()]);
        return view('food.welcome');
    }

    public function saloonBooking(Request $request){
        session(['previous_url' => $request->url()]);
        return view('saloon.welcome');
    }

    public function orderNow(Request $request){
        $foodProducts = Product::with('features')->where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_FOOD))->get();
        session(['previous_url' => $request->url()]);
        return view('food.orderNow', [
            'foodProducts' => $foodProducts
        ]);
    }

    public function bookNow(Request $request){
        $hairProducts = Product::where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_HAIR))->get();

        $bookingDate = Order::where('status', '!=', 'completed')->pluck('booking_date');
        
        session(['previous_url' => $request->url()]);
        return view('saloon.bookNow', [
            'hairProducts' => $hairProducts,
            'bookingDate' => $bookingDate
        ]);
    }


    public function addToCart(Request $request){
        $productId = $request->product_id;
        $featureId = $request->feature_id;
        $quantity = $request->quantity;

        $product = Product::find($productId);
        $feature = ProductFeature::find($featureId);
        $itemPrice = $feature->price;

        $name = $product->name;
        $description = $feature->feature;

        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        if($customer){
            $customerId = $customer->id;

            $cartItem = Cart::where('customer_id', $customerId)->where('product_id', $productId)->where('feature_id', $featureId)->whereNull('status')->first();


            if(!empty($cartItem)){
                $cartQuantity = $cartItem->quantity;
                $price = $cartItem->price;

                $cartItem->quantity = $quantity + $cartQuantity;
                $cartItem->price = $price + ($quantity * $itemPrice);

                $cartItem->save();
            }else{
                $cartItem = ([
                    'customer_id' => $customerId,
                    'name' => $name,
                    'description' => $description,
                    'product_id' => $productId,
                    'feature_id' => $featureId,
                    'quantity' => $quantity,
                    'price' => $quantity * $itemPrice,
                    'product_type' => $product->type->type,
                ]);
                Cart::create($cartItem);
            }

            $cart = Cart::where('customer_id', $customerId)->where('status', null)->get();

        }else{
            $cart = session()->get('cart', []);

            $cartItemKey = $this->findCartItemKey($cart, $productId, $featureId);

            if ($cartItemKey !== null) {
                $cart[$cartItemKey]['quantity'] += $quantity;
                $cart[$cartItemKey]['price'] += $itemPrice;
            } else {
                $cartItem = [
                    'customerId' => $customerId,
                    'name' => $name,
                    'description' => $description,
                    'product_id' => $productId,
                    'feature_id' => $featureId,
                    'quantity' => $quantity,
                    'price' => $quantity * $itemPrice,
                    'product_type' => $product->type->type,
                ];
                $cart[] = $cartItem;
            }

            session()->put('cart', $cart);
        }


        $cartData = [
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'cart' => $cart,
        ];

        // event(new CustomerActivity($customer, $customer->name." add ".$cart-id." to cart" ));
       

        return response()->json($cartData);
    }

    public function updateQuantity(Request $request){

        $productId = $request->productId;
        $featureId = $request->featureId;
        $action = $request->action;

        $product = Product::find($productId);
        $feature = ProductFeature::find($featureId);
        $itemPrice = $feature->price;

        $name = $product->name;
        $description = $feature->feature;

        // Retrieve the cart from the session
        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        $sessionCart = session('cart');

        if ($customer) {
            $cartItem = Cart::where('customer_id', $customerId)->where('product_id', $productId)->where('feature_id', $featureId)->whereNull('status')->first();
            $quantity = $cartItem->quantity;

            if ($action === 'increase') {
                // Increase the quantity
                $cartItem['quantity'] = $quantity + 1;
                $cartItem['price'] += $itemPrice;
            } elseif ($action === 'decrease') {
                if ($cartItem['quantity'] > 1) {
                    $cartItem['quantity'] = $quantity-1;
                    $cartItem['price'] -= $itemPrice;
                }
            } elseif ($action === 'delete') {
                $cartItem->forceDelete();
            }

            $cartItem->save();

            $cart = Cart::where('customer_id', $customerId)->whereNull('status')->get();
        }else{

            $cartItemKey = $this->findCartItemKey($sessionCart, $productId, $featureId);
            $quantity = $sessionCart[$cartItemKey]['quantity'];

            if ($action === 'increase') {
                $sessionCart[$cartItemKey]['quantity'] = $quantity + 1;
                $sessionCart[$cartItemKey]['price'] += $itemPrice;
            } elseif ($action === 'decrease') {
                    if ($sessionCart[$cartItemKey]['quantity'] > 1) {
                    $sessionCart[$cartItemKey]['quantity'] = $quantity-1;
                    $sessionCart[$cartItemKey]['price'] -= $itemPrice;
                }
            } elseif ($action === 'delete') {
                unset($sessionCart[$cartItemKey]);
            }

            session(['cart' => $sessionCart]);
            $cart =  session('cart');
        }



        $cartData = [
            'status' => 'success',
            'message' => 'Cart successfully updated',
            'cart' => $cart,
        ];

        return response()->json($cartData);
    }

    public function removeFromCart(Request $request){
        $productId = $request->productId;
        $featureId = $request->featureId;

    
        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;
    
        if ($customer) {
            $cartItem = Cart::where('customer_id', $customerId)
                            ->where('product_id', $productId)
                            ->where('feature_id', $featureId)
                            ->whereNull('status')
                            ->first();
    
            if ($cartItem) {
                $cartItem->forceDelete();
            }
            
            $cart = Cart::where('customer_id', $customerId)
                        ->whereNull('status')
                        ->get();
        } else {
            $sessionCart = session('cart');
            $cartItemKey = $this->findCartItemKey($sessionCart, $productId, $featureId);

            if (isset($sessionCart[$cartItemKey])) {
                session()->forget('cart.' . $cartItemKey);
                $sessionCart = array_values(session('cart'));
                session()->put('cart', $sessionCart);
            }
    

            // Return the updated cart data
            $cartData = [
                'status' => 'success',
                'message' => 'Item removed from cart',
                'cart' => $sessionCart,
            ];

            return response()->json($cartData);
        }
    
        $cartData = [
            'status' => 'success',
            'message' => 'Item removed from cart',
            'cart' => $cart,
        ];
    
        return response()->json($cartData);
    }
    

    public function getCartItems($type) {
        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        $sessionCart = session()->has('cart') ? collect(session('cart'))->where('product_type', $type) : collect();

        if ($customer) {
            $dbCart = Cart::where('customer_id', $customerId)->where('product_type', $type)->whereNull('status')->get();

            if(!empty($sessionCart)){
                foreach ($sessionCart as $item) {
                    $existingItem = $dbCart->where('product_id', $item['product_id'])
                                        ->where('feature_id', $item['feature_id'])
                                        ->first();
                    if (!$existingItem) {
                        $product = Product::find($item['product_id']);
                        Cart::create([
                            'name' => $item['name'],
                            'customer_id' => $customerId,
                            'product_id' => $item['product_id'],
                            'feature_id' => $item['feature_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'description' => $item['description'],
                            'product_type' => $product->type->type,
                        ]);
                    } else {
                        $existingItem->update([
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);
                    }
                }
            }

            $cart = Cart::where('customer_id', $customerId)->where('product_type', $type)->whereNull('status')->get();
        } else {
            $cart = $sessionCart;
        }

        $cartData = [
            'status' => 'success',
            'message' => 'Cart is available',
            'cart' => $cart,
        ];

        return response()->json($cartData);
    }


    public function placeOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'cart_items' => 'required',
        ]);

        if($validator->fails()) {

            $cartData = [
                'status' => 'error',
                'message' => $validator->messages()->all()[0],
            ];

            return response()->json($cartData);
        }

        if(empty($request->address_id) && empty($request->address_1) && $request->delivery_type == 'delivery'){
            $cartData = [
                'status' => 'error',
                'message' => 'address is required',
            ];

            return response()->json($cartData);
        }

        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;


        \Stripe\Stripe::setApiKey(config('Stripe.sk'));


        $deliveryType = $request->delivery_type;
        $addressId = $request->address_id;
        $addressLine1 = $request->address_1;
        $addressLine2 = $request->address_2;
        $additionalInformation = $request->additional_information;
        $phone = $request->phone;
        $bookingDate = $request->booking_date;
        $cart = $request->cart_items;
        $productType = $request->product_type;
        $cartItems = json_decode($cart);

        if(empty($cartItems)){
            $cartData = [
                'status' => 'error',
                'message' => 'Cart is empty',
            ];

            return response()->json($cartData);
        }

        if(!empty($addressLine1)){
            $newAddress = ([
                'address_1' => $addressLine1,
                'address_2' => $addressLine2,
                'phone_number' => $phone,
                'customer_id' => $customerId
            ]);

            $addressId = Address::create($newAddress)->id;
        }

        $productname = '';
        $subTotal  = 0;
        foreach ($cartItems as $cartItem) {
            $productname .= $cartItem->name . ', ';
            $subTotal += $cartItem->price;
        }

        $fieldsToRemove = ['created_at', 'updated_at', 'deleted_at', 'description', 'status', 'feature_id', 'name', 'order_id', 'customer_id', 'product_id', 'feature_id', 'quantity', 'price', 'product_type'];

        $modifiedCartItems = array_map(function ($cartItem) use ($fieldsToRemove) {
            foreach ($fieldsToRemove as $field) {
                unset($cartItem->{$field});
            }
            return $cartItem;
        }, $cartItems);

        if($productType == 'Hair'){
            $subTotal = 30;
        }


        $productname = rtrim('Afroservesall - '.$productname, ', ');



        $productItems = [
            'price_data' => [
                'currency'     => 'GBP',
                'product_data' => [
                    "name" => $productname,
                ],
                'unit_amount'  => round($subTotal * 100),
            ],
            'quantity'   => 1,
        ];

        $stripeCheckoutSession = \Stripe\Checkout\Session::create([
            'line_items'  => [
                $productItems

            ],
            'metadata' => [
                'customerId' => $customerId,
                'addressId' => $addressId,
                'additionalInformation' => $additionalInformation,
                'bookingDate' => $bookingDate,
                'deliveryType' => $deliveryType,
                'productType' => $productType,
                'cartItems' => json_encode($cartItems)
            ],
            'mode'        => 'payment',
            'customer_email'=> $customer->email,
            'success_url' => route('paymentSuccess'),
            'cancel_url'  => route('paymentFailed'),
        ]);


       $cartData = [
            'status' => 'success',
            'message' => 'Cart is available',
            'redirectUrl' => $stripeCheckoutSession->url,
        ];

        $cartItemIds = collect($cartItems)->pluck('id');
        Cart::whereIn('id', $cartItemIds)->update(['status' => 'pending']);

        return response()->json($cartData);

    }


    public function checkout(Request $request){

         $customer = Auth::guard('customer')->user();

        \Stripe\Stripe::setApiKey(config('Stripe.sk'));
         $productItems = [
                    'price_data' => [
                        'currency'     => 'NGN',
                        'product_data' => [
                            "name" => "marko",
                        ],
                        'unit_amount'  => 300000,
                    ],
                    'quantity'   => 1,
                ];
            // }

        $stripeCheckoutSession = \Stripe\Checkout\Session::create([
            'line_items'  => [
                $productItems

            ],
            ['metadata' => ['cartItems' => 'tems']],
            'mode'        => 'payment',
                        // 'allow_promotion_codes' => true,
            'customer_email'=> "mako@gmail.com",

            'success_url' => route('paymentSuccess'),
            'cancel_url'  => route('paymentFailed'),
        ]);

        $transactionData = [];

        if($stripeCheckoutSession->status == 'complete'){
            $transactionData = [
                'customer_id' => $stripeCheckoutSession->id,
                'order_id' => $stripeCheckoutSession->client_reference_id,
                'amount_paid' => $stripeCheckoutSession->amount_total,
                'promo_amount' => $stripeCheckoutSession->amount_subtotal,
                'status' => $stripeCheckoutSession->status == 'complete' ? 'completed' : ($stripeCheckoutSession->status == 'expired' ? "failed" : $stripeCheckoutSession->status == "open" && 'pending'),
                'payment_method' => $stripeCheckoutSession->payment_method_types,
            ];

            Transaction::create($transactionData);
        }

        return redirect()->away($stripeCheckoutSession->url)->with($transactionData);
    }

    public function handleWebhook(Request $request){
        $allRequest = $request->all();
        $payload = $allRequest['data']['object'];

        if ($payload['object'] == 'checkout.session') {
            $customerId = $payload['metadata']['customerId'];
            $addressId = isset($payload['metadata']['addressId'])? $payload['metadata']['addressId'] : null;
            $additionalInformation = isset($payload['metadata']['additionalInformation']) ? $payload['metadata']['additionalInformation'] : null;
            $bookingDate = isset($payload['metadata']['bookingDate']) ? $payload['metadata']['bookingDate'] : null;
            $deliveryType = $payload['metadata']['deliveryType'];
            $productType = $payload['metadata']['productType'];
            $cartInformation = json_decode($payload['metadata']['cartItems'], true);
            $amountTotal = $payload["amount_total"];
            $paymentReference = $payload["payment_intent"];
            $status = $payload['payment_status'];

            $customer = Customer::find($customerId);

            //check double creation of transaction
            if($checkTransaction = Transaction::where('reference', $paymentReference)->first()){
                return false;
            }

            $transactionData = [
                'customer_id' => $customerId,
                'amount_paid' => $amountTotal,
                'promo_amount' => $amountTotal,
                'status' => $status,
                'reference' => $paymentReference,
                'payment_method' => $payload['payment_method_types'][0],
            ];

            $transaction = Transaction::create($transactionData);
            $transactionId  = $transaction->id;

            //create order
            $orderData = [
                'sku' => $this->generateOrderCode(),
                'customer_id' => $customerId,
                'amount_paid' => $amountTotal,
                'additional_information' => $additionalInformation,
                'address_id' => $addressId,
                'booking_date' => $bookingDate,
                'delivery_type' => $deliveryType,
                'product_type' => $productType,
                'transaction_id' => $transactionId,
                'status' => 'pending',
            ];

            $order = Order::create($orderData);
            $orderId = $order->id;

            $transaction->order_id = $orderId;
            $transaction->save();

            $cartItemIds = collect($cartInformation)->pluck('id');
            Cart::whereIn('id', $cartItemIds)->update(['status' => 'completed', 'order_id' => $orderId]);

            //send notification mail
            $orderData = Order::with('cartItems', 'transaction')->where('id', $orderId)->first();
            // $mail = new PaymentSuccess($customer, $orderData);
            // Mail::to($customer->email)->send($mail);

            // Mail::to(env('SUPPORT_EMAIL'))->send(new SupportMail('New Order'));

            return true;
        }
    }

    public function paymentSuccess(){

        $customer = Auth::guard('customer')->user();
        $customerId = $customer->id;
        $transactionData = Transaction::where('customer_id', $customerId)->orderBy('created_at', 'desc')->first();

        $sessionCart = session('cart');
        $details["customer_name"] = "Wale";
        $details["product_name"] = "Mab";
        $details["total_price"] = "You just made a payment";
        $details["quantity"] = "Please enter your details";
        $details["transaction_id"] = "Please enter your details";

        // $customer->notify(new PaymentCheckout($details));

        return view('common.paymentSuccess', ['transactionData' => $transactionData]);
    }

    public function paymentFailed(){

        return view('common.paymentFailed');
    }

    public function checkAvailability(Request $request){
        $selectedDateTime = $request->input('dateTime');
        $productType = $request->input('productType');

        $bookingDate = Order::where('status', '!=', 'completed')
                    ->where('product_type', $productType)
                    ->whereBetween('booking_date', [
                        Carbon::parse($selectedDateTime)->subHour(),
                        Carbon::parse($selectedDateTime)->addHour()  
                    ])
                    ->exists();


        return response()->json(['available' => !$bookingDate]);
    }
}

