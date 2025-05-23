<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\CacheTimeout;
use Exception;
use App\Events\TestUser;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;


class AuthenticationController extends Controller
{
    use CacheTimeout;
    public function index()
    {
        if (!Auth::check()) {
            return view('authentication.login');
        }

        return redirect()->route('resume');
    }

    public function registrasi()
    {
        if (!Auth::check()) {
            return view('authentication.registrasi');
        }

        return redirect()->route('resume');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'verify') {
            if (password_verify($request->password, $user->password)) {
                Auth::login($user);
                $userRole = Auth::user()->role;
                if ($user->role === 'masyarakat') {
                    return redirect('/dashboard')->with('alert', [
                        'type' => 'success',
                        'title' => 'Login',
                        'text' => 'Login Berhasil',
                    ]);
                }
                else if ($user->role !== 'masyarakat'){
                    return redirect('/resume')->with('alert', [
                        'type' => 'success',
                        'title' => 'Login',
                        'text' => 'Login Berhasil',
                    ]);
                }
                else {
                    return redirect()->route('auth')->with('alert', [
                        'type' => 'error',
                        'title' => 'Login Gagal',
                        'text' => 'Username atau password salah'
                    ]);
                }
            }
            else {
            return redirect()->route('auth')->with('alert', [
                'type' => 'error',
                'title' => 'Login Gagal',
                'text' => 'Akun Anda belum diverifikasi oleh Petugas Administrasi'
            ]);
        }
        }

    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('auth')->with('alert', [
            'type' => 'success',
            'title' => 'Logout',
            'text' => 'Logout Berhasil Dilakukan'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $role = 'masyarakat';
            $status = "non-verify";
            $user = User::create([
                "nama" => $request->nama,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "password_confirmation" => Hash::make($request->password_confirmation),
                "nip" => $request->nip,
                "role" => $role,
                "status" => $status
            ]);
            if($user) {
                event(new TestUser($user));
                $this->forgetUser();

                $data = [
                    'text' => "Akun Baru Telah Terdaftar, Silahkan Verifikasi!",
                    'jenis' => "Verifikasi Akun",
                ];
                $email_target = ['riskyahmad0506@gmail.com', 'risky21ti@mahasiswa.pcr.ac.id'];
                echo $email_target[0]; // riskyahmad0506@gmail.com
                echo $email_target[1]; // risky21ti@mahasiswa.pcr.ac.id

                Mail::to($email_target)->send(new SendEmail($data));

                return redirect()->route('auth')
                ->with(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Insert Pengguna',
                            'text' => 'Anda Berhasil Daftar!'
                        ]
                    );
            }
        } catch (Exception $e) {
            return redirect()->route('auth')
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Pengguna',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }
}
