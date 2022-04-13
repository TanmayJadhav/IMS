<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Redirect;
use App\Models\Shopadmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;

class UserController extends Controller
{

    public function getlogin()
    {
        if (auth()->user()) {
            return redirect('/dashboard');
        } else {
            return view('pages.login');
        }
    }

    public function login(Request $request)
    {

        $username = $request->input('username');
        $password = $request->input('password');

        // $remember_me = $request->input('remember_me');

        // if(isset($remember_me))
        // {   
        //     echo('true');
        //     $remember_token = true;
        // }
        // else 
        // {
        //     echo('false');
        //     $remember_token = false;
        // }

        // Auth::attempt(['username'=>$username,'password'=>$password])
        // $user = DB::table('users')
        //     ->where('username', '=', $username)
        //     ->where('password', '=', $password)
        //     ->get();

        // $newUser=User::where([['username','=',$username],['password','=', $password]])->get()  ;
        // User::create([
        //     'username' => $username,
        //     'password' => Hash::make($password),
        //     'role'=>1
        // ]);



        $user = User::where('username', $username)->first();

        if (empty($user)) {
            session()->flash('alert-danger', 'No User found . Please Register First');
            return redirect()->back();
        } else {
            if ($user->status == 1) {

                if (Auth::attempt(['username' => $username, 'password' => $password])) {

                    if($user->role == 1)
                    {
                        return redirect('/dashboard');
                    }

                    $shopadmin = Shopadmin::where('mobile', $user->username)->first();
                    

                    $permissions_arr = [];
                    $permission_id = json_decode($shopadmin->shopcategory);
                    // return $permission_id;

                    if (!empty($permission_id)) {


                        foreach ($permission_id as $permission) {
                            array_push($permissions_arr, $permission);
                        }

                        session(['currentCategory' => $permissions_arr[0]]);

                        return redirect('/dashboard');

                        
                    } else {
                        session(['currentCategory' => 'No Category Available']);

                        return redirect('/dashboard');
                    }
                } else {

                    session()->flash('alert-danger', 'Username or Password Incorrect !!');
                    return redirect()->back();
                }
            } else {
                session()->flash('alert-danger', 'You have been blocked!! Contact Admin');
                return redirect()->back();
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
