<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Models\Customer;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


use SweetAlert;
use Mail;
use Alert;
use Log;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lastname' => 'required|max:255',
            'othernames' => 'required|max:255',
            'email' => 'required|email|max:255|unique:customers',
            'password' => 'required|min:6|confirmed',
            'phone' =>'required|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    protected function create(array $data)
    {
        return Customer::create([
            'lastname' => $data['lastname'],
            'othernames' => $data['othernames'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('customer.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    protected function registered(Request $request, $user)
    {
        return redirect()->intended('/');
    }

    public function register(Request $request)
    {
        // Validate incoming data
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            alert()->error('Error', $validator->messages()->first())->persistent('Close');
            return redirect()->back()->withInput();
        }

        // If validation passes, create the new customer record
        $customer = $this->create($request->all());

        // Check if the customer was created successfully
        if ($customer) {
            // Optionally, you can log in the user automatically after registration
            auth()->login($customer);

            // Redirect the user to the desired page
            return redirect()->intended('/orderNow'); // Replace '/dashboard' with the desired URL
        } else {
            // If there was an error creating the customer, show an error message
            alert()->error('Error', 'Failed to register. Please try again.')->persistent('Close');
            return redirect()->back()->withInput();
        }
    }
}
