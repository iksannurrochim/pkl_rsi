@extends('layouts.template')  
@section('konten')
@extends('layouts.layoutpenyelia') 
{{-- @extends('layouts.app')  --}}
@section('content')  
@section('title', 'Dashboard Penyelia') 

<style>

   h3 {
       /* margin-left: 10px; 
       margin-top: 10px; 
       font-weight: bold;  */
       font-family: 'Montserrat', sans-serif; */
   }
</style>
<!-- Tambahkan link CSS dari Google Fonts di sini -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<!-- START DATA -->
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h3 class="font-weight-bold ml-3 mb-3">Data Peserta</h3>
    <div class="d-flex flex-row"> <!-- Container utama menggunakan flex-row -->
        <div class="d-inline-flex flex-column" style="width: 40%; margin-right: 20px;"> <!-- Kotak Profil menggunakan flex-column -->
            <div class="d-inline-flex p-2" style="background-color: #285702; color: #fff; padding: 10px; border-radius: 15px;">
                <div class="d-flex justify-content-end">
                    <a href='{{ url('peserta/edit') }}'  style="text-decoration: none; color: white;">
                        <i class="bi bi-pencil-square" style="cursor: pointer;"></i>
                    </a>
                </div>
                <!-- Frame Lingkaran untuk Foto Profil -->
                <div class="d-inline-flex flex-column">
                    <div class="d-inline-flex p-2 fw-bold" style="margin-right: 10px;">Profil</div>

                    <div class="d-inline-flex p-2">
                        <img src="{{ asset('images/wallpaper.png') }}" alt="Foto Profil" style="width: 130px; height: 130px; border-radius: 50%;">
                    </div>
                </div>

                <!-- Tulisan Nama, NIP, Email, dan Nomor HP -->
                <div class="d-inline-flex flex-column p-5">
                    <p class="mb-1 fw-semibold">Mahasiswa</p>
                    <p class="mb-1 fw-semibold">{{ $data->nama }} Mhs 1</p>
                    <p class="mb-1 fw-semibold">{{ $data->nim }}</p>
                    <p class="mb-1 fw-semibold">{{ $data->email }}</p>
                    <p class="mb-1 fw-semibold">{{ $data->hp }}</p>
                    <p class="mb-1 fw-semibold">{{ $data->universitas }}</p>
                    <p class="mb-1 fw-semibold">{{ $data->jurusan }}</p>
                </div>
            </div>
        </div>
        
        <div class="d-inline-flex flex-column" style="width: 38%;"> <!-- Kotak "Jumlah Peserta" menggunakan flex-column -->
            <div class="d-inline-flex justify-content-between align-items-center p-2" style="background-color: #285702; color: #fff; padding: 10px; border-radius: 15px; height: 20%;">
                <p class="fw-bold text-center mt-1" style="font-size: 1.5em;">Progres PKL</p>
                <button href='{{ url("uspenyelia/.'$penyelia->id'./progrespeserta") }}' class="btn btn-warning">Lihat</button>
            </div>

            <div class="d-inline-flex justify-content-between align-items-center p-2" style="background-color: #285702; color: #fff; padding: 10px; border-radius: 15px; height: 20%; margin-top: 20px;">
                <p class="fw-bold text-center mt-1" style="font-size: 1.5em;">Evaluasi PKL</p>
                <button class="btn btn-warning">Lihat</button>
            </div>
            
        </div>
      </div>
</div>

@endsection
