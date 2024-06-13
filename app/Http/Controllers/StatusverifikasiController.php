<?php

namespace App\Http\Controllers;

use App\Models\Statusverifikasi;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('Statusverifikasi.index');
    }


}
