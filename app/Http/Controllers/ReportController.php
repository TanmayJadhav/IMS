<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Receipt;
use App\Models\SellProduct;
use App\Models\Shopadmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function get_report_page()
    {
        return view('pages.reports.report');
    }

    public function filter_report(Request $request)
    {


        // $request->validate([

        //     'startdate'    => 'required|date',
        //     'enddate'      => 'required|date|after_or_equal:startdate'

        // ]);



        if ($request->input('startdate') == $request->input('enddate')) {

            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
            $client = Client::where('shopadmin_id', $shopadmin_id[0]->id)->get();
            $client_array = [];
            foreach ($client as $client) {
                array_push($client_array, $client->id);
            }
            $receipts = Receipt::whereIn('client_id', $client_array)->get();

            $receipt_id = [];

            foreach ($receipts as $receipt) {
                array_push($receipt_id, $receipt->id);
            }
            $reports = SellProduct::whereIn('receipt_id', $receipt_id)->whereDate('created_at', $request->input('startdate'))->where('shop_type', $this->getCurrentCategory())->get();
            // return $reports;
            return view('pages.reports.report', compact('reports'));
        } 
        
        else {

            $start_date = date('Y-m-d', strtotime($request->input('startdate') . ' - 1 days'));
            $end_date = date('Y-m-d', strtotime($request->input('enddate') . ' + 1 days'));

            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
            $client = Client::where('shopadmin_id', $shopadmin_id[0]->id)->get();
            $client_array = [];
            foreach ($client as $client) {
                array_push($client_array, $client->id);
            }
            $receipts = Receipt::whereIn('client_id', $client_array)->get();

            $receipt_id = [];

            foreach ($receipts as $receipt) {
                array_push($receipt_id, $receipt->id);
            }
            // return $receipt_id;
            // $reports = DB::table('sell_products')->whereIn('receipts.client_id',$client_array)
            // ->join('receipts', 'sell_products.receipt_id', '=', 'receipts.id')->get();


            $reports = SellProduct::whereIn('receipt_id', $receipt_id)->where('created_at', '>', $start_date)->where('shop_type', $this->getCurrentCategory())->where('created_at', '<', $end_date)->get();
            // return $reports;
            return view('pages.reports.report', compact('reports'));
        }
    }
}
