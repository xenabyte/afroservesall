<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Order;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function findCartItemKey($cart, $productId, $featureId) {
        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productId && $item['feature_id'] == $featureId) {
                return $key;
            }
        }
        return null;
    }

    public function generateRandomString($length = 6) {
        $characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateOrderCode () {
        $orderCode = "";
        $current = $this->generateRandomString();
        $isExist = Order::where('sku', $current)->get();
        if(!($isExist->count() > 0)) {
            $orderCode = $current;
            return $orderCode;
        } else {
            return $this->generateOrderCode();
        }           
    }
}
