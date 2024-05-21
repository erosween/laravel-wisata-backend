<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //index
    public function index(Request $request)
    {

        $users = DB::table('users')->when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orwhere('email', 'like', "%{$request->keyword}%")
                ->orwhere('phone', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    //create
    public function create()
    {

        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required| min:6',
            ]
        );

        User::create($request->all());
        return redirect()->route('users.index')->with('success', 'user created successfully');
    }


    //edit
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    //update
    public function update(Request $request, User $user)
    {

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        //cek password is not empty
        if ($request->password) {
            $user->update(['password' => hash::make($request->password)]);
        }
        return redirect()->route('users.index')->with('success', "User Updated succesfully");
    }

    public function destroy(User $user)
    {

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
