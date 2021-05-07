<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            "data" => $users
        ], 200);
    }

    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = Str::title($request->name);
        $user->slug = Str::slug($request->name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "data" => $user,
            "message" => "User registred"
        ],200);
    }

    public function show(User $user)
    {
        return response()->json([
            "data" => $user
        ], 200);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->name = Str::title($request->name);
        $user->slug = Str::slug($request->name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "data" => $user,
            "message" => "User updated"
        ],200);
    }

    public function destroy(User $user)
    {
        $oldUser = $user;
        $user->delete();
        return response()->json([
            "data" => $oldUser,
            "message" => "User deleted"
        ], 200);
    }
}
