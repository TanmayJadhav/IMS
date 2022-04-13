<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\Operator;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Referal;
use App\Models\SellProduct;
use App\Models\Session;
use App\Models\Shopadmin;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Mockery\Undefined;

class SellProductController extends Controller
{
    public function get_sellproduct_list()
    {
        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'No Category Available') {

            $receipt = [];
            return view('pages.sellproducts.list', compact('receipt'));
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

                $receipt = Receipt::whereIn('client_id', $client_array)->where('shop_type', null)->latest()->get();
            } else {


                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->first();

                $client = Client::where('shopadmin_id', $shopadmin_id->id)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }

                $receipt = Receipt::whereIn('client_id', $client_array)->where('shop_type', null)->latest()->get();
            }



            return view('pages.sellproducts.list', compact('receipt'));
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

                $receipt = Receipt::whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            } else {


                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->first();

                $client = Client::where('shopadmin_id', $shopadmin_id->id)->get();
                $client_array = [];
                foreach ($client as $client) {
                    array_push($client_array, $client->id);
                }

                $receipt = Receipt::whereIn('client_id', $client_array)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            }



            return view('pages.sellproducts.list', compact('receipt'));
        }

        // return view('pages.sellproducts.list');
    }

    public function get_sellproduct_add_page()
    {
        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {

            $id = auth()->user()->username;

            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();

                $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();

                $sessions = Session::all();
            } else {

                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

                $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();

                $sessions = Session::all();
            }

            // return $sessions;


            return view('pages.sellproducts.sellproduct_form', compact('products', 'sessions'));
        } else {

            $id = auth()->user()->username;

            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();

                $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();

                $sessions = Session::all();
            } else {

                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

                $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();

                $referals = Referal::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', 'Special')->get();

                $sessions = Session::all();
            }

            // return $sessions;


            return view('pages.sellproducts.sellproduct_form', compact('products', 'sessions','referals'));
        }
    }



    public function add_customer_detail()
    {

        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $id = auth()->user()->username;
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                $customers = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();
            } else {

                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

                $customers = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->get();
            }
            return view('pages.sellproducts.add_customer_detail', compact('customers'));
        } else {

            $id = auth()->user()->username;
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                $customers = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();
            } else {

                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

                $customers = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->get();
            }
            return view('pages.sellproducts.add_customer_detail', compact('customers'));
        }
    }


    public function postAddCustomerDetails(Request $request)
    {
        session(['work_customer_id' => $request->customer_id]);

        return redirect('/sellproduct/add');
    }

    public function addCustomer($name, $mobile, $address)
    {
        $response = [];

        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }

        if ($mobile == 'undefined') {
            $mobile = 'Not Available';
        }
        if ($address == 'undefined') {
            $address = 'Not Available';
        }

        $customer = new Client();
        $customer->name = $name;
        $customer->mobile = $mobile;
        $customer->address = $address;
        $customer->shop_type = $shop_type;



        if (auth()->user()->role  == '0') {
            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;
            $customer->shopadmin_id = $id;
        }
        if (auth()->user()->role  == '2') {
            $operator = Operator::where('mobile', auth()->user()->username)->first();
            $shopadmin_id = Shopadmin::where('id', $operator->shopadmin_id)->first();
            $customer->shopadmin_id = $shopadmin_id->id;
        }
        $customer->save();

        $customers = Client::where('id', $customer->id)->where('shop_type', $shop_type)->get();

        $response['status'] = 'success';
        $response['customers'] = $customers;


        return $response;
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


    public function add_sellproduct(Request $request)
    {

        $sessions = Session::all();

        if (!sizeof($sessions) == 0) {

            $currentCategory = $this->getCurrentCategory();
            if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
                $shop_type = null;
            } else {
                $shop_type = $this->getCurrentCategory();
            }

            $receipt = new Receipt();
            $receipt->client_id = session('work_customer_id');
            $receipt->gst = $request->input('gst');
            $receipt->labour_charge = $request->input('labour_charge') ?? 0;
            $receipt->transportation_charge = $request->input('transportation_charge') ?? 0;
            $receipt->total_price = $request->input('total_price');
            $receipt->remaining_amount = $request->input('total_price')  - $request->input('amount_paid');
            $receipt->shop_type = $shop_type;
            $receipt->save();



            foreach ($sessions as $session) {
                SellProduct::create([
                    'receipt_id' => $receipt->id,
                    'product_id' => $session->product_id,
                    'quantity' => $session->quantity,
                    'selling_price' => $session->selling_price,
                    'shop_type'=>$shop_type,
                    'referal_name'=>!empty($request->input('referal_name'))?$request->input('referal_name') : null
                ]);

                $product_quantity = Product::select('quantity')->where('id', $session->product_id)->first();
                Product::where('id', $session->product_id)->update(['quantity' => (int)$product_quantity->quantity - (int)$session->quantity]);
            }

            Session::truncate();

            session()->flash('alert-success', 'Receipt Created Successfully');
            return redirect()->back()->with(['sessions' => $sessions]);
        } else {
            session()->flash('alert-danger', 'Please add products first !!');
            return redirect()->back();
        }
    }


    public function view_pdf($id)
    {

        $receipt = Receipt::where('id', $id)->get();
        // return $client;
        $sell_products = SellProduct::where('receipt_id', $id)->get();
        $signature_image = base64_encode(file_get_contents('uploads/signature/' . $receipt[0]->client->shopadmin->id . '.' . $receipt[0]->client->shopadmin->signature_image_ext));
        $profile_image = base64_encode(file_get_contents('uploads/profile/' . $receipt[0]->client->shopadmin->id . '.' . $receipt[0]->client->shopadmin->image_ext));


        return view('pages.sellproducts.receipt_pdf', compact('sell_products', 'receipt', 'signature_image', 'profile_image'));
    }

    public function download_pdf($id)
    {

        $receipt = Receipt::where('id', $id)->get();
        // return $receipt[0]->client->name;
        $sell_products = SellProduct::where('receipt_id', $id)->get();
        $signature_image = base64_encode(file_get_contents('uploads/signature/' . $receipt[0]->client->shopadmin->id . '.' . $receipt[0]->client->shopadmin->signature_image_ext));
        $profile_image = base64_encode(file_get_contents('uploads/profile/' . $receipt[0]->client->shopadmin->id . '.' . $receipt[0]->client->shopadmin->image_ext));


        $data = [
            'receipt' => $receipt,
            'sell_products' => $sell_products,
            'signature_image' => $signature_image,
            'profile_image' => $profile_image,
        ];

        $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadView('pages.sellproducts.receipt_pdf', $data);

        return $pdf->download($receipt[0]->client->name . "-receipt.pdf");


        // return view('pages.quotations.quotation_pdf',compact('quotation_products','client'));
    }

    public function add_referal($name)
    {
        $response = [];
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $referal = new Referal();
        $referal->name = $name;
        $referal->shop_type = $shop_type;
        $referal->shopadmin_id = $shopadmin->id;

        $referal->save();

        $referal = Referal::where('shop_type', $shop_type)->where('shopadmin_id',$shopadmin->id)->where('id',$referal->id)->get();

        $response['status'] = 'success';
        $response['referal'] = $referal;


        return $response;
    }



    public function delete($session)
    {
        Session::where('id', $session)->delete();
        // $session->delete();

        $sessions = Session::all();

        session()->flash('alert-success', 'Product Deleted Successfully');
        return redirect()->back()->with(['sessions' => $sessions]);
    }

    public function receipt_delete(Receipt $receipt)
    {
        $receipt->delete();
        // $receipt->delete();

        // $quotations = $receipt::all();

        session()->flash('alert-success', 'Receipt Deleted Successfully');
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
