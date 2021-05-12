<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;

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
        ], 200);
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
        ], 200);
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

    public function authenticate(Request $request)
    {
        // return $request->all();
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid access'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token was created'], 500);
        }
        $user = Auth::user();
        return response()->json([
            "token" => $token,
            "user" => $user
        ]);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }
            return response()->json(compact('user'));
    }

    public function refreshToken(){
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            $user = Auth::user();
            return response()->json([
                "token" => $token,
                "user" => $user
            ]);
        } catch (TokenExpiredExceotion $ex) {
            return response()->json([
                'success' => false,
                'message' => "Expired Session",
            ],422);
        }
        catch (TokenBlackListedException $ex) {
            return response()->json([
                'success' => false,
                'message' => "Invalid Session",
            ],422);
        }
    }

    public function logout(){
        return $token = JWTAuth::getToken();
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'success' => true,
                'message' => "Logout Success",
            ], 200);
        } catch (JWTException $ex) {
            return response()->json([
                'success' => false,
                'message' => "Error Logout",
            ],422);
        }
    }
}
