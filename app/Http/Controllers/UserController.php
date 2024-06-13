<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; // Add this line

class UserController extends Controller
{

    public function index(Request $request)
{


    // Ambil data user dengan status isadmin
    $users = User::where('isadmin', true);

    // Lakukan pencarian berdasarkan nama pengguna jika parameter 'search' ada dalam URL
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $users->where('name', 'like', '%' . $searchTerm . '%');
    }

    // Dapatkan data pengguna dengan pagination
    $users = $users->paginate(10);
    return view('user.index',  ['title' => 'Manage User', 'users' => $users]);
}


    public function create()
    {
        return view('user.create', ['title' => 'Tambah User', 'users' => user::all()]);

    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect('user')->with('success', 'Admin Berhasil dihapus');
    }




    public function store(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:100',
            'username' => 'required|min:4|max:100|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:200',
            'no_tlp' => 'required|min:6|max:15',
            'alamat' => 'required|min:6|max:500',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:1024',
            'isadmin' => 'required', // Pastikan validasi isadmin ada
        ]);

        // Berikan nilai default untuk isadmin jika tidak ada nilai yang diberikan
        $validatedData['isadmin'] = $request->input('isadmin', 0); // Ubah nilai default menjadi 0

        // Enkripsi password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Penyimpanan gambar
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user-images'), $imageName);
            $validatedData['gambar'] = $imageName;
        }

        $validatedData['id']= '';

        // Insert data user
        User::create($validatedData);

        // Redirect setelah berhasil
        return redirect('/user')->with('status', 'Admin berhasil dibuat');
    }


}
