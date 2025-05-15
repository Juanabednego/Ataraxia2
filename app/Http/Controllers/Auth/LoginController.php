<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Tambahkan import ini
use Illuminate\Support\Str; 

class LoginController extends Controller
{
         use AuthenticatesUsers;

    public function redirectToGoogle()
    {
       return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();

    }

    public function handleGoogleCallback()
    {
        // Mendapatkan data user dari Google
        $googleUser = Socialite::driver('google')->user();

        // Cek apakah user sudah ada di database berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Jika user belum ada, buat user baru dengan password random hash
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(24)), // password random agar tidak null
            ]);
        }

        // Login user
        Auth::login($user);

        // Redirect ke halaman utama atau dashboard
        return redirect()->to('/');
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    /**
     * Redirect user after login based on role.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect('/indexadmin'); // Admin ke halaman dashboard admin
        }
        return redirect('/'); // User biasa ke halaman booking table
    }
}
