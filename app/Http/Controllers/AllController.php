<?php
namespace App\Http\Controllers;

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

class AllController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar','status','user','expedisi'])->get();
        

        return view('all.index', [
            'title' => 'All Pesanan',
            'pesanans' => $pesanans,
            'pembelis' => Pembeli::all(),
            'statusverifikasis' => Statusverifikasi::all(),
            'users' => User::all(),
            'produks' => Produk::all(),
            'rekenings' => Rekening::all(),
            'bayars' => Bayar::all(),
            'statuss' => Status::all(),
            'expedisi' => Expedisi::all()
        ]);
    }


    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');

        // Validasi
        $validator = Validator::make($param, [
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'user_id' => 'required',
            'harga' => 'required',
            'jumlah_produk' => 'required',
            'alamat' => 'required',
            'status_id' => 'exists:statuss,id',
            'bayar_id' => 'required',
            // 'bayar_id' => '',
            'statusverifikasi_id' =>'exists:statusverifikasis,id',
            'rekening_id' => 'required',
            'expedisi_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::create($param);

        if ($pesanan) {
            return redirect('all')->with('success', 'Pesanan Created');
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
            'expedisi_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $update = Pesanan::where('id', $id)->update($param);

        if ($update) {
            return redirect('all')->with('success', 'Pesanan Updated');
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
            return redirect('all')->with('success', 'Status verifikasi berhasil diperbarui');
        }

        return back()->with('error', 'Gagal memperbarui status verifikasi');
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:statuss,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status_id = $request->status_id;

        if ($pesanan->save()) {
            return redirect('all')->with('success', 'Status  berhasil diperbarui');
        }

        return back()->with('error', 'Gagal memperbarui status ');
    }

    public function destroy($id)
    {
        Pesanan::where('id', $id)->delete();
        return redirect('all')->with('success', 'Pesanan Berhasil dibatalkan');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'user', 'bayar', 'status', 'expedisi',])->findOrFail($id);
        return view('all.show', ['title' => 'Detail Pesanan', 'pesanan' => $pesanan]);
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


