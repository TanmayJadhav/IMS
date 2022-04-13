<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Operator;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\Session;
use App\Models\Shopadmin;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class QuotationController extends Controller
{

    public function get_quotation_list()
    {

        $currentCategory = $this->getCurrentCategory();


        if ($currentCategory == 'No Category Available') {
            $quotation = [];
            return view('pages.quotations.list', compact('quotation'));
        } elseif ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $id = auth()->user()->username;
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();

                $client = Client::where('shopadmin_id', $shopadmin_id[0]->id)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }

                $quotation = Quotation::whereIn('client_id', $client_array)->where('shop_type', null)->latest()->get();
            } else {

                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->first();
                $client = Client::where('shopadmin_id', $shopadmin_id->id)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }

                $quotation = Quotation::whereIn('client_id', $client_array)->where('shop_type', null)->latest()->get();
            }


            return view('pages.quotations.list', compact('quotation'));
        } else {
            $id = auth()->user()->username;
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();

                $client = Client::where('shopadmin_id', $shopadmin_id[0]->id)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }

                $quotation = Quotation::whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            } else {

                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->first();
                $client = Client::where('shopadmin_id', $shopadmin_id->id)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }

                $quotation = Quotation::whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            }


            return view('pages.quotations.list', compact('quotation'));
        }
    }



    public function get_quotation_add_page()
    {
        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile')
        {
            $id = auth()->user()->username;
    
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
            } else {
    
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
            }
    
            $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->get();
            $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->get();
    
            $sessions = Session::all();
            // return $sessions;
    
            return view('pages.quotations.quotation_form', compact('products', 'clients', 'sessions'));
        }
        else{
            $id = auth()->user()->username;
    
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
            } else {
    
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
            }
    
            $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();
            $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();
    
            $sessions = Session::all();
            // return $sessions;
    
            return view('pages.quotations.quotation_form', compact('products', 'clients', 'sessions'));
        }

    }

    public function session_add(Request $request)
    {
        $sessions = Session::all();

        // return $request->input('sell_quantity') ;

        if ($request->input('sell_quantity') > $request->input('quantity')) {

            session()->flash('alert-danger', 'Please Select Quantity less than Available Quantity!!');
            return redirect()->back()->with(['sessions' => $sessions]);
        } else {

            Session::create(
                [
                    'product_id' => $request->input('id'),
                    'quantity' => $request->input('sell_quantity'),
                    'selling_price' => $request->input('new_price')
                ]
            );

            session()->flash('alert-success', 'Product Added Successfully');
            return redirect()->back()->with(['sessions' => $sessions]);
        }
    }

    public function add_quotation(Request $request)
    {

        $sessions = Session::all();

        if (!sizeof($sessions) == 0) {

            $currentCategory = $this->getCurrentCategory();
            if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
                $shop_type = null;
            } else {
                $shop_type = $this->getCurrentCategory();
            }

            $quotation = new Quotation();
            $quotation->client_id = $request->input('client_id');
            $quotation->gst = $request->input('gst');
            $quotation->labour_charge = $request->input('labour_charge') ?? 0;
            $quotation->transportation_charge = $request->input('transportation_charge') ?? 0;
            $quotation->total_price = $request->input('total_price');
            $quotation->remaining_amount = $request->input('total_price')  - $request->input('amount_paid');
            $quotation->shop_type = $shop_type;
            $quotation->save();



            foreach ($sessions as $session) {
                QuotationProduct::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $session->product_id,
                    'quantity' => $session->quantity,
                    'selling_price' => $session->selling_price
                ]);
            }

            Session::truncate();

            session()->flash('alert-success', 'Quotation Created Successfully');
            return redirect()->back()->with(['sessions' => $sessions]);
        } else {
            session()->flash('alert-danger', 'Please add products first !!');
            return redirect()->back();
        }
    }


    public function view_pdf($id)
    {

        $quotation = Quotation::where('id', $id)->get();
        // return $client;
        $quotation_products = QuotationProduct::where('quotation_id', $id)->get();

        $signature_image = base64_encode(file_get_contents('uploads/signature/' . $quotation[0]->client->shopadmin->id . '.' . $quotation[0]->client->shopadmin->signature_image_ext));
        $profile_image = base64_encode(file_get_contents('uploads/profile/' . $quotation[0]->client->shopadmin->id . '.' . $quotation[0]->client->shopadmin->image_ext));


        $data = [
            'quotation' => $quotation,
            'quotation_products' => $quotation_products,
            'signature_image' => $signature_image,
            'profile_image' => $profile_image
        ];

        // PDF::setOptions(['isRemoteEnabled' => true ])->loadView('pages.quotations.quotation_pdf',$data)->stream('pages.quotations.quotation_pdf', array("Attachment" => false));

        // return $pdf->download($quotation[0]->client->name."-quotation.pdf");


        return view('pages.quotations.quotation_pdf', compact('quotation_products', 'quotation', 'signature_image', 'profile_image'));
    }

    public function download_pdf($id)
    {

        $quotation = Quotation::where('id', $id)->get();

        $quotation_products = QuotationProduct::where('quotation_id', $id)->get();

        $signature_image = base64_encode(file_get_contents('uploads/signature/' . $quotation[0]->client->shopadmin->id . '.' . $quotation[0]->client->shopadmin->signature_image_ext));
        $profile_image = base64_encode(file_get_contents('uploads/profile/' . $quotation[0]->client->shopadmin->id . '.' . $quotation[0]->client->shopadmin->image_ext));


        $data = [
            'quotation' => $quotation,
            'quotation_products' => $quotation_products,
            'signature_image' => $signature_image,
            'profile_image' => $profile_image
        ];

        $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadView('pages.quotations.quotation_pdf', $data);

        return $pdf->download($quotation[0]->client->name . "-quotation.pdf");


        // return view('pages.quotations.quotation_pdf',compact('quotation_products','client'));
    }


    public function delete($session)
    {
        Session::where('id', $session)->delete();
        // $session->delete();

        $sessions = Session::all();

        session()->flash('alert-success', 'Product Deleted Successfully');
        return redirect()->back()->with(['sessions' => $sessions]);
    }

    public function quotation_delete(Quotation $quotation)
    {
        $quotation->delete();
        // $quotation->delete();

        // $quotations = $quotation::all();

        session()->flash('alert-success', 'Quotation Deleted Successfully');
        return redirect()->back();
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
