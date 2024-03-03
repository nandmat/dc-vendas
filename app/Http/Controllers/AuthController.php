<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.index');
    }

    public function auth(Request $request)
    {
        try {
            $user_request = $request->user;

            $user = User::where('email', $user_request)->first();
            if (!$user) {
                return back()->withInput()->with('erro', 'Usuário ou senha inválidos!');
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()->withInput()->with('erro', 'Usuário ou senha inválidos!');
            }

            Auth::login($user, true);


            $request->session()->regenerate();

            return redirect('/dashboard');
        } catch (Exception $e) {
            Log::error($e);
            return back()->with('erro', 'Não foi possível fazer o login!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
