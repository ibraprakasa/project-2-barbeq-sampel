<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Rekening;
use Illuminate\Support\Facades\Validator;

class RekeningController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isadmin || $user->issuperadmin) {
            $rekenings = Rekening::all();
        } else {
            $rekenings = Rekening::where('user_id', $user->id)->get();
        }

        return view('rekening.index', [
            'title' => 'Daftar Rekening',
            'rekenings' => $rekenings,
            'users' => User::all(),
        ]);
    }


    public function create()
    {
        return view('rekening.create', ['title' => 'Tambah Rekening']);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isadmin && !$user->issuperadmin && Rekening::where('user_id', $user->id)->exists()) {
            return redirect()->route('rekening.index')->with('error', 'Anda hanya boleh memiliki satu rekening.');
        }

        $param = $request->except('_token');
        $param['user_id'] = $user->id;

        $validator = Validator::make($param, [
            'nama_bank' => 'required',
            'no_rek' => 'required',
            'nama_pemilik' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages[] = $value[0];
            }
            return back()->with('error', implode(', ', $messages));
        }

        $create = Rekening::create($param);

        if ($create) {
            return redirect('rekening')->with('success', 'Rekening Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }





    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('rekening.update', ['title' => 'Edit Rekening', 'rekening' => $rekening]);
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');
        $param['user_id'] = auth()->id();
        $validator = Validator::make($param, [
            'nama_bank' => 'required',
            'no_rek' => 'required',
            'nama_pemilik' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages[] = $value[0];
            }
            return back()->with('error', implode(', ', $messages));
        }

        Rekening::where('id', $id)->update($param);

        return redirect('rekening')->with('success', 'Rekening Updated');
    }

    public function destroy($id)
    {
        Rekening::where('id', $id)->delete();
        return redirect('rekening')->with('success', 'Rekening Berhasil dihapus');
    }
}
