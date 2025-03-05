<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RoleTable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::join('roles','role_id','=','roles.id')->select('users.*','roles.name as role')->where('email', $credentials['email'])->first();
        if (!$user || hash('sha512', $credentials['password']) !== $user->password) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $role = RoleTable::where('id', $user->role_id)->first()->name;
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }
}
