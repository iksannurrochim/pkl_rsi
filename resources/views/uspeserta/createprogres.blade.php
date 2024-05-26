@extends('layouts.template')  
@section('konten')
@extends('layouts.layoutpeserta') 
{{-- @extends('layouts.app')  --}}
@section('content')  
@section('title', 'Tambah Progres') 

<style>
    h3, label, input{
        font-family: 'Poppins', sans-serif; 
    }

</style>
<!-- Tambahkan link CSS dari Google Fonts di sini -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

<form action='{{url('uspeserta')}}' method='post'>
@csrf
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h3 class="fw-bolder ml-3 mb-3">Tambah Progres</h3>
    <a title="kembali" href='{{ URL::previous() }}' class="btn btn-secondary mb-4"><i class="bi bi-arrow-left-circle"></i></a>
    
    <input type="hidden" name="id_penyelia" value="{{ $id_penyelia }}">
    
    <div class="mb-3 row">
        <label for="tanggal" class="col-sm-2 col-form-label ">Tanggal</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='tanggal' value="{{ Session::get('tanggal') }}" id="tanggal" placeholder="yyyy-mm-dd">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="progres" class="col-sm-2 col-form-label ">Kegiatan yang terlaksana</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='progres' value="{{ Session::get('progres') }}" id="progres">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan (Hambatan, tantangan, dan pelaksanaan)</label>
        <div class="col-sm-10">
            <textarea type="text" class="form-control" name='keterangan' value="{{ Session::get('keterangan') }}" id="keterangan"></textarea>
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

<script>
    $('[title]').tooltip();
</script>

@endsection




