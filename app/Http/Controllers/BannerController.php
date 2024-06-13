<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('banner.index', ['title' => 'Banner', 'banners' => $banners]);
    }

    public function create()
    {
        return view('banner.create', ['title' => 'Tambah Banner', 'banners' => Banner::all()]);
    }

    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');
        $validator = Validator::make($param, [
            'gambar' => 'image|file|max:1024',
            'detail' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('banner-images'), $filename);
            $param['gambar'] = url('banner-images') . '/' . $filename;
        }

        Banner::create($param);

        return redirect('banner')->with('success', 'Banner Created');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('banner.update', ['title' => 'Edit Banner ' . $banner->id, 'banner' => $banner]);
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');
        $validator = Validator::make($param, [
            'gambar' => 'image|file|max:1024',
            'detail' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('banner-images'), $filename);
            $param['gambar'] = url('banner-images') . '/' . $filename;
        }

        Banner::where('id', $id)->update($param);

        return redirect('banner')->with('success', 'Banner Updated');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect('banner')->with('success', 'Banner Berhasil dihapus');
    }

    public function fnGetData(Request $request)
    {
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data = Banner::where('id', '!=', 1)->with('id');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('kode', 'LIKE', '%' . $request->keyword . '%')
                         ->orWhere('gambar', 'LIKE', '%' . $request->keyword . '%');
        }

        $limit = $request->input('length', 10);
        $data = $data->orderBy($request->columns[$request->order[0]['column']]['data'], $request->order[0]['dir'])
                     ->paginate($limit);

        $data = json_decode(json_encode($data));

        return DataTables::of($data->data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('gambar', function ($data) {
                return '<img src="' . $data->gambar . '" class="img-circle" style="width:50px">';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="admin/' . $data->banner_id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
