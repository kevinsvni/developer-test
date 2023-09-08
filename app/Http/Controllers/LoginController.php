<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use DB;


class LoginController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('user.login');
    }

      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('user.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email','=',$request->email)->get()[0];

        $completedLessons = DB::table('lesson_user')
                    ->select('lesson_id')
                    ->where('user_id', '=', $user->id)
                    ->get();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Session::put('user', ['useremail'=> $user->email, 'username'=> $user->name, 'id'=> $user->id, 'completedLessons'=>$completedLessons->pluck('lesson_id')->toArray()]);
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);       

        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('user.dashboard');
        }

        return redirect("login");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() 
    {
        Session::flush();
        Auth::logout();  
        return Redirect('login');
    }
}