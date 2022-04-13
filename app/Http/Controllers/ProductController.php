<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\AddProductCategory;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Shopadmin;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function productlist()
    {
        $currentCategory = $this->getCurrentCategory();


        if ($currentCategory == 'No Category Available') {
            $products = [];
            return view('pages.products.list', compact('products'));
        }
        elseif($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile')
        {
            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

            $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type',null)->orderBy('created_at', 'desc')->get();

            return view('pages.products.list', compact('products'));
        }
        else {

            $id = auth()->user()->username;
            $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();

            $products = Product::where('shopadmin_id', $shopadmin_id[0]->id)->where('shop_type',$this->getCurrentCategory())->orderBy('created_at', 'desc')->get();

            return view('pages.products.list', compact('products'));
        }
    }

    public function get_addproduct()
    {
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->get();

        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $categories = AddProductCategory::where('shopadmin_id',$shopadmin[0]->id)->where('type',$shop_type)->get();

        $shopnames = Shop::where('id', $shopadmin[0]->shop_id)->get();

        $vendors = Vendor::where('shopadmin_id', $shopadmin[0]->id)->get();
        // return $vendors;


        return view('pages.products.add', compact('shopnames', 'vendors','categories'));
    }

    public function addproduct(Request $request)
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $product = new Product();
        $product->fill($request->input());
        $product->shop_type = $shop_type;
        $product->save();
        

        $id = auth()->user()->username;
        $shopadmin_id = Shopadmin::select('id')->where('mobile', $id)->get();
        $product->shopadmin_id = $shopadmin_id[0]->id;

        $product->save();

        session()->flash('alert-success', 'Data Successfully Saved');
        return redirect()->back();
    }


    public function get_productedit(Product $product)
    {

        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->get();
        $shopnames = Shop::where('id', $shopadmin[0]->shop_id)->get();
        $vendors = Vendor::where('shopadmin_id', $shopadmin[0]->id)->where('shop_type',$shop_type)->get();

        $categories = AddProductCategory::where('shopadmin_id',$shopadmin[0]->id)->where('type',$shop_type)->get();

        return view('pages.products.edit', ['product' => $product, 'shopnames' => $shopnames, 'vendors' => $vendors, 'categories' => $categories]);
    }

    public function update_product(Request $request, Product $product)
    {
        // return $request;
        $product->fill($request->input());
        $product->save();

        return redirect()->back()->with('alert', 'Updated Successfully');
    }

    public function add_category($name)
    {
        $response = [];
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $category = new AddProductCategory();
        $category->name = $name;
        $category->type = $shop_type;
        $category->shopadmin_id = $shopadmin->id;



        // if (auth()->user()->role  == '0') {
        //     $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        //     $id = $shopadmin->id;
        //     $category->shopadmin_id = $id;
        // }
        // if (auth()->user()->role  == '2') {
        //     $operator = Operator::where('mobile', auth()->user()->username)->first();
        //     $shopadmin_id = Shopadmin::where('id', $operator->shopadmin_id)->first();
        //     $category->shopadmin_id = $shopadmin_id->id;
        // }

        $category->save();

        $categories = AddProductCategory::where('type', $shop_type)->where('shopadmin_id',$shopadmin->id)->where('id',$category->id)->get();

        $response['status'] = 'success';
        $response['categories'] = $categories;


        return $response;
    }

    public function fileImport(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file')->store('temp'));
        session()->flash('alert-success', 'Data Successfully Imported');
        return redirect()->back();
    }


    public function get_info()
    {
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();

        // $currentCategory = $this->getCurrentCategory();
        // if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            // $shop_type = null;
            $vendors = Vendor::where('shopadmin_id',$shopadmin->id)->get();

        // } else {
            // $shop_type = $currentCategory;
            $vendors = Vendor::where('shopadmin_id',$shopadmin->id)->get();
        // }

        return view('pages.products.info', ['shopId' => $shopadmin->shop_id, 'shopadmin_id' => $shopadmin->id, 'vendors' => $vendors]);


    }

    public function delete(Product $product)
    {
        $product->delete();

        return redirect('/product')->with('alert', 'Deleted Successfully');
    }
}
