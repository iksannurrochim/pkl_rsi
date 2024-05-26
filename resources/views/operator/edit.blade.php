@extends('layouts.template')  
@section('konten')
@extends('layouts.layoutadmin') 
{{-- @extends('layouts.app')  --}}
@section('content')  
@section('title', 'Edit Data') 

<div class="my-1 p-1 bg-body shadow-sm">
    <h3 class="font-weight-bold ml-3 mb-3">Edit Data Admin</h3>
</div>
<form action='{{ url('operator/'.$data->id) }}' method='post'>
@csrf 
@method('PUT')
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <a href='{{ url('operator') }}' class="btn btn-secondary mb-3">kembali</a>
    {{-- <div class="mb-3 row">
        <label for="id" class="col-sm-2 col-form-label">ID</label>
        <div class="col-sm-10">
            {{ $data->id }}
        </div>
    </div> --}}
    <div class="mb-3 row">
        <label for="id" class="col-sm-2 col-form-label">NIP</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='id' value="{{ $data->id }}" id="id">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='nama' value="{{ $data->nama }}" id="nama">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='email' value="{{ $data->email }}" id="email">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="hp" class="col-sm-2 col-form-label">No. HP</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='hp' value="{{ $data->hp }}" id="hp">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jurusan" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
    </div>
</div>
</form>
<!-- AKHIR FORM -->
@endsection