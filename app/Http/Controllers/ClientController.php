<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Operator;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\Shopadmin;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function clientlist()
    {
        $id = auth()->user()->username;

        $currentCategory = $this->getCurrentCategory();


        if ($currentCategory == 'No Category Available') {

            $clients = [];

            return view('pages.clients.list', compact('clients'));
        } elseif ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->latest()->get();
            } else {
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', null)->latest()->get();
            }
            return view('pages.clients.list', compact('clients'));
        } else {
            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            } else {
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

                $clients = Client::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            }
            return view('pages.clients.list', compact('clients'));
        }
    }

    public function addclient(Request $request)
    {

        $mobile_number = Client::where('mobile', $request->input('mobile'))->get();
        // return $mobile_number;
        if (sizeof($mobile_number) == 0) {

            $currentCategory = $this->getCurrentCategory();
            if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
                $shop_type = null;
            } else {
                $shop_type = $this->getCurrentCategory();
            }
            $client = new Client();
            $client->fill($request->input());
            $client->shop_type = $shop_type;
            $client->save();

            $id = auth()->user()->username;

            if (auth()->user()->role == '2') {
                $operator = Operator::where('mobile', $id)->get();
                $shopadmin_id = Shopadmin::where('id', $operator[0]->shopadmin_id)->get();
                $client->shopadmin_id = $shopadmin_id[0]->id;
            } else {
                $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
                $client->shopadmin_id = $shopadmin_id[0]->id;
            }

            $client->save();

            session()->flash('alert-success', 'Data Successfully Saved');
            return redirect()->back();
        } else {
            session()->flash('alert-danger', 'Mobile Number Already Exists!!!');
            return redirect()->back();
        }
    }

    public function view_client($client_id)
    {
        // $id = auth()->user()->username;
        // $shopadmin_id = Shopadmin::select('id')->where('mobile',$id)->get();

        $currentCategory = $this->getCurrentCategory();
        if (($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile')) {
            $clients = Receipt::where('client_id', $client_id)->where('shop_type', null)->get();
        } else {
            $clients = Receipt::where('client_id', $client_id)->where('shop_type', $this->getCurrentCategory())->get();
        }


        return view('pages.clients.remaining_amount', compact('clients'));
    }

    public function update_client(Request $request, Client $client)
    {
        $client->fill($request->input());
        $client->save();

        session()->flash('alert-success', 'Data Successfully Updated');
        return redirect()->back();
    }

    public function make_payment(Request $request)
    {

        $payment = new Payment();
        $payment->client_id =  $request->input('client_id');
        $payment->amount_paid = $request->input('amount');
        $payment->date = $request->input('date');
        $payment->save();

        session()->flash('alert-success', 'Payment Successful');
        return redirect()->back();
    }

    public function payment_details($client_id)
    {
        $remaining_amount = 0;
        $amount_paid = 0;

        $receipt = Receipt::where('client_id', $client_id)->get();
        foreach ($receipt as $receipt) {
            $remaining_amount = $remaining_amount + $receipt->remaining_amount;
        }

        // amount paid
        $payments = Payment::where('client_id', $client_id)->get();

        foreach ($payments as $payment) {
            $amount_paid = $amount_paid + $payment->amount_paid;
        }

        $remaining_amount = $remaining_amount - $amount_paid;

        return view('pages.clients.paymentdetails', compact('remaining_amount', 'payments', 'client_id'));
    }


    public function delete(Client $client)
    {
        $client->delete();

        session()->flash('alert-success', 'Deleted Successfully ');
        return redirect('/client');
        // return redirect('/client')->with('alert', 'Deleted Successfully');
    }
}
