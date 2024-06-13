<?php

namespace App\Http\Controllers;


use \Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Produk;
use App\Services\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{

    public function index()
    {
        $users = User::all(); // Mendapatkan semua pengguna


        if (auth()->user()->isadmin || auth()->user()->issuperadmin) {
            $produks = Produk::all();
        } else {
            $produks = Produk::where('user_id', auth()->id())->get();
        }

        return view('produk.index', [
            'title' => 'Produk',
            'produks' => $produks,
            'users' => $users
        ]);
    }





    public function create()
    {
        $user = auth()->user();

        $users = User::where('isadmin', false)->where('issuperadmin', false)->get();
        if ($user->isadmin || $user->issuperadmin) {
            $users = User::where('isadmin', false)->where('issuperadmin', false)->get();
        }


        if ($user->isadmin || $user->issuperadmin) {

            $kategoris = Kategori::all();
        } else {
            $kategoris = Kategori::where('user_id', $user->id)
                ->orWhereHas('user', function ($query) {
                    $query->where('isadmin', 1)
                        ->orWhere('issuperadmin', 2);
                })->get();
        }

        return view('produk.create', [
            'title' => 'Tambah Produk',
            'kategoris' => $kategoris,
            'users' => $users
        ]);
    }


    public function store(Request $request)
    {
        // Validasi input
        $param = $request->except('_token', 'gambar');
        $validator = Validator::make($param, [
            'kode' => 'required|max:100|min:5',
            'nama_produk' => 'required|max:200|min:5',
            'harga' => 'required',
            'stock' => 'required',
            'gambar' => 'image|file|max:1024',
            'detail' => 'required',
            'kategori_id' => 'required',
            'user_id' => 'nullable|exists:users,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        // Proses gambar
        $param['gambar'] = '';
        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $request->gambar->extension();
            $file->move(public_path('produk-images'), $filename);
            $param['gambar'] = url('produk-images') . '/' . $filename;
        }

        // Menetapkan user_id
        if (auth()->user()->issuperadmin && $request->filled('user_id')) {
            $param['user_id'] = $request->input('user_id');
        } else {
            $param['user_id'] = auth()->user()->id;
        }

        // Membuat produk
        $create = Produk::create($param);

        if ($create) {
            return redirect('produk')->with('success', 'Produk Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }


    public function edit($id)
    {
        $produk = Produk::where('kode', $id)->first();
        $user = auth()->user();

        $users = User::where('isadmin', false)->where('issuperadmin', false)->get();
        if ($user->isadmin || $user->issuperadmin) {
            $users = User::where('isadmin', false)->where('issuperadmin', false)->get();
        }

        if ($user->isadmin || $user->issuperadmin) {
            $kategoris = Kategori::all();
        } else {
            $kategoris = Kategori::where('user_id', $user->id)
                ->orWhereHas('user', function ($query) {
                    $query->where('isadmin', 1)
                        ->orWhere('issuperadmin', 2);
                })->get();
        }

        return view('produk.update', [
            'title' => 'Edit Produk ' . $produk->nama_produk,
            'produk' => $produk,
            'kategoris' => $kategoris,
            'users' => $users // Pass the users to the view
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $param = $request->except('_method', '_token', 'gambar', 'oldImage', 'gambar');
        $validator = Validator::make($param, [
            'nama_produk' => 'max:200|min:5',
            'harga' => '',
            'stock' => '',
            'gambar' => 'image|file|max:1024',
            'detail' => '',
            'kategori_id' => '',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $request->gambar->extension();
            $file->move(public_path('produk-images'), $filename);
            $param['gambar'] = url('produk-images') . '/' . $filename;
        }

        // if ($request->has('password')) {
        //     $param['password'] = Hash::make($request->input('password'));
        // }

        $update = Produk::where('kode', $id)->update($param);

        if ($update) {
            return redirect('produk')->with('success', 'User Updated');
        }
        return back()->with('error', 'User not Updated');
    }

    public function destroy($id)
    {
        Produk::where('kode', $id)->delete();
        return redirect('produk')->with('success', 'Produk Berhasil dihapus');
    }

    public function show($id)
    {
        $produk = Produk::where('kode', $id)->first();
        return view('produk.show', ['title' => 'Detail Produk', 'produk' => $produk]);
    }


    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new Produk();
        $data = $data->where('id', '!=', 1)->with('id');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $keyword = $request->input('search')['value'];
            $data = $data->where(function ($query) use ($keyword) {
                $query->where('kode', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('nama_produk', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('harga', $keyword);
            });
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['nama_produk'], $request->order[0]['dir'])->paginate($limit);


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
                $btn = '<a class="btn btn-default" href="admin/' . $data->produk_id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->user_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
