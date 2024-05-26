<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\peserta;
use Illuminate\Support\Facades\Auth;

class MateriPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the logged-in participant
        $peserta = Peserta::where('nim', Auth::user()->nomor_id)->first();

        if ($peserta && $peserta->penyelia) {
            // Fetch materi of the supervisor
            $materis = Materi::where('id_penyelia', $peserta->penyelia->id)->get();
        } else {
            // If no supervisor is found, set materis to an empty collection
            $materis = collect();
        }

        return view('materipeserta.index', compact('materis', 'peserta'));
    }

    // public function download($id)
    // {
    //     $materi = Materi::findOrFail($id);

    //     $filePath = public_path('files\materi');

    //     if (file_exists($filePath)) {
    //         return response()->download($filePath, $materi->nama_file, [
    //             'Content-Type' => 'application/pdf',
    //         ]);
    //     } else {
    //         return redirect()->route('materipeserta.index')->with('error', 'File not found.');
    //     }
    // }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
