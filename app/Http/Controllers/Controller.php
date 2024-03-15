<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}
