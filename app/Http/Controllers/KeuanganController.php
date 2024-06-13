<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Bayar;
use App\Models\Expedisi;
use App\Models\Statusverifikasi;
use App\Models\Rekening;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pembeli;
use App\Models\Pesanan;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KeuanganController extends Controller
{
    public function index()
    {
        // Mendapatkan role user yang sedang login
        $isAdmin = auth()->user()->isadmin;
        $isSuperAdmin = auth()->user()->issuperadmin;


        if ($isAdmin || $isSuperAdmin) {
            $pesanans = Pesanan::where('status_id', 3)
                ->where('bayar_id', '>', 1)
                ->where('statusverifikasi_id', 2)
                ->get();
        } else {
            $pesanans = Pesanan::where('user_id', auth()->id())
                ->where('status_id', 3)
                ->get();
        }


        $pesanans->load(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar', 'status', 'user', 'expedisi']);

        $totalall = Pesanan::where(function ($query) {
            $query->where(function ($query) {
                $query->where('status_id', 3)
                    ->where('bayar_id', 1);
            })
                ->orWhere(function ($query) {
                    $query->where('status_id', 3)
                        ->where('bayar_id', '>', 1)
                        ->where('statusverifikasi_id', 2);
                });
        })->sum('harga');


        $user_id = auth()->id();
        $totalPendapatan = Pesanan::where('user_id', $user_id)
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


        $user_id = auth()->id();
        $totalcod = Pesanan::where('user_id', $user_id)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('status_id', 3)
                        ->where('bayar_id', 1);
                });
            })
            ->sum('harga');


        $user_id = auth()->id();
        $totaltransfer = Pesanan::where('user_id', $user_id)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('status_id', 3)
                        ->where('bayar_id', '>', 1)
                        ->where('statusverifikasi_id', 2);
                });
            })
            ->sum('harga');



        return view('keuangan.index', [
            'title' => 'Pemasukan/Setor',
            'pesanans' => $pesanans,
            'pembelis' => Pembeli::all(),
            'statusverifikasis' => Statusverifikasi::all(),
            'users' => User::all(),
            'produks' => Produk::all(),
            'rekenings' => Rekening::all(),
            'bayars' => Bayar::all(),
            'statuss' => Status::all(),
            'expedisis' => Expedisi::all(),
            'totalPendapatan' => $totalPendapatan,
            'totalcod' => $totalcod,
            'totaltransfer' => $totaltransfer,
            'totalall' => $totalall,
        ]);
    }


    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar', 'gambar2');

        // Validasi
        $validator = Validator::make($param, [
            'gambar' => 'nullable|image|file|max:1024',
            'gambar2' => 'nullable|image|file|max:1024',
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'harga' => 'required',
            'jumlah_produk' => 'required',
            'alamat' => 'required',
            'user_id' => 'required',
            'status_id' => 'exists:statuss,id',
            'bayar_id' => 'required',
            'statusverifikasi_id' => 'exists:statusverifikasis,id',
            'rekening_id' => 'required',
            'expedisi_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $rekening = Rekening::where('user_id', $request->input('user_id'))->first();

        if (!$rekening) {
            return back()->with('error', 'Rekening tidak ditemukan.');
        }

        $param['rekening_id'] = $rekening->id;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bayar-images'), $filename);
            $param['gambar'] = 'bayar-images/' . $filename;
        }

        if ($request->hasFile('gambar2')) {
            $file2 = $request->file('gambar2');
            $filename2 = time() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('-images'), $filename2);
            $param['gambar2'] = 'setor-images/' . $filename2;
        }

        $create = Pesanan::create($param);

        if ($create) {
            return redirect()->route('keuangan.index')->with('success', 'Pesanan Created');
        }

        return back()->with('error', 'Oops, something went wrong!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'nullable|image|file|max:1024',
            'gambar2' => 'nullable|image|file|max:1024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $param = $request->except('_method', '_token', 'gambar', 'gambar2', 'oldImage', 'oldImage2');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bayar-images'), $filename);
            $param['gambar'] = 'bayar-images/' . $filename;
        }

        if ($request->hasFile('gambar2')) {
            $file2 = $request->file('gambar2');
            $filename2 = time() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('setor-images'), $filename2);
            $param['gambar2'] = 'setor-images/' . $filename2;
        }

        $update = $pesanan->update($param);

        if ($update) {
            return redirect()->route('keuangan.index')->with('success', 'Setor Updated');
        }

        return back()->with('error', 'Not Updated');
    }

    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('keuangan.update', ['title' => 'Edit Setor', 'pesanan' => $pesanan]);
    }


    public function destroy($id)
    {
        Pesanan::where($id)->delete();
        return redirect()->route('keuangan.index')->with('success', 'Pesanan Berhasil dihapus');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'user', 'bayar', 'status', 'rekening'])->findOrFail($id);
        return view('keuangan.show', ['title' => 'Detail Setoran/Pemasukan', 'pesanan' => $pesanan]);
    }

    public function fnGetData(Request $request)
    {
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data = Pesanan::where('id', '!=', 1)->with(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar', 'status', 'user']);

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $keyword = $request->input('search')['value'];
            $data = $data->where('id', 'LIKE', '%' . $keyword . '%')
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('pembeli', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('produk', function ($query) use ($keyword) {
                    $query->where('nama_produk', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('statusverifikasi', function ($query) use ($keyword) {
                    $query->where('statusverifikasi', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('status', function ($query) use ($keyword) {
                    $query->where('status', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('bayar', function ($query) use ($keyword) {
                    $query->where('cara_bayar', 'LIKE', '%' . $keyword . '%');
                });
        }


        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])->paginate($limit);

        return DataTables::of($data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('gambar', function ($data) {
                return '<img src="' . asset($data->gambar) . '" class="img-circle" style="width:50px">';
            })
            ->addColumn('gambar2', function ($data) {
                if ($data->gambar2) {
                    return '<img src="' . asset('setor-images/' . $data->gambar2) . '" class="img-circle" style="width:50px">';
                } else {
                    return 'Belum ada setor';
                }
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="admin/' . $data->name . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->user_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'gambar2', 'action'])
            ->make(true);
    }
}
