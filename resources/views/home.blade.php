@extends('layouts.template')  
@section('konten')
@extends('layouts.layout') 
@section('content')  
@section('title', 'Home') 

<style>
    body {
        background-image: url('images/rsi3.jpg'); /* Ganti path sesuai dengan lokasi gambar Anda */
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        
    }

    .content h1,
    .content h2,
    .content p {
        color:#fff
    }

    .orange-button {
        background-color: #ff7f00; /* Warna oranye */
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
    }

    /* ... (CSS lainnya) ... */
</style>

<div class="content">
    <h1 class="fw-bold">Selamat Datang,</h1>
    <h2 class="fw-bolder">Sistem Informasi Pendidikan dan Pelatihan</h2>
    <p class="fw-bolder">Rumah Sakit Islam Muhammadiyah Kendal</p>

    <button class="orange-button" onclick="window.location.href='/list_home'">Lihat Peserta PKL >></button>
</div>

@endsection