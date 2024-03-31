<?php

namespace App\Http\Controllers;

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

    public function foodOrder(){
        return view('food.welcome');
    }

    public function saloonBooking(){
        return view('saloon.welcome');
    }

    public function orderNow(){
        $foodProducts = Product::with('features')->where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_FOOD))->get();

        return view('food.orderNow', [
            'foodProducts' => $foodProducts
        ]);
    }

    public function bookNow(){
        $hairProducts = Product::where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_HAIR))->get();

        return view('saloon.bookNow', [
            'hairProducts' => $hairProducts
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

            $cartItem = ([
                'customerId' => $customer->id,
                'name' => $name,
                'description' => $description,
                'product_id' => $productId,
                'feature_id' => $featureId,
                'quantity' => $quantity,
                'price' => $itemPrice
            ]);

            Cart::create($cartItem);
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
                    'price' => $itemPrice
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
                $cartItem->delete();
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


    public function getCartItems() {
        $customer = Auth::guard('customer')->user();
        $customerId = $customer ? $customer->id : null;

        $sessionCart = session('cart');

        if ($customer) {
            $dbCart = Cart::where('customer_id', $customerId)->whereNull('status')->get();

            if(!empty($sessionCart)){
                foreach ($sessionCart as $item) {
                    $existingItem = $dbCart->where('product_id', $item['product_id'])
                                        ->where('feature_id', $item['feature_id'])
                                        ->first();
                    if (!$existingItem) {
                        Cart::create([
                            'name' => $item['name'],
                            'customer_id' => $customerId,
                            'product_id' => $item['product_id'],
                            'feature_id' => $item['feature_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'description' => $item['description'],
                        ]);
                    } else {
                        $existingItem->update([
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);
                    }
                }
            }

            $cart = Cart::where('customer_id', $customerId)->whereNull('status')->get();
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
            'delivery_type' => 'nullable',
            'address_id' => $request->get('delivery_type') === 'delivery' ? 'required' : 'nullable',
            'address_1' => [
                'required_if:delivery_type,delivery',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('delivery_type') === 'delivery' && !$request->input('address_id');
                })
            ],
            'address_2' => 'nullable',
            'additional_infomation' => 'nullable',
            'phone' => 'nullable',
            'cart_items' => 'required',
        ]);

        if($validator->fails()) {

            $cartData = [
                'status' => 'error',
                'message' => $validator->messages()->all()[0],
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
        $additionalInfomation = $request->additional_infomation;
        $phone = $request->phone;
        $bookingDate = $request->booking_date;
        $cart = $request->cart_items;
        $cartItems = json_decode($cart);

        if(!empty($addressLine1)){
            $newAddress = ([
                'address_1' => $addressLine1,
                'address_2' => $addressLine2,
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

        $productname = rtrim($productname, ', ');



        $productItems = [
            'price_data' => [
                'currency'     => 'NGN',
                'product_data' => [
                    "name" => $productname,
                ],
                'unit_amount'  => round($subTotal),
            ],
            'quantity'   => 1,
        ];

        $stripeCheckoutSession = \Stripe\Checkout\Session::create([
            'line_items'  => [
                $productItems

            ],
            ['metadata' => ['cartItems' => $cartItems]],
            'mode'        => 'payment',
            'customer_email'=> $customer->email,

            'success_url' => route('paymentSuccess'),
            'cancel_url'  => route('paymentFailed'),
        ]);

        $transactionData = [
            'customer_id' => $customerId,
            'order_id' => $stripeCheckoutSession->client_reference_id,
            'amount_paid' => $subTotal,
            'promo_amount' => "promocode",
            'status' => $stripeCheckoutSession->status == 'complete' ? 'completed' : ($stripeCheckoutSession->status == 'expired' ? "failed" : $stripeCheckoutSession->status == "open" && 'pending'),
            'payment_method' => $stripeCheckoutSession->payment_method_types,
        ];
        Transaction::create($transactionData);

       $cartData = [
            'status' => 'success',
            'message' => 'Cart is available',
            'redirectUrl' => $stripeCheckoutSession->url,
        ];

        // return response()->json($cartData);
        return redirect()->away($stripeCheckoutSession->url);

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
        $payload = $request->all();

        echo $payload;
        if ($payload['type'] == 'checkout.session.completed') {
            $session = $payload['data']['object'];

            $transactionData = [
                'customer_id' => $session['id'],
                'order_id' => $session['client_reference_id'],
                'amount_paid' => $session['amount_total'],
                'promo_amount' => $session['amount_subtotal'],
                'status' => 'completed',
                'payment_method' => $session['payment_method_types'][0],
            ];

            Transaction::create($transactionData);
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

        $customer->notify(new PaymentCheckout($details));

        return view('common.paymentSuccess', ['transactionData' => $transactionData]);


    }

    public function paymentFailed(){

        return view('common.paymentFailed');
    }

}
