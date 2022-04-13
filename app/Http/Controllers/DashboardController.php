<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Operator;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Shopadmin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {

        if (Auth::user()->role == '1') {

            $shopadmin_count = Shopadmin::all()->count();
            return view('pages.dashboard', compact('shopadmin_count'));
        }
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {

            if (Auth::user()->role == '2') {

                $id = auth()->user()->username;
                $operator = Operator::where('mobile', $id)->get();
                // return $operator;
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                // return $shopadmin_id;
                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();

                return view('pages.clients.list', compact('clients'));

                // $shopadmin_count = Shopadmin::all()->count();
                // return view('pages.dashboard', compact('shopadmin_count'));
            } else {

                $id = auth()->user()->username;
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
                $client = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }


                $supplier_count = Vendor::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->count();
                $customer_count = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->count();
                $product_count = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->count();

                $total_income = $this->IND_money_format(Receipt::whereIn('client_id', $client_array)->where('shop_type', null)->sum('total_price'));

                $today_income = Receipt::select('total_price')->whereIn('client_id', $client_array)->where('shop_type', null)->whereDate('created_at', date('Y-m-d'))->get();
                $month_income = Receipt::select('total_price')->whereIn('client_id', $client_array)->where('shop_type', null)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                $monthly_expense = Expense::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->whereMonth('created_at', date('m'))->sum('amount');
                $monthly_salary = Employee::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->whereMonth('created_at', date('m'))->sum('salary');

                $client_ids = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->pluck('id');

                $remaining_amount = 0;
                $receipt = Receipt::whereIn('client_id', $client_ids)
                    ->get();
                foreach ($receipt as $receipt) {
                    $remaining_amount += $receipt->remaining_amount;
                }
                

                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->whereMonth('created_at', date('m'))->pluck('id');

                $amount = 0;
                $receipt = Receipt::whereIn('client_id', $clients)
                    ->get();
                foreach ($receipt as $receipt) {
                    $amount = $amount + $receipt->remaining_amount;
                }               


                // $monthly_profit = intval($month_income) - ($monthly_expense + $monthly_salary);
                // return $month_income;

                return view('pages.dashboard', compact('supplier_count','remaining_amount','amount','monthly_salary', 'monthly_expense', 'customer_count', 'product_count', 'total_income', 'today_income', 'month_income'));
            }
        } 
        else {
            if (Auth::user()->role == '2') {

                $id = auth()->user()->username;
                $operator = Operator::where('mobile', $id)->get();
                // return $operator;
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                // return $shopadmin_id;
                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();

                return view('pages.clients.list', compact('clients'));

                // $shopadmin_count = Shopadmin::all()->count();
                // return view('pages.dashboard', compact('shopadmin_count'));
            } else {

                $id = auth()->user()->username;
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
                $client = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }


                $supplier_count = Vendor::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->count();
                $customer_count = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->count();
                $product_count = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->count();

                $total_income = $this->IND_money_format(Receipt::whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->sum('total_price'));

                $today_income = Receipt::select('total_price')->whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->whereDate('created_at', date('Y-m-d'))->get();
                $month_income = Receipt::select('total_price')->whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                $monthly_expense = Expense::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->whereMonth('created_at', date('m'))->sum('amount');
                $monthly_salary = Employee::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->whereMonth('created_at', date('m'))->sum('salary');
                
                
                $client_ids = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->pluck('id');

                $remaining_amount = 0;
                $receipt = Receipt::whereIn('client_id', $client_ids)
                    ->get();
                foreach ($receipt as $receipt) {
                    $remaining_amount += $receipt->remaining_amount;
                }
                

                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->whereMonth('created_at', date('m'))->pluck('id');

                $amount = 0;
                $receipt = Receipt::whereIn('client_id', $clients)
                    ->get();
                foreach ($receipt as $receipt) {
                    $amount = $amount + $receipt->remaining_amount;
                }               

                // return $month_income;
                // $monthly_profit = intval($month_income) - (intval($monthly_expense) + intval($monthly_salary));

                return view('pages.dashboard', compact('supplier_count','amount','remaining_amount', 'monthly_salary', 'monthly_expense', 'customer_count', 'product_count', 'total_income', 'today_income', 'month_income'));
            }
        }
    }

    public static function IND_money_format($number)
    {
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for ($i = 0; $i < $length; $i++) {
            if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
                $delimiter .= ',';
            }
            $delimiter .= $money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if ($decimal != '0') {
            $result = $result . $decimal;
        }

        return $result;
    }
}
