@extends('layouts.template')  
@section('konten')
@extends('layouts.layoutpeserta') 
{{-- @extends('layouts.app')  --}}
@section('content')  
@section('title', 'Tambah Progres') 

<style>
    /* Gaya font Poppins */
    label{
        font-family: 'Poppins', sans-serif;
        
    }
    h3{
        font-family: 'Poppins', sans-serif;
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

<!-- START FORM -->
<form action='{{ route('uspenyelia.createprogres') }}' method='get'> <!-- Mengubah action ke route createprogres -->
@csrf
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h3 class="fw-bolder ml-3 mb-3">Tambah Progres</h3>
    <a href='{{ URL::previous() }}' class="btn btn-secondary mb-4">kembali</a>
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Tanggal</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='nama' value="" id="nama" placeholder="yyyy-mm-dd">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="alamat" class="col-sm-2 col-form-label">Kegiatan yang terlaksana</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='alamat' value="" id="alamat">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan (Hambatan, tantangan, dan pelaksanaan)</label>
        <div class="col-sm-10">
            <textarea type="text" class="form-control" name='keterangan' value="" id="keterangan"></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jurusan" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
        </div>
    </div>
</div>
</form>
<!-- AKHIR FORM -->
@endsection
