{{-- @extends('layouts.app')   --}}
@extends('layouts.layoutadmin') 
@section('content') 
@section('title', 'Tambah Data') 

<!-- START FORM -->
<form action='{{url('operator')}}' method='post'>
@csrf
        <div class="mt-4 my-3 p-3 bg-body rounded shadow-sm">
            <a href='{{ url('operator') }}' class="btn btn-secondary mb-4">kembali</a>
            <div class="mb-3 row">
                <label for="id" class="col-sm-2 col-form-label">NIP</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name='id' value="{{ Session::get('id') }}" id="id">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='nama' value="{{ Session::get('nama') }}" id="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='email' value="{{ Session::get('email') }}" id="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="hp" class="col-sm-2 col-form-label">No. HP</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='hp' value="{{ Session::get('hp') }}" id="hp">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jurusan" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
            </div>

            
            {{-- <div class="mb-3 row">
                <label for="asal_sekolah" class="col-sm-2 col-form-label">Asal Instansi</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='asal_sekolah' value="{{ Session::get('asal_sekolah') }}" id="asal_sekolah">
                </div>
            </div> --}}
            {{-- <div class="form-group">
                <label class="col-sm-2 col-form-label">Asal Instansi</label>
                <select name="instansi_id" class="form-control col-sm-10 mb-4">
                    <option value="">- Pilih -</option>
                   
                    <option value=""></option>
                    
                </select>
            </div> --}}


            
          
        </div>
        </form>
        <!-- AKHIR FORM -->
@endsection