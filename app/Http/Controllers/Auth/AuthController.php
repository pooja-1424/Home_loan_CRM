<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\data_share\data_sharing_point;
use Auth;

class AuthController extends Controller
{
    public function login()
    {        
        return view('auth.login');
    }

    public function register_view()
    {
        return view('auth.register');
    }

    public function dashboard(Request $request)
    {
        return view('widgets');      
    }

    public function login_user(Request $request)
    {
        // validate data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',        
        ],
        [          
                'email.required'=>'This Field is required',
                'password.required'=>'Password is required',           
        ]);
        
        
        // login code
        if(\Auth::attempt($request->only('email', 'password')))
        {
            $userRole = Auth::user()->getRoleNames();
            $user = User::find(Auth::user()->user_id);
            if($userRole[0] == 'Admin') { $can_be_access_users_id = []; $data_sharing_rules_id = [];}
            else
            {
                (isset($user->data_sharing_point->can_be_access_users_id)) ? $can_be_access_users_id = $user->data_sharing_point->can_be_access_users_id : $can_be_access_users_id = [];
                (!empty($user->data_sharing_point->data_sharing_rules_id) ? $data_sharing_rules_id = $user->data_sharing_point->data_sharing_rules_id : $data_sharing_rules_id = '');
                if(!empty($can_be_access_users_id)) $can_be_access_users_id = json_decode($can_be_access_users_id, true);
                /* Add a new single value to the PHP array */
                $can_be_access_users_id[] = Auth::user()->user_id;

                // $data_sharing_rules_id = $user->data_sharing_point->data_sharing_rules_id;
            }
            // dd(data_sharing_point::where('user_id', Auth::user()->user_id)->get());
            // dd($user->data_sharing_point->can_be_access_users_id);
            session([
                'Email' => $request->get('email'), 
                'data_sharing_rules_group_id' => $data_sharing_rules_id, 
                'can_be_access_users_id' => json_encode($can_be_access_users_id)
            ]);
            session()->flash('status', 'User Successfully Logged-in!');
            return redirect()->route('contacts.index');
        }

        session()->flash('status', 'incorrect username and password!');
        return redirect('/');
    }  

    public function register_user(Request $request)
    {
        // validate data
        $request->validate([
            'firstname' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed',
        ],
        [      
            'firstname.required'=>'This Field is required',    
            'email.required'=>'This Field is required',
            'password.required'=>'Password is required',       
        ]);
     
        User::create([
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'password_confirmation' => $request->password_confirmation
        ]);

        if(\Auth::attempt($request->only('email', 'password')))
        {
            session()->flash('status', 'User Register Successfully!');
            return redirect('/contacts');
        }

        session()->flash('status', 'User Not Register!');
        return redirect('register');

    }

    public function logout(Request $request)
    {
        \Session::flush();
        \Auth::logout();

        // Regenerate the session ID to enhance security
        $request->session()->regenerate();

        return redirect('/login');
    }
}
