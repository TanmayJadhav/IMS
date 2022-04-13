<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Reason;
use App\Models\Shopadmin;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function getListExpense(Request $requeset)
    {
        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'No Category Available') {
            $expenses = [];
            return view('pages.expense.list', compact('expenses'));
        } elseif ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;
            $expenses = Expense::where('shopadmin_id', $id)->whereMonth('date', date('m'))->where('shop_type', null)->latest()->get();
            return view('pages.expense.list', compact('expenses'));
        } else {

            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;
            $expenses = Expense::where('shopadmin_id', $id)->whereMonth('date', date('m'))->where('shop_type', $this->getCurrentCategory())->latest()->get();
            return view('pages.expense.list', compact('expenses'));
        }
    }

    public function getCreateExpense()
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        $reasons = Reason::where('shopadmin_id', $id)->where('shop_type',$shop_type)->get();
        return view('pages.expense.add', compact('reasons'));
    }

    public function postCreateExpense(Request $request)
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        Expense::create(['date' => $request->input('date'), 'reason_id' => $request->input('reason_id'),'shop_type' => $shop_type, 'amount' => $request->input('amount'), 'shopadmin_id' => $id]);
        session()->flash('alert-success', 'Expense Created Successfully');
        return redirect()->back();
    }

    public function getEditExpense(Request $request, $expenseId)
    {
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        $expense = Expense::find($expenseId);
        $reasons = Reason::where('shopadmin_id', $id)->get();

        return view('pages.expense.edit', compact('expense', 'reasons'));
    }

    public function postEditExpense(Request $request, $expenseId)
    {
        $expense = Expense::find($expenseId);
        $expense->date = $request->input('date');
        $expense->reason_id = $request->input('reason_id');
        $expense->amount = $request->input('amount');

        $expense->save();

        session()->flash('alert-success', 'Expense Edited Successfully');
        return redirect()->back();
    }

    public function deleteExpense(Request $request, $expenseId)
    {
        $expense = Expense::find($expenseId);
        $expense->delete();


        session()->flash('alert-success', 'Expense Deleted Successfully');
        return redirect()->back();
    }

    public function filterExpense(Request $request)
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }

        $this->validate($request, [
            'start_date'  => 'bail|required|date',
            'end_date'    => 'bail|required|date|after_or_equal:start_date',
        ]);

        // return $request;
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        $expenses = Expense::whereDate('created_at', '>=', $request->input('start_date'))->whereDate('created_at', '<=', $request->input('end_date'))->where('shopadmin_id', $id)->where('shop_type', $shop_type)->get();
        // return $expenses;
        return view('pages.expense.list', compact('expenses'));
    }
}
