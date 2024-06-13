<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', ['title' => 'Register', 'active' => 'login']);
    }


    public function store(Request $request)
    {    //dd('no_tlp');
        //dd('no_tlp');
        // Validasi
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:100',
            'username' => 'required|min:4|max:100|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:200',
            'no_tlp' => 'required|min:6|max:15',
            'alamat' => 'required|min:6|max:500',
            // 'kode' => 'nullable|min:3',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'isadmin' => '',

        ]);

        // Enkripsi password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Penyimpanan gambar
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user-images'), $imageName);
            $validatedData['gambar'] = $imageName;
        }

        // Insert data user
        User::create($validatedData);

        // Redirect setelah berhasil
        return redirect('/login')->with('status', 'Register berhasil');
    }
}
