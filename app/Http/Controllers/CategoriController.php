<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isadmin || $user->issuperadmin) {
            $kategoris = Kategori::all();
        } else {
            $kategoris = Kategori::where('user_id', $user->id)
                                 ->orWhereHas('user', function ($query) {
                                     $query->where('isadmin', 1)
                                           ->orWhere('issuperadmin', 2);
                                 })->get();
        }

        return view('categori.index', [
            'title' => 'Kategori produk',
            'kategoris' => $kategoris
        ]);
    }



    public function create()
    {

        return view('categori.create', ['title' => 'Tambah Kategori produk','kategoris' => Kategori::all(), 'produks' => produk::all()]);



    }

    function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');
        $param['user_id'] = auth()->id(); // Menyimpan ID pengguna yang saat ini masuk
        $validator = Validator::make($param, [
            'kode' => 'required',
            'kategori' => 'required',
        ]);
        if ($validator->fails()) {

            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        $create = Kategori::create($param);

        if ($create) {
            return redirect('categori')->with('success', 'Kategori Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect('categori')->with('error', 'Kategori tidak ditemukan');
        }

        if ($user->issuperadmin || $user->isadmin || $kategori->user_id == $user->id) {
            $kategori->delete();
            return redirect('categori')->with('success', 'Kategori Berhasil dihapus');
        } else {
            return redirect('categori')->with('error', 'Anda tidak memiliki izin untuk menghapus kategori ini');
        }
    }

public function edit($id)
{
    $kategori = Kategori::findOrFail($id);
    return view('categori.update', ['title' => 'Edit kategori ' . $kategori->id, 'kategori' => $kategori]);
}

public function update(Request $request, $id)
{
    $param = $request->except('_method', '_token', 'gambar', 'oldImage');
    $validator = Validator::make($param, [
        'kode' => 'required',
        'kategori' => 'required', // Corrected 'katgeori' to 'kategori'
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    Kategori::where('id', $id)->update($param);

    return redirect('/categori')->with('success', 'Kategori Updated');
}


    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new Kategori();
        $data = $data->where('id', '!=', 1)->with('id');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('kode', 'LIKE', '%' . $request->keyword . '%')->orWhere('kategori', 'LIKE', '%' . $request->keyword . '%')
                ->whereHas('role', function ($query) use ($request) {
                    $query->where('kategori', 'LIKE', '%' . $request->keyword . '%');
                });
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['kategori'], $request->order[0]['dir'])->paginate($limit);


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
