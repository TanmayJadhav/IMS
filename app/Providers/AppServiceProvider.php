<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Operator;
use App\Models\Product;
use App\Models\Productcategory;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\Receipt;
use App\Models\SellProduct;
use App\Models\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Models\Shopadmin;
use App\Models\Shopcategory;
use App\Models\State;
use App\Models\User;
use App\Models\Vendor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('users', User::all());
        View::share('shopadmins', Shopadmin::all());
        View::share('shopcategories', Shopcategory::all());
        View::share('countries', Country::all());
        View::share('states', State::all());
        View::share('cities', City::all());
        View::share('vendors', Vendor::all());
        View::share('product_categories', Productcategory::all());
        View::share('products', Product::all());
        View::share('clients', Client::all());
        View::share('sessions', Session::all());
        View::share('quotation_products', QuotationProduct::all());
        View::share('quotations', Quotation::all());
        View::share('sell_products', SellProduct::all());
        View::share('receipts', Receipt::all());
        View::share('operators', Operator::all());


    }
}
