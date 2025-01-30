<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function login_confirmation(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $response = Http::post('http://127.0.0.1:8000/api/v1/login', [
                'email' => $email,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $token = $response->json('access_token');
                $role = $response->json('role');

                session(['access_token' => $token, 'role' => $role]);
                
                return redirect()->route('home');
            }

            $errorMessage = $response->json('message') ?? 'Erro desconhecido na autenticação.';
            return redirect()->back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro no sistema. Tente novamente mais tarde.');
        }
    }
}
