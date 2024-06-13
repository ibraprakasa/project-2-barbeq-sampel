<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function edit()
    {
        $user = auth()->user();
        $hideTitle = true;
        return view('password.update',['title' => 'change password', 'users' => $user]);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'curr_password' => 'required',
            'new_password' => 'required|min:6|max:200|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::find(auth()->id());
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if (!Hash::check($request->curr_password, $user->password)) {
            return back()->with('error', 'The specified password does not match.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('setting.index')->with('success', 'Password updated successfully.');
    }
}
