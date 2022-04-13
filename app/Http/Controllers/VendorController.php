<?php

namespace App\Http\Controllers;

use App\Models\Productcategory;
use App\Models\Shopadmin;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{

    public function vendorlist(){

        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'No Category Available') {
        
            $vendors = [];
            return view('pages.vendors.list',compact('vendors'));
        }
        elseif($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile')
        {
            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile',$id)->get();
            
            $vendors = Vendor::where('shopadmin_id',$shopadmin_id[0]->id)->where('shop_type',null)->latest()->get();
            
            return view('pages.vendors.list',compact('vendors'));
        }
        else{

            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile',$id)->get();
            
            $vendors = Vendor::where('shopadmin_id',$shopadmin_id[0]->id)->where('shop_type',$this->getCurrentCategory())->latest()->get();
            
            return view('pages.vendors.list',compact('vendors'));
        }


    }


    public function addvendor(Request $request)
    {

        $mobile_number = Vendor::where('mobile',$request->input('mobile'))->get();
        // return $mobile_number;
        $currentCategory = $this->getCurrentCategory();
        if ( sizeof($mobile_number)==0 ) {

            if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
                $shop_type = null;
            } else {
                $shop_type = $this->getCurrentCategory();
            }
            Vendor::create([
             'shopadmin_id'=> $request->input('shopadmin_id'),
             'name'=>$request->input('vendorname'),
             'mobile'=>$request->input('mobile'),
             'product_category_id'=>$request->input('product_category_id'),
             'address'=>$request->input('address'),             
             'shop_type'=> $shop_type
            ]);
            session()->flash('alert-success', 'Data Successfully Saved');
            return redirect()->back();
        }

        else
        {
            session()->flash('alert-danger','Mobile Number Already Exists!!!' );
            return redirect()->back();
        }
    }



    public function update(Request $request, Vendor $vendors)
    {
        $vendors->fill($request->input());
        $vendors->save();

        return redirect()->back()->with('alert', 'Updated Successfully');
    }



    public function get_addproductcategory_page(Request $request)
    {
        // return $request->input('shopadmin_id');
        $id = auth()->user()->username;
        $shopadmin_id = Shopadmin::select('id')->where('mobile',$id)->get();
        $productcategory = Productcategory::where('shopadmin_id',$shopadmin_id[0]->id)->get();
        // return $productcategory;
        return view('pages.vendors.addproductcategory',compact('productcategory'));
    }


    public function addproductcategory($category)
    {
        $response = [];

        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }

        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        $categoryId = Productcategory::insertGetId([
            'shopadmin_id'=> $id,
            'name'=>$category,
            'shop_type'=>$shop_type,
           ]);

        $productcategory = Productcategory::where('id',$categoryId)->where('shop_type',$shop_type)->get();
        $response['status'] = 'success';
        $response['category'] = $productcategory;


        return $response;
    }

    // public function addproductcategory(Request $request)
    // {
    //     // return $request->input('shopadmin_id');
    //     Productcategory::insert([
    //         'shopadmin_id'=> $request->input('shopadmin_id'),
    //         'name'=>$request->input('categoryname'),
    //        ]);
   
    //        return redirect()->back()->with('alert', 'Sucessfully Registered');
    // }

    public function delete_productcategory($productcategory)
    {
        Productcategory::where('id',$productcategory)->delete();

        return redirect('/vendors/addproductcategory')->with('alert', 'Deleted Successfully');
    }

    public function delete(Vendor $vendors)
    {
        $vendors->delete();

        return redirect('/vendors')->with('alert', 'Deleted Successfully');
    }
}
