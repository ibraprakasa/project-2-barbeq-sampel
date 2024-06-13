<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PenjualController extends Controller
{
    public function index()
    {
        // Ambil semua user yang bukan admin atau superadmin
        $users = User::where('isadmin', false)
                     ->where('issuperadmin', false)
                     ->get();

        // Ambil pesanan yang terkait dengan user (penjual)
        $pesanans = Pesanan::whereIn('user_id', $users->pluck('id')->all())->get();

        return view('penjual.index', [
            'title' => 'Data Penjual',
            'users' => $users,
            'pesanans' => $pesanans // Kirim pesanan ke view
        ]);
    }

    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');
        $validator = Validator::make($param, [
            'name' => 'required|max:100|min:5',
            'alamat' => 'required|max:200|min:5',
            'no_tlp' => 'required',
            'gambar' => 'image|file|max:1024',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        $param['gambar'] = '';
        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $request->gambar->extension();
            $file->move(public_path('produk-images'), $filename);
            $param['gambar'] = url('produk-images') . '/' . $filename;
        }

        $param['user_id'] = auth()->user()->id;
        $create = User::create($param);

        if ($create) {
            return redirect('User')->with('success', 'User Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        // Ambil pesanan yang terkait dengan user (penjual)
        $pesanans = Pesanan::where('user_id', $id)->get();

        // Hitung total pendapatan dari pesanan yang terkait dengan pengguna ini
        $totalPendapatan = Pesanan::where('user_id', $id)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('status_id', 3)
                        ->where('bayar_id', 1);
                })
                    ->orWhere(function ($query) {
                        $query->where('status_id', 3)
                            ->where('bayar_id', '>', 1)
                            ->where('statusverifikasi_id', 2);
                    });
            })
            ->sum('harga');

        return view('penjual.show', [
            'title' => 'Detail Penjual',
            'user' => $user,
            'pesanans' => $pesanans, // Kirim pesanan ke view
            'totalPendapatan' => $totalPendapatan,
        ]);
    }


    public function destroy($id)
    {
        $userToDelete = User::find($id);

        if (!$userToDelete) {
            return redirect('penjual')->with('error', 'User tidak ditemukan');
        }

        $currentUser = auth()->user();

        if ($currentUser->issuperadmin || $currentUser->isadmin) {
            $userToDelete->delete();
            return redirect('penjual')->with('success', 'User berhasil dihapus');
        } else {
            return redirect('penjual')->with('error', 'Anda tidak memiliki izin untuk menghapus user ini');
        }
    }

    public function fnGetData(Request $request)
    {
        $data = User::where('isadmin', false)
                    ->where('issuperadmin', false)
                    ->where('id', '!=', 1);

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('id', 'LIKE', '%' . $request->keyword . '%')
                         ->orWhere('name', 'LIKE', '%' . $request->keyword . '%')
                         ->whereHas('role', function ($query) use ($request) {
                             $query->where('name', 'LIKE', '%' . $request->keyword . '%');
                         });
        }

        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])->paginate($limit);

        $data = json_encode($data);
        $data = json_decode($data);

        return DataTables::of($data->data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('gambar', function ($data) {
                return '<img src="' . $data->gambar . '" class="img-circle" style="width:50px">';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="admin/' . $data->id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
