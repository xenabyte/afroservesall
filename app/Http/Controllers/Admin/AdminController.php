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
        $product = Product::get();
        return view('admin.product');
    }





    public function addProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'product_type_id' => 'required',
            'price' => 'required',
            'color' => 'required',
            'image' => 'required',
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

        $imageUrl = 'uploads/products/' . $slug . '.' . $request->file('image')->getClientOriginalExtension();
        $image = $request->file('image')->move('uploads/products', $imageUrl);

        $newProduct = [
            'name' => $name,
            'product_type_id' => $product_type_id,
            'price' => $price,
            'image' => $imageUrl,
            'description' => $description,
        ];

        if(Product::create($newProduct)){
            alert()->success('Changes Saved', 'Product added successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }
}
