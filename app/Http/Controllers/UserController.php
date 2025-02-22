<?php

namespace App\Http\Controllers;

use App\Traits\CacheTimeout;
use Exception;
use App\Models\User;
use App\Events\TestUser;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\RiwayatUserModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;


class UserController extends Controller
{
    use CacheTimeout;
    public function show()
    {
        try {
            $user = Cache::remember('user_data', 1200, function () {
                return User::all();
            });

            $totalAkun = User::count('id');
            $totalManager = User::whereIn('role', ['gm', 'am'])->count();
            $totalAdmin = User::whereIn('role', ["admin"])->count();
            return view('after-login.pengguna.index')
                ->with([
                    'user' => UserResource::collection($user),
                    'total_akun' => $totalAkun,
                    'total_manager' => $totalManager,
                    'total_admin' => $totalAdmin,
                ]);
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Pengguna',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }


    public function store(Request $request)
    {
        try {
            $user = User::create([
                "nama" => $request->nama,
                "email" => $request->email,
                "password" => Hash::make($request->nip),
                "departemen" => $request->departemen,
                "nip" => $request->nip,
                "role" => $request->role,
            ]);

            if($user) {
                event(new TestUser($user));
                $this->forgetUser();

                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Insert Pengguna',
                            'text' => 'Data berhasil ditambahkan!'
                        ]
                    );
            }
        } catch (Exception $e) {
            return redirect()->back()
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

    public function update(Request $request, $id)
    {
        try {
            $user =  User::findOrFail($id);

            $user->update($request->all());

            $this->forgetUser();

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Pengguna',
                        'text' => 'Data berhasil diubah!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Pengguna',
                        'text' => $e -> getMessage()
                    ]
                );
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            $this->forgetUser();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Delete Pengguna',
                'text' => 'Data berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Delete Pengguna',
                'text' => $e -> getMessage()
            ]);
        }
    }

    public function getDetailPengguna($id)
    {
        try {
            // Ambil data pengguna berdasarkan ID
            $user = User::findOrFail($id);

            return view('after-login.pengguna.detail')->with([
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Detail Pengguna',
                    'text' => $e->getMessage()
                ]
            );
        }
    }


    public function verifikasiPengguna(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);

        if ($user->status === 'non-verify') {
            $statusUser = $request->verifikasi;

            // Ambil email target
            $email_target = $user->email ?? null;
            if (!$email_target) {
                throw new Exception('Email not found for the given user');
            }

            // Kirim email
            $data = [
                'text' => $statusUser === 'verify'
                    ? 'Akun anda telah diverifikasi oleh Admin, Silahkan Login!'
                    : 'Akun anda telah ditolak oleh Admin!',
                'jenis' => 'Verifikasi Akun',
            ];

            // Update status pengguna
            $user->update(['status' => $statusUser]);

            // Kirim email notifikasi
            Mail::to($email_target)->send(new SendEmail($data));

            // Forget user cache dan redirect dengan pesan sukses
            $this->forgetUser();
            return redirect()->route('user.detail', ['id' => $user->id])->with('alert', [
                'type' => $statusUser === 'verify' ? 'success' : 'warning',
                'title' => $statusUser === 'verify' ? 'Verifikasi Pengguna' : 'Verifikasi Ditolak',
                'text' => $statusUser === 'verify'
                    ? 'Status pengguna berhasil diverifikasi'
                    : 'Status pengguna berhasil ditolak'
            ]);
        }

        // Jika status pengguna bukan 'non-verify', kirimkan pesan gagal
        return redirect()->route('user.detail', ['id' => $user->id])->with('alert', [
            'type' => 'warning',
            'title' => 'Verifikasi Tidak Diperlukan',
            'text' => 'Status pengguna sudah diverifikasi sebelumnya'
        ]);

    } catch (\Exception $e) {
        // Penanganan error
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'title' => 'Verifikasi Gagal',
            'text' => $e->getMessage()
        ]);
    }
}

}
