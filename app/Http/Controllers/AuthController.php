<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $username = $request->username;
        $password = $request->password;

        // Akun BOS
        if($username == 'manager' && $password == 'manager'){
            Session::put('login', true);
            Session::put('username', 'admin');
            Session::put('role', 'admin'); // role admin
            return redirect('/')->with('success','Login Admin!');
        }

        // Akun KASIR
        if($username == 'kasir' && $password == 'kasir'){
            Session::put('login', true);
            Session::put('username', 'kasir');
            Session::put('role', 'kasir'); // role kasir
            return redirect('/')->with('success','Login Kasir!');
        }

        return back()->with('error','Username / Password salah!');
    }

    public function logout(){
        Session::flush();
        return redirect('/login');
    }
}
