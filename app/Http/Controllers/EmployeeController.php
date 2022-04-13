<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\Shopadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function getListEmployee()
    {

        // $month = now()->format('M');
        // $year = now()->format('Y');
        // $slug = $month . "-" . $year;

        // $slugInMonthlySalary = MonthlySalary::where('slug', $slug)->get()->first();

        // if ($slugInMonthlySalary == null) {
        //     $button = true;
        // } else {
        //     $button = false;
        // }

        $currentCategory = $this->getCurrentCategory();

        if ($currentCategory == 'No Category Available') {
            $employees = [];
            return view('pages.employee.list', compact('employees'));
        } elseif ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;

            // $labAdmin = LabAdmin::where('user_id', auth()->user()->id)->first();
            $employees = Employee::where('shopadmin_id', $id)->where('shop_type', null)->get();
            // return view('pages.employee.list', compact('employees', 'button'));
            return view('pages.employee.list', compact('employees'));
        } else {

            $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
            $id = $shopadmin->id;

            // $labAdmin = LabAdmin::where('user_id', auth()->user()->id)->first();
            $employees = Employee::where('shopadmin_id', $id)->where('shop_type', $this->getCurrentCategory())->get();
            // return view('pages.employee.list', compact('employees', 'button'));
            return view('pages.employee.list', compact('employees'));
        }
    }


    public function getCreateEmployee()
    {
        if (Auth::user()->role != '0') {
            return redirect('/dashboard')->with('alert', "No access for this page");
        }

        return view('pages.Employee.add');
    }

    public function postCreateEmployee(Request $request)
    {
        $currentCategory = $this->getCurrentCategory();
        if ($currentCategory == 'Computer' || $currentCategory == 'Electronics' || $currentCategory == 'Mobile') {
            $shop_type = null;
        } else {
            $shop_type = $this->getCurrentCategory();
        }

        $user = User::insertGetId(['username' => $request->input('mobile'), 'password' => PASSWORD_HASH($request->get('password'), PASSWORD_BCRYPT), 'role' => 3, 'status' => 1]);
        $shopadmin = Shopadmin::where('mobile', auth()->user()->username)->first();
        $id = $shopadmin->id;
        Employee::create(['user_id' => $user, 'mobile' => $request->input('mobile'), 'name' => $request->input('name'), 'salary' => $request->input('salary'), 'salary_remaining' => $request->input('salary'), 'shop_type' => $shop_type, 'shopadmin_id' => $id]);
        session()->flash('alert-success', 'Employee Added Successfully');
        return redirect()->back();
    }

    public function getEditEmployee(Request $request, $employeeId)
    {
        if (Auth::user()->role != '0') {
            return redirect('/dashboard')->with('alert', "No access for this page");
        }

        $employee = Employee::find($employeeId);
        $user = User::find($employee->user_id);

        if ($employee == null) {
            return redirect('/Employee'); # return message user does not exists
        }

        return view('pages.employee.edit', compact('employee', 'user'));
    }

    public function postEditEmployee(Request $request, $employeeId)
    {

        $employee = Employee::find($employeeId);
        $user = User::find($employee->user_id);


        $user->username = $request->input('mobile');

        if (!empty($request->input('password'))) {
            return 0;
            $user->password = $request->input('password');
        }
        $user->save();

        $employee->mobile = $request->input('mobile');
        $employee->name = $request->input('name');
        $employee->salary = $request->input('salary');
        $employee->save();


        session()->flash('alert-success', 'Employee Updated Successfully');
        return redirect()->back();
    }

    public function deleteEmployee(Request $request, $employeeId)
    {


        $Employee = Employee::find($employeeId);
        $user = User::find($Employee->user_id);

        if ($Employee == null) {
            return redirect('/labadmin'); # return message user does not exists
        }

        $Employee->delete();
        // $user->delete();

        session()->flash('alert-success', 'Employee Deleted Successfully');
        return redirect()->back();
    }

    // public function addMonthlySalary()
    // {
    //     $month = now()->format('M');
    //     $year = now()->format('Y');
    //     $slug = $month . "-" . $year;

    //     $slugInMonthlySalary = MonthlySalary::where('slug', $slug)->get()->first();

    //     if ($slugInMonthlySalary == null) {
    //         $newSlug = MonthlySalary::create(['slug' => $slug]);
    //     } else {
    //         return redirect('/employee');
    //     }

    //     $employees = Employee::all();
    //     foreach ($employees as $employee) {
    //         $employee->remain = (int)$employee->salary + (int)$employee->remain;
    //         $employee->save();
    //     }

    //     session()->flash('alert-success', 'Employee Salary Added Successfully');
    //     return redirect()->back();
    // }

    public function makePaymentEmployee(Request $request, $employeeId)
    {

        $date = !empty($request->input('date')) ? $request->input('date') : date('Y-m-d');
        $employee = Employee::find($employeeId);

        $employee->salary_remaining -= $request->input('amount');
        $employee->save();

        $payment = Payment::create(['employee_id' => $employeeId, 'date' => $date, 'amount_paid' => $request->input('amount')]);
        session()->flash('alert-success', 'Payment Added Successfully');
        return redirect()->back();
    }

    public function paymentDetailsEmployee(Request $request, $employeeId)
    {
        $employee = Employee::find($employeeId);
        // if (auth()->user()->role == '3'){
        //     $loggedUserEmployeeId = Employee::where('user_id',auth()->user()->id)->first()->id;

        //     if ($loggedUserEmployeeId != $employeeId){
        //         return redirect('employee/paymentdetails/'.$loggedUserEmployeeId);
        //     }
        // }
        $payments = Payment::where('employee_id', $employeeId)->get();

        return view('pages.employee.payment_details', compact('payments', 'employee'));
    }
}
