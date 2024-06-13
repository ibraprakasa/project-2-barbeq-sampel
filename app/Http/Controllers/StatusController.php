<?php

namespace App\Http\Controllers;

use App\Models\Status;
// use App\Http\Requests\StoreStatusRequest;
// use App\Http\Requests\UpdateStatusRequest;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('Status.index');
    }

   
}
