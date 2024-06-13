<?php

namespace App\Http\Controllers;

use App\Models\Expedisi;
use App\Models\Pesanan;
use App\Models\Status;
use App\Models\Statusverifikasi;
use App\Models\Pembeli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PengirimanController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->issuperadmin) {

            $pengirimans = Pesanan::with('user')
                ->where(function ($query) {
                    $query->where('bayar_id', 1)
                        ->whereIn('statusverifikasi_id', [0, 1])
                        ->orWhereNull('statusverifikasi_id');
                })
                ->orWhere(function ($query) {
                    $query->where('bayar_id', 2)
                        ->where('statusverifikasi_id', 2);
                })
                ->get();
        } else {

            $pengirimans = Pesanan::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('bayar_id', 1)
                        ->whereIn('statusverifikasi_id', [0, 1])
                        ->orWhereNull('statusverifikasi_id');
                })
                ->orWhere(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('bayar_id', 2)
                        ->where('statusverifikasi_id', 2);
                })
                ->get();
        }

        return view('pengiriman.index', [
            'title' => 'Pengiriman',
            'pengirimans' => $pengirimans,
            'pesanans' => Pesanan::all(),
            'pembelis' => Pembeli::all(),
            'statuss' => Status::all(),
            'statusverifikasis' => Statusverifikasi::all(),
            'users' => User::all(),
            'expedisis' => Expedisi::all()
        ]);
    }

   public function show($id)
    {
        $pesanan = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'user', 'bayar', 'status', 'expedisi'])->findOrFail($id);
        return view('pengiriman.show', ['title' => 'Detail Pengiriman', 'pesanan' => $pesanan]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar3' => 'nullable|image|file|max:1024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $param = $request->except('_method', '_token', 'gambar', 'gambar3', 'oldImage', 'oldImage2');

        if ($request->hasFile('gambar3')) {
            $file3 = $request->file('gambar3');
            $filename3 = time() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('resi-images'), $filename3);
            $param['gambar3'] = 'resi-images/' . $filename3;
        }

        $update = $pesanan->update($param);

        if ($update) {
            return redirect()->route('pengiriman.index')->with('success', 'Resi Updated');
        }

        return back()->with('error', 'Not Updated');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:statuss,id',
        ]);

        $pengiriman = Pesanan::findOrFail($id);
        $pengiriman->status_id = $request->status_id;
        $pengiriman->save();

        return redirect()->route('pengiriman.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data = new Pesanan();
        $data = $data->where('id', '!=', 1)->with('id');
        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('id', 'LIKE', '%' . $request->keyword . '%')->orWhere('nama_produk', 'LIKE', '%' . $request->keyword . '%')
                ->whereHas('role', function ($query) use ($request) {
                    $query->where('id', 'LIKE', '%' . $request->keyword . '%');
                });
        }

        // Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['id'], $request->order[0]['dir'])->paginate($limit);

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
                $btn = '<a class="btn btn-default" href="admin/' . $data->user_id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->user_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
