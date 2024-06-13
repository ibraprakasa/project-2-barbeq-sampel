<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Expedisi;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpedisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expedisis = Expedisi::all();
        return view('expedisi.index', [
            'title' => 'Expedisi',
            'expedisis' => $expedisis,
        ]);
    }



    public function create()
    {

        return view('expedisi.create', ['title' => 'Tambah Expedisi','expedisis' => Expedisi::all()]);



    }

    function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');
        $validator = Validator::make($param, [
            'expedisi' => 'required',
            'harga' => 'required',

        ]);
        if ($validator->fails()) {

            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        $create = Expedisi::create($param);

        if ($create) {
            return redirect('expedisi')->with('success', 'expedisi Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }



    public function destroy($id)
    {
        Expedisi::where('id', $id)->delete();
        return redirect('expedisi')->with('success', 'Expedisi Berhasil dibatalkan');
    }



    public function edit($id)
    {
        $expedisi = Expedisi::findOrFail($id);
        return view('expedisi.update', ['title' => 'Edit expedisi ' . $expedisi->id, 'expedisi' => $expedisi]);
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');
        $validator = Validator::make($param, [
              'expedisi' => 'required',
              'harga' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Expedisi::where('id', $id)->update($param);

        return redirect('expedisi')->with('success', 'expedisi Updated');
    }




    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new Expedisi();
        $data = $data->where('id', '!=', 1)->with('id');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('kode', 'LIKE', '%' . $request->keyword . '%')->orWhere('expedisi', 'LIKE', '%' . $request->keyword . '%')
                ->whereHas('role', function ($query) use ($request) {
                    $query->where('expedisi', 'LIKE', '%' . $request->keyword . '%');
                });
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['expedisi'], $request->order[0]['dir'])->paginate($limit);


        $data = json_encode($data);
        $data = json_Decode($data);

        return DataTables::of($data->data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('gambar', function ($data) {
                return '<img src="' . $data->gambar . '" class="img-circle" style="width:50px">';
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
