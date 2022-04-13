<?php

namespace App\Http\Controllers;


use App\Models\Shop;
use App\Models\Shopadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function get_profile_page($id)
    {
        $username = auth()->user()->username;
        $shopadmin = Shopadmin::where('mobile', $username)->get();
        if ($shopadmin[0]->id == $id) {
            return view('pages.profile.profile', compact('shopadmin'));
        } else {
            return redirect()->back();
        }
    }


    public function edit_profile(Request $request, $id)
    {
        

        $request->validate([
            'profilephoto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'signaturephoto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profilephoto') )
        {
            $image_ext = $request->profilephoto->extension();
            $request->profilephoto->move(public_path('uploads/profile'), $id . '.' . $image_ext);
            
        }
        if ($request->hasFile('signaturephoto'))
        {
            $signature_image_ext = $request->signaturephoto->extension();
            $request->signaturephoto->move(public_path('uploads/signature'), $id . '.' . $signature_image_ext);
        }

        // DB::table($tablename)
        // ->where('id', $id)
        // ->update(['image_ext_ext'=>$imageExtension]);



        $shopadmin = Shopadmin::find($id);
        $shopadmin->ownername = $request->input('ownername');
        if (!$request->input('password') == null) {
            $shopadmin->password = $request->input('password');
        }
        if ($request->hasFile('profilephoto'))
        {

            $shopadmin->image_ext = $image_ext;
        }
        if ($request->hasFile('signaturephoto'))
        {

            $shopadmin->signature_image_ext = $signature_image_ext;
        }
        $shopadmin->save();

        if (!$request->input('password') == null) {
            $request->validate([
                'password' => 'required',
                'confirmpassword' => 'required|same:password'
            ]);

            $user = User::where('username', $shopadmin->mobile)->first();
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }


        $shop = Shop::find($shopadmin->shop_id);
        $shop->name = $request->input('shopname');
        $shop->save();

        session()->flash('alert-success', 'Data Successfully Updated');

        return redirect()->back();
    }

    public function profile_image(Request $request, $id)
    {
        $shopadmin = Shopadmin::find($id);
    }
}
