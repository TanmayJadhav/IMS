<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use App\Models\Shopadmin;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function getListReason()
    {
        $currentCategory = $this->getCurrentCategory();
       

        if ($currentCategory == 'No Category Available') {
            $reasons = [];
            return view('pages.reason.list', compact('reasons'));
        }
        elseif ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile')
        {
            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;
            $reasons = Reason::where('shopadmin_id',$id)->where('shop_type', null)->get();
            return view('pages.reason.list', compact('reasons'));
        }
        else{

            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;
            $reasons = Reason::where('shopadmin_id',$id)->where('shop_type', $this->getCurrentCategory())->get();
            return view('pages.reason.list', compact('reasons'));
        }
    }

    public function getCreateReason()
    {
        return view('pages.reason.add');
    }

    public function postCreateReason(Request $request)
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        Reason::create(['reason' => $request->input('name'), 'shopadmin_id' => $id,'shop_type' => $shop_type]);
        session()->flash('alert-success', 'Reason Created Successfully');
        return redirect()->back();
    }

    public function getEditReason(Request $request, $reasonId)
    {
        $reason = Reason::find($reasonId);
        return view('pages.reason.edit', compact('reason'));
    }

    public function postEditReason(Request $request, $reasonId)
    {
        $reason = Reason::find($reasonId);
        $reason->reason = $request->input('name');
        $reason->save();

        session()->flash('alert-success', 'Reason Edited Successfully');
        return redirect()->back();
    }

    public function deleteReason(Request $request, $reasonId)
    {
        $reason = Reason::find($reasonId);
        $reason->delete();

        session()->flash('alert-success', 'Reason Deleted Successfully');
        return redirect()->back();
    }
}
