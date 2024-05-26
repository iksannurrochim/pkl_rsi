<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\penyelia;
use App\Models\instansi;
use App\Models\nilai;
use App\Models\peserta;
use App\Models\entry_progres;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illiminate\validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UbahPasswordPenyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyelia = Penyelia::where('id', Auth::user()->nomor_id)->first();
        $user = User::where('nomor_id', Auth::user()->nomor_id)->first();
        return view('ubahpass_penyelia.index', [
            'title' => 'Ubah Password'
        ])->with(compact('penyelia', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate
        $request->validate([
            // olf password must same with password in database
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Password lama tidak sama');
                    }
                },
            ],
            'new_password' => 'required|string',
            'ver_password' => 'required|string|same:new_password',
        ], [
            'old_password.required' => 'Password lama tidak boleh kosong',
            'new_password.required' => 'Password baru tidak boleh kosong',
            'ver_password.required' => 'Verifikasi password tidak boleh kosong',
            'ver_password.same' => 'Verifikasi password tidak sama dengan password baru',
        ]);


        User::where('nomor_id', $id)->update([
            'password' => bcrypt($request->new_password),
        ]);

        return redirect()->route('dashboard')->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
