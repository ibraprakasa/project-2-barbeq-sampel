<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('home', ['title'=>'Login', 'active'=>'login']);
    }

    public function authenticate(Request $request){
        //@dd($request);
        //validasi laravel//
        $validate = $request->validate(
            [
                'email'=>'required',
                'password'=>'required'
            ]
        );

        //cek jika sudah berhasil login
        if(Auth::attempt($validate)){
            //buat baru session
            $request->session()->regenerate();
            //direct ke halaman admin
            return redirect('/dashboard');
        }



        //jika gagal login
        return back()->with('loginError','Login Gagal, Periksa Kembali Email dan Password');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
