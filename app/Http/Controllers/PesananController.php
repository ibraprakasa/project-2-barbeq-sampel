<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\Expedisi;
use App\Models\Pesanan;
use App\Models\Statusverifikasi;
use App\Models\Rekening;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Pesanan::query();

        if ($user->isadmin || $user->issuperadmin) {
            $query->where('bayar_id', '>', 1)
                  ->where(function ($q) {
                      $q->whereNull('statusverifikasi_id')
                        ->orWhereIn('statusverifikasi_id', [0, 1]);
                  });
        } else {
            $query->where('user_id', $user->id)
              ->where(function ($q) {
                  $q->where(function ($q) {
                      $q->where('bayar_id', 1)
                        ->where(function ($q) {
                            $q->whereIn('statusverifikasi_id', [0, 1])
                              ->orWhereNull('statusverifikasi_id');
                        });
                  })
                  ->orWhere(function ($q) {
                      $q->where('bayar_id', '!=', 1)
                        ->where('statusverifikasi_id', 2);
                  });
              });


            }


        $pesanans = $query->with(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar', 'expedisi'])->get();

        return view('pesanan.index', [
            'title' => 'Pesanan',
            'pesanans' => $pesanans,
            'pembelis' => Pembeli::all(),
            'statusverifikasis' => Statusverifikasi::all(),
            'users' => User::all(),
            'produks' => Produk::all(),
            'rekenings' => Rekening::all(),
            'bayars' => Bayar::all(),
            'expedisis' => Expedisi::all(),
        ]);
    }


    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');

        // Validasi
        $validator = Validator::make($param, [
            'gambar' => 'nullable|image|file|max:1024',
            'harga' => 'required',
            'jumlah_produk' => 'required',
            'alamat' => 'required',
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'user_id' => 'required',
            'status_id' => 'exists:statuss,id',
            'bayar_id' => 'required',
            'statusverifikasi_id' =>'exists:statusverifikasis,id',
            'rekening_id' => 'required',
            'expedisi_id' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanans = Pesanan::create($param);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bayar-images'), $filename);
            $param['gambar'] = 'bayar-images/' . $filename;
        }

        if ($pesanans) {
            return redirect('pesanan')->with('success', 'Pesanan Created');
        }

        return back()->with('error', 'Oops, something went wrong!');
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');

        // Validasi
        $validator = Validator::make($param, [
            'bayar_id' => '',
            'statusverifikasi_id' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $update = Pesanan::where('id', $id)->update($param);

        if ($update) {
            return redirect('pesanan')->with('success', 'Pesanan Updated');
        }

        return back()->with('error', 'Pesanan not Updated');
    }


    public function updateStatusverifikasi(Request $request, $id)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'statusverifikasi_id' => 'required|exists:statusverifikasis,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->statusverifikasi_id = $request->statusverifikasi_id;

        if ($pesanan->save()) {
            return redirect('pesanan')->with('success', 'Status verifikasi berhasil diperbarui');
        }

        return back()->with('error', 'Gagal memperbarui status verifikasi');
    }


    public function destroy($id)
    {
        Pesanan::where('id', $id)->delete();
        return redirect('pesanan')->with('success', 'Pesanan Berhasil dibatalkan');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'user', 'bayar','expedisi'])->findOrFail($id);
        return view('pesanan.show', ['title' => 'Detail Pesanan', 'pesanan' => $pesanan]);
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
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
            //Setting Limit
            $limit = 10;
            if (!empty($request->input('length'))) {
                $limit = $request->input('length');
            }

            $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])
                ->paginate($limit);

            return DataTables::of($data)
                ->skipPaging()
                ->make(true);
    }
}
