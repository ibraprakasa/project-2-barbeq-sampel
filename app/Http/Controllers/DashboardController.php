<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Memeriksa apakah user sudah login
        if (Auth::check()) {
            $user = Auth::user(); // Mendapatkan user yang sedang login
            return view('dashboard.index', compact('user'));
        }

        // Redirect jika user belum login
        return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman dashboard.');
    }
}
