<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('food.orderNow');
    }

    public function bookNow(){
        return view('saloon.bookNow');
    }
}
