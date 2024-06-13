<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\DataTables;

class ProfilController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        return view('profil.index', ['user' => $user, 'title' => 'Profil',]);
    }


    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');
        $validator = Validator::make($param, [
            'name' => 'required|min:2|max:100',
            'username' => 'required|min:4|max:100|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:200',
            'no_tlp' => 'required|min:6|max:15',
            'alamat' => 'required|min:6|max:500',
            // 'kode' => 'nullable|min:3',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $param['gambar'] = '';
        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $request->gambar->extension();
            $file->move(public_path('user-images'), $filename);
            $param['gambar'] = url('images') . '/' . $filename;
        }

        User::create($param);
        $param['user_id'] = auth()->user()->id;
        return redirect()->route('profil.index')->with('success', 'Profil berhasil disimpan.');
    }



public function edit($id)
{
    $user = User::find($id);
    return view('profil.update', ['user' => $user, 'title' => 'edit profil']);
}



    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return back()->with('error', 'Profil tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'no_tlp' => 'required|min:6|max:15',
            'alamat' => 'required|min:6|max:500',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $param = $request->except('_method', '_token');

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('user-images'), $filename);
            // Menggunakan nama file yang diunggah untuk kolom gambar
            $param['gambar'] = $filename;
        } else {
            // Jika tidak ada gambar baru diunggah, gunakan gambar yang ada sebelumnya
            $param['gambar'] = $user->gambar;
        }

        $update = $user->update($param);

        if ($update) {
            return redirect('profil')->with('success', 'Profil berhasil diperbarui.');
        }
        return back()->with('error', 'Gagal memperbarui profil.');
    }


    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new User();
        $data = $data->where('id', '!=', 1)->with('id');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('id', 'LIKE', '%' . $request->keyword . '%')->orWhere('name', 'LIKE', '%' . $request->keyword . '%')
                ->whereHas('role', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->keyword . '%');
                });
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])->paginate($limit);


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
