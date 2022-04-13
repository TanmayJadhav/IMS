<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Shopadmin;
use App\Models\Shopcategory;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;


// use Excel ;

class ShopAdminController extends Controller
{

    public function shopadminlist()
    {
        $shop_admins = Shopadmin::orderBy('created_at', 'DESC')->get();
        return view('pages.shopadmin.shopadminlist',compact('shop_admins'));
    }

    public function get_addshopadmin(Request $request)
    {

        $countries = DB::table("countries")->pluck("name", "id");

        return view('pages.shopadmin.addshopadmin', compact('countries'));
    }

    public function getstatelist($id)
    {
        $states = DB::table("states")
            ->where("country_id", $id)
            ->pluck("name", "id");


        return response()->json($states);
    }

    public function getcitylist($id)
    {
        $cities = DB::table("cities")
            ->where("state_id", $id)
            ->pluck("name", "id");
        return response()->json($cities);
    }

    public function addshopadmin(Request $request)
    {
        
        $request->validate([
            "mobile" => "min:10|max:10",
            'password' => 'required',
            'confirmpassword' => 'required|same:password'
        ]);

        $mobile_number = User::where('username', $request->input('mobile'))->get();
        // return $mobile_number;
        if (sizeof($mobile_number) == 0) {

            $shopid = Shop::insertGetId(['name' => $request->input('shopname')]);

            if (Shopadmin::insert([
                'shop_id' => $shopid,
                'shopcategory' => json_encode($request->input('shopcategory')),
                'ownername' => $request->input('ownername'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'password' => $request->input('password'),
                'permission' => json_encode($request->input('permission'))
            ])) {
                // Create new user
                User::create([
                    'username' => $request->input('mobile'),
                    'password' => Hash::make($request->input('password')),
                    'role' => 0
                ]);
                session()->flash('alert-success', 'Data Successfully Saved');
                return redirect()->back();
            } else {
                session()->flash('alert-danger', 'Error !!! Try Again Later');
                return redirect()->back();
            }
        } 
        else {
            session()->flash('alert-danger', 'Mobile Number Already Exists!!!');
            return redirect()->back();
        }
    }

    public function update(Request $request, Shopadmin $shopadmin)
    {

        $shopadmin->fill($request->input());
        $shopadmin->save();

        $user = User::where('username', $shopadmin->mobile)->first();
        $user->password = Hash::make($request->input('password'));
        // $shopadmin->password = Hash::make($request->input('password'));
        $user->save();


        session()->flash('alert-success', 'Data Successfully Updated');
        return redirect()->back();
    }

    public function delete(Shopadmin $shopadmin)
    {
        $shopadmin->delete();

        session()->flash('alert-success', 'Data Successfully Deleted');
        return redirect('/shopadmin');
    }

    public function block(Shopadmin $shopadmin)
    {


        $loginuser = User::where('username', $shopadmin->mobile)->get();


        if ($loginuser[0]->status == 1) {
            $user = User::find($loginuser[0]->id);

            $user->status = 0;
            $user->save();
        } else {

            $user = User::find($loginuser[0]->id);

            $user->status = 1;
            $user->save();
        }

        return redirect('/shopadmin')->with('alert', 'Deleted Successfully');
    }



    // Shop Category

    public function add_shopcategory(Request $request)
    {
        Shopcategory::insert([
            'name' => $request->input('shopcategory'),
        ]);

        session()->flash('alert-success', 'Data Successfully Added');
        return redirect('/shopcategory/add');
    }

    public function edit_shopcategory(Request $request, Shopcategory $shopcategory)
    {

        $shopcategory->fill($request->input());
        $shopcategory->save();

        session()->flash('alert-success', 'Data Successfully Updated');
        return redirect()->back();
    }

    public function shopcategory_delete(Shopcategory $shopcategory)
    {
        $shopcategory->delete();

        session()->flash('alert-success', 'Data Successfully Deleted');
        return redirect('/shopcategory');
    }

}
