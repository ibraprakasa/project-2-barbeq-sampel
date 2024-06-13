<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SemuapesananController extends Controller
{
    public function index()
    {
        $semuapesanans = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar'])->get();

        return view('semuapesanan.index', [
            'title' => 'All Pesanan',
            'semuapesanans' => $semuapesanans,
        ]);
    }

    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');

        // Validasi
        $validator = Validator::make($param, [
            'produk_id' => 'required',
            'harga' => 'required',
            'jumlah_produk' => 'required',
            'alamat' => 'required',
            'pembeli_id' => 'required',
            'user_id' => 'required',
             'status_id' => 'exists:statuss,id',
            // 'bayar_id' => 'exists:bayarss,id',
            'bayar_id' => 'required',
            'statusverifikasi_id' =>'exists:statusverifikasis,id',
            'rekening_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $semuapesanan = Pesanan::create($param);

        if ($semuapesanan) {
            return redirect('semuapesanan')->with('success', 'Pesanan Created');
        }

        return back()->with('error', 'Oops, something went wrong!');
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');

        // Validasi
        $validator = Validator::make($param, [
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'user_id' => 'required',
            'status_id' => '',
            'bayar_id' => '',
            'statusverifikasi_id' => '',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $update = Pesanan::where('id', $id)->update($param);

        if ($update) {
            return redirect('semuapesanan')->with('success', 'Pesanan Updated');
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

        $semuapesanan = Pesanan::findOrFail($id);
        $semuapesanan->statusverifikasi_id = $request->statusverifikasi_id;

        if ($semuapesanan->save()) {
            return redirect('semuapesanan')->with('success', 'Status verifikasi berhasil diperbarui');
        }

        return back()->with('error', 'Gagal memperbarui status verifikasi');
    }

    public function destroy($id)
    {
        Pesanan::where('id', $id)->delete();
        return redirect('semuapesanan')->with('success', 'Pesanan Berhasil dibatalkan');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data = Pesanan::query();

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('produk_id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('pembeli_id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('user_id', 'LIKE', '%' . $request->keyword . '%');
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
