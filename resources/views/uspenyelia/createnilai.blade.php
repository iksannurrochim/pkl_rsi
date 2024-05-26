@extends('layouts.template')  
@section('konten')
@extends('layouts.layoutpeserta') 
{{-- @extends('layouts.app')  --}}
@section('content')  
@section('title', 'Progres Peserta') 

<style>
    h3, label, input{
        font-family: 'Poppins', sans-serif; 
    }

</style>
<!-- Tambahkan link CSS dari Google Fonts di sini -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

<form action='{{ route('uspenyelia.createnilai') }}' method='post'> 
@csrf
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h3 class="fw-bolder ml-3 mb-3">Tambah Nilai</h3>
    <a title="kembali" href='{{ URL::previous() }}' class="btn btn-secondary mb-4"><i class="bi bi-arrow-left-circle"></i></a>
    
    <!-- Input tersembunyi untuk nim_peserta -->
    <input type="hidden" name="nim_peserta" value="{{ $nim_peserta }}">
    <!-- Input tersembunyi untuk id_penyelia -->
    <input type="hidden" name="id_penyelia" value="{{ $id_penyelia }}">
    
    <div class="mb-3 row">
        <label for="nilai" class="col-sm-2 col-form-label ">Nilai</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='nilai' value="" id="nilai" placeholder="masukkan nilai dengan rentang 0-100">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="evaluasi" class="col-sm-2 col-form-label">Evaluasi</label>
        <div class="col-sm-10">
            <textarea type="text" class="form-control" name='evaluasi' value="" id="evaluasi"></textarea>
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