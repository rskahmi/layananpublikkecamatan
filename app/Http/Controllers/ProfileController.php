<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('after-login.profil.index');
    }

    public function update(Request $request)
    {
        try {
            $id = auth()->user()->id;

            $profile = User::findOrFail($id);
            $profile->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nip
            ]);

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Update Profile',
                        'text' => 'Data berhasil diubah!'
                    ]
                );
        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Update Profile',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
}
