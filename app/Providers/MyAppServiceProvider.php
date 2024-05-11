<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\SiteInfo as Setting;
use App\Models\ActiveHour;
use App\Models\ProductType;
use App\Models\Order;

use Log;

class MyAppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('pageGlobalData', $this->pageGlobalData());
        });
    }

    public function pageGlobalData(){
        $setting = Setting::first();
        $foodActiveHours = ActiveHour::where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_FOOD))->get();
        $hairActiveHours =  ActiveHour::where('product_type_id', ProductType::getProductTypeId(ProductType::PRODUCT_TYPE_HAIR))->get();
        $pendingFoodOrder =  Order::where('product_type', ProductType::PRODUCT_TYPE_FOOD)->where('status', '!=', 'completed')->get()->count();
        $pendingHairOrder =  Order::where('product_type', ProductType::PRODUCT_TYPE_HAIR)->where('status', '!=', 'completed')->get()->count();

        $data = new \stdClass();
        $data->setting = $setting;
        $data->foodActiveHours = $foodActiveHours;
        $data->hairActiveHours = $hairActiveHours;
        $data->pendingFoodOrder = $pendingFoodOrder;
        $data->pendingHairOrder = $pendingHairOrder;

        return $data;
    }
}
