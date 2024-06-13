<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Bayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use App\Http\Requests\StoreKategoriRequest;
// use App\Http\Requests\UpdateKategoriRequest;

class BayarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pesanan.index');
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cara-bayar' => 'required',
           
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $param = $request->except('_token', 'gambar');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bayar-images'), $filename);
            $param['gambar'] = url('bayar-images') . '/' . $filename;
        }

        $create = Bayar::create($param);

        if ($create) {
            return redirect('pesanan')->with('success', 'bayar Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new Bayar();
        $data = $data->where('id', '!=', 1)->with('id');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('kode', 'LIKE', '%' . $request->keyword . '%')->orWhere('pesanan_id', 'LIKE', '%' . $request->keyword . '%')
                ->whereHas('role', function ($query) use ($request) {
                    $query->where('pesanan_id', 'LIKE', '%' . $request->keyword . '%');
                });
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['pesanan_id'], $request->order[0]['dir'])->paginate($limit);


        $data = json_encode($data);
        $data = json_Decode($data);

        return DataTables::of($data->data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('gambar', function ($data) {
                if ($data->gambar) {
                    return '<img src="' . $data->gambar . '" class="img-circle" style="width:50px">';
                } else {
                    return 'No Image';
                }
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="admin/' . $data->user_id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->user_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
