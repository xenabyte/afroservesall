<?php

namespace App\Http\Controllers\Admin;

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

class AdminController extends Controller
{
    //

    public function index(){
        return view('admin.home');
    }

    public function product(){

        $productTypes = ProductType::all();

        return view('admin.addProduct', [
            'productTypes' => $productTypes
        ]);
    }


    public function foodProducts(){
        $foodProducts = Product::where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_FOOD))->get();

        return view('admin.foodProducts', [
            'foodProducts' => $foodProducts
        ]);
    }

    public function hairProducts(){
        $hairProducts = Product::where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_HAIR))->get();

        return view('admin.hairProducts', [
            'hairProducts' => $hairProducts
        ]);
    }


    public function addProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'product_type_id' => 'required',
            'price' => 'nullable',
            'color' => 'nullable',
            'image' => 'nullable',
            'description' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $name = $request->name;
        $product_type_id = $request->product_type_id;
        $price = $request->price;
        $description = $request->description;

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));

        if(Product::where('slug', $slug)->first()){
            alert()->error('Oops!', 'product with name already exist, try with a different name')->persistent('Close');
            return redirect()->back();
        }

        $imageUrl=null;

        if(!empty($request->image)){
            $imageUrl = 'uploads/products/' . $slug . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $request->file('image')->move('uploads/products', $imageUrl);
        }

        $newProduct = [
            'name' => $name,
            'product_type_id' => $product_type_id,
            'price' => $price,
            'image' => $imageUrl,
            'description' => $description,
            'slug' => $slug
        ];

        if(Product::create($newProduct)){
            alert()->success('Changes Saved', 'Product added successfully')->persistent('Close');
            return $this->viewProduct($slug);
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function viewProduct($slug){
        $productTypes = ProductType::all();
        $product = Product::with('features')->where('slug', $slug)->first();
        if(!$product){
            alert()->error('Oops!', 'product not found')->persistent('Close');

            return view('admin.addProduct', [
                'productTypes' => $productTypes
            ]);
        }

        return view('admin.viewProduct', [
            'product' => $product,
            'productTypes' => $productTypes
        ]);
    }

    public function editProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' =>'required',
        ]);

        if(!$product = Product::find($request->product_id)){
            alert()->error('Oops!', 'product not found')->persistent('Close');
            return redirect()->back();
        }

        $slug = $product->slug;
        
        if(!empty($request->name) && $request->name != $product->name){
            $product->name = $request->name;
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $product->slug = $slug;
        }

        if(!empty($request->description) && $request->description!= $product->description){
            $product->description = $request->description;
        }

        if(!empty($request->price) && $request->price!= $product->price){
            $product->price = $request->price;
        }

        if(!empty($request->image)){
            $imageUrl = 'uploads/products/' . $slug . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $request->file('image')->move('uploads/products', $imageUrl);

            $product->image = $imageUrl;
        }

        if(!empty($request->product_type_id) && $request->product_type_id != $product->product_type_id){
            $product->product_type_id = $request->product_type_id;
        }

        if($product->save()){
            alert()->success('Changes Saved', 'product changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function deleteProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' =>'required',
        ]);

        if(!$product = Product::find($request->product_id)){
            alert()->error('Oops!', 'product not found')->persistent('Close');
            return redirect()->back();
        }

        if($product->delete()){
            alert()->success('Changes Saved', 'product deleted successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function addProductFeature(Request $request){
        $validator = Validator::make($request->all(), [
            'feature' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $feature = $request->feature;
        $product_id = $request->product_id;
        $price = $request->price;
        $description = $request->description;

        
        $newProductFeature = [
            'feature' => $feature,
            'product_id' => $product_id,
            'price' => $price,
            'description' => $description,
        ];

        if(ProductFeature::create($newProductFeature)){
            alert()->success('Changes Saved', 'Product option added successfully')->persistent('Close');
            return redirect()->back();        
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }
    
    public function deleteProductFeature(Request $request){
        $validator = Validator::make($request->all(), [
            'product_feature_id' =>'required',
        ]);

        if(!$productFeature = ProductFeature::find($request->product_feature_id)){
            alert()->error('Oops!', 'product option not found')->persistent('Close');
            return redirect()->back();
        }

        if($productFeature->delete()){
            alert()->success('Changes Saved', 'product option deleted successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function editProductFeature(Request $request){
        $validator = Validator::make($request->all(), [
            'product_feature_id' =>'required',
        ]);

        if(!$productFeature = ProductFeature::find($request->product_feature_id)){
            alert()->error('Oops!', 'product option not found')->persistent('Close');
            return redirect()->back();
        }
        
        if(!empty($request->feature) && $request->feature != $productFeature->feature){
            $productFeature->feature = $request->feature;
        }

        if(!empty($request->description) && $request->description!= $productFeature->description){
            $productFeature->description = $request->description;
        }

        if(!empty($request->price) && $request->price!= $productFeature->price){
            $productFeature->price = $request->price;
        }

        if($productFeature->save()){
            alert()->success('Changes Saved', 'product option changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function pendingFood(){
        $foodOrders = Order::with('customer', 'cartItems', 'customer')->where('product_type', ProductType::PRODUCT_TYPE_FOOD)->where('status', '!=', 'completed')->get();

        return view('admin.pendingFood', [
            'foodOrders' => $foodOrders
        ]);
    }

    public function completedFood(){
        $foodOrders = Order::with('customer', 'cartItems', 'customer')->where('product_type', ProductType::PRODUCT_TYPE_FOOD)->where('status', 'completed')->get();

        return view('admin.completedFood', [
            'foodOrders' => $foodOrders
        ]);
    }

    public function pendingHair(){
        $hairOrders = Order::with('customer', 'cartItems', 'customer')->where('product_type', ProductType::PRODUCT_TYPE_HAIR)->where('status', '!=', 'completed')->get();

        return view('admin.pendingHair', [
            'hairOrders' => $hairOrders
        ]);
    }

    public function completedHair(){
        $hairOrders = Order::with('customer', 'cartItems', 'customer')->where('product_type', ProductType::PRODUCT_TYPE_HAIR)->where('status', 'completed')->get();

        return view('admin.completedHair', [
            'hairOrders' => $hairOrders
        ]);
    }


    public function updateOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'order_id' =>'required',
        ]);

        if(!$order = Order::find($request->order_id)){
            alert()->error('Oops!', 'Order not found')->persistent('Close');
            return redirect()->back();
        }
        
        if(!empty($request->status) && $request->status != $order->status){
            $order->status = $request->status;
        }

        if($order->save()){
            alert()->success('Changes Saved', 'Order status changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }


    public function getAllTransactions(){
        $getAllTransactions = Transaction::with('customer', 'order')->get();

        return view('admin.getAllTransactions', [
            'getAllTransactions' => $getAllTransactions
        ]);
    }


}
