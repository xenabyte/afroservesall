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
        $cart = session('cart');

        $cartItemKey = $this->findCartItemKey($cart, $productId, $featureId);
        $quantity = $cart[$cartItemKey]['quantity'];

        // Update the quantity based on the action
        if ($action === 'increase') {
            // Increase the quantity
            $cart[$cartItemKey]['quantity'] = $quantity + 1;
            $cart[$cartItemKey]['price'] += $itemPrice;
        } elseif ($action === 'decrease') {
            // Decrease the quantity
            if ($cart[$cartItemKey]['quantity'] > 1) {
                $cart[$cartItemKey]['quantity'] = $quantity-1;
                $cart[$cartItemKey]['price'] -= $itemPrice;
            }
        } elseif ($action === 'delete') {
            // Remove the item from the cart
            unset($cart[$cartItemKey]);
        }

        // Update the cart in the session
        session(['cart' => $cart]);

        session()->put('cart', $cart);
    
        $cartData = [
            'status' => 'success',
            'message' => 'Cart successfully updated',
            'cart' => $cart,
        ];

        // Return updated cart items
        return response()->json($cartData);
    }

    public function getCartItems() {
        $cart = session('cart');
        
        $cartData = [
            'status' => 'success',
            'message' => 'Cart is available',
            'cart' => !empty($cart)?$cart:[],
        ];

        // Return updated cart items
        return response()->json($cartData);
    }
    
}
