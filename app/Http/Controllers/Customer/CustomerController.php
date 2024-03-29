<?php

namespace App\Http\Controllers\Customer;

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


class CustomerController extends Controller
{

    public function profile(){

        $customer = Auth::guard('customer')->user();
        
        return view('customer.profile');
    }

    public function deleteAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'address_id' =>'required',
        ]);

        if(!$address = Address::find($request->address_id)){
            alert()->error('Oops!', 'address not found')->persistent('Close');
            return redirect()->back();
        }

        if($address->delete()){
            alert()->success('Changes Saved', 'address deleted successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Oops!', 'Something went wrong')->persistent('Close');
        return redirect()->back();
    }
}
