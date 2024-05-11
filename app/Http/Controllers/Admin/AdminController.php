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
use App\Models\SiteInfo as Setting;
use App\Models\ActiveHour;


use SweetAlert;
use Mail;
use Alert;
use Log;
use Carbon\Carbon;

use App\Mail\NotificationMail;

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
            
            $data = new \stdClass();
            $data->status = $request->status;
            $data->booking_date = $order->booking_date;
            $data->order_id = $order->id;

            Mail::to($order->customer->email)->send(new NotificationMail('Message', $data));

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

    public function settings(){

        $settings = Setting::first();
        $activeHours = ActiveHour::all();
        $productTypes = ProductType::all();


        return view('admin.settings', [
            'settings' => $settings,
            'activeHours' => $activeHours,
            'productTypes' => $productTypes
        ]);
    }


    public function updateSettings(Request $request){

        $setting = new Setting;
        if(!empty($request->setting_id) && !$setting = Setting::find($request->setting_id)){
            alert()->error('Oops', 'Invalid Setting Information')->persistent('Close');
            return redirect()->back();
        }

        if(!empty($request->food_status) &&  $request->food_status != $setting->food_status){
            $setting->food_status = $request->food_status;
        }

        if(!empty($request->saloon_status) &&  $request->saloon_status != $setting->saloon_status){
            $setting->saloon_status = $request->saloon_status;
        }

        if(!empty($request->food_message) &&  $request->food_message != $setting->food_message){
            $setting->food_message = $request->food_message;
        }

        if(!empty($request->saloon_message) &&  $request->saloon_message != $setting->saloon_message){
            $setting->saloon_message = $request->saloon_message;
        }

        if($setting->save()){
            alert()->success('Changes Saved', 'Settings changes saved successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function addBusinessHours(Request $request){
        $validator = Validator::make($request->all(), [
            'product_type_id' => 'required',
            'week_days' => 'required',
            'opening_hours' => 'required',
            'closing_hours' => 'required',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $productTypeId = $request->product_type_id;
        $weekDays = $request->week_days;
        $openingHours = $request->opening_hours;
        $closingHours = $request->closing_hours;

        
        $newBusinessHour = [
            'product_type_id' => $productTypeId,
            'week_days' => $weekDays,
            'opening_hours' => $openingHours,
            'closing_hours' => $closingHours,
        ];

        if(ActiveHour::create($newBusinessHour)){
            alert()->success('Changes Saved', 'Business hour added successfully')->persistent('Close');
            return redirect()->back();        
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function deleteBusinessHour(Request $request){
        $validator = Validator::make($request->all(), [
            'active_hour_id' =>'required',
        ]);

        if(!$activeHour = ActiveHour::find($request->active_hour_id)){
            alert()->error('Oops!', 'Business Hour not found')->persistent('Close');
            return redirect()->back();
        }

        if($activeHour->delete()){
            alert()->success('Changes Saved', 'Business hour deleted successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

    public function updateBusinessHour(Request $request){
        $validator = Validator::make($request->all(), [
            'active_hour_id' =>'required',
        ]);

        if(!$activeHour = ActiveHour::find($request->active_hour_id)){
            alert()->error('Oops!', 'Business Hour not found')->persistent('Close');
            return redirect()->back();
        }

        if(!empty($request->week_days) &&  $request->week_days != $activeHour->week_days){
            $activeHour->week_days = $request->week_days;
        }

        if(!empty($request->opening_hours) &&  $request->opening_hours != $activeHour->opening_hours){
            $activeHour->opening_hours = $request->opening_hours;
        }

        if(!empty($request->closing_hours) &&  $request->closing_hours != $activeHour->closing_hours){
            $activeHour->closing_hours = $request->closing_hours;
        }

        if($activeHour->save()){
            alert()->success('Changes Saved', 'Business hour updated successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }

}
