<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Shopadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{

    public function get_operator_list()
    {
        $currentCategory = $this->getCurrentCategory();
       
        if ($currentCategory == 'No Category Available') {
            $operators = [];
            return view('pages.operators.list',compact('operators'));
        }
        elseif ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile'){
            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
            $operators = Operator::where('shopadmin_id',$shopadmin_id[0]->id)->where('shop_type', null)->latest()->get();
            
            return view('pages.operators.list',compact('operators'));
        }
        else{
            
            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
            $operators = Operator::where('shopadmin_id',$shopadmin_id[0]->id)->where('shop_type', $this->getCurrentCategory())->latest()->get();
            
            return view('pages.operators.list',compact('operators'));
        }
    }

    public function get_operator_add()
    {
        return view('pages.operators.add');
    }

    

    public function operator_add(Request $request)
    {
        $request->validate([
            "mobile" => "min:10|max:10",
            'password' => 'required',
            'confirmpassword' => 'required|same:password'
        ]);

        $mobile_number = Operator::where('mobile', $request->input('mobile'))->get();
        // return $mobile_number;
        if (sizeof($mobile_number) == 0) {

            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

            $currentCategory = $this->getCurrentCategory();
            if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
                $shop_type = null;
            } else {
                $shop_type = $this->getCurrentCategory();
            }

            Operator::insert([
                'shopadmin_id' => $shopadmin_id[0]->id,
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
                'shop_type' => $shop_type
            ]);

            User::create([
                'username' => $request->input('mobile'),
                'password' => Hash::make($request->input('password')),
                'role' => 2
            ]);

            session()->flash('alert-success', 'Data Successfully Added');
            return redirect()->back();

        } 
        
        else {
            session()->flash('alert-danger', 'Mobile Number Already Exists!!!');
            return redirect()->back();
        }

        // return view('pages.operators.add');
    }



    public function update_operator(Request $request, Operator $operator)
    {
        $operator->fill($request->input());
        $operator->save();
        // $operator->password = Hash::make($request->input('password'));
        // $operator->save();

        $user = User::where('username', $operator->mobile)->first();
        $user->password = Hash::make($request->input('password'));
        // $shopadmin->password = Hash::make($request->input('password'));
        $user->save();

        

        session()->flash('alert-success', 'Data Successfully Updated');
        return redirect()->back();
    }

    public function delete(Operator $operator)
    {
        $operator->delete();
        
        session()->flash('alert-success', 'Operator Deleted Successfully');
        return redirect()->back();
    }
}
