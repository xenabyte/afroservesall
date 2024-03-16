<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductType;
use App\Models\Transaction;


use SweetAlert;
use Mail;
use Alert;
use Log;
use Carbon\Carbon;


class BusinessController extends Controller
{
    //

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

        if($customer){
            $customerId = $customer->id;
            $cartItem = ([
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

            // Update the quantity based on the action
            if ($action === 'increase') {
                // Increase the quantity
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

            // Update the cart in the session
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


        // Return updated cart items
    
        // Return updated cart items
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
            'phone' => 'required',
            'cart_ids' => 'required|array',
        ]);
        
    }
    
    
}
