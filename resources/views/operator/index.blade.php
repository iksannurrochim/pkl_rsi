@extends('layouts.template')  
@section('konten')
@extends('layouts.layoutadmin') 
{{-- @extends('layouts.app')  --}}
@section('content')  
@section('title', 'Data Admin') 

<!-- Tambahkan link CSS dari Google Fonts di sini -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

{{-- <div class="my-1 p-1 bg-body shadow-sm">
    <h3 class="font-weight-bold ml-3 mb-3">Data Penyelia</h3>
</div> --}}

<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h3 class="fw-bolder ml-3 mb-3">Data Admin</h3>
    {{-- <h2>Data Instansi</h2> --}}
    <!-- FORM PENCARIAN -->
    <div class="pb-3">
        <form class="d-flex" action="{{url('operator')}}" method="get">
            <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukkan kata kunci" aria-label="Search">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </form>
      </div>

      <!-- TOMBOL TAMBAH DATA -->
      <div class="pb-3">
        <a href='{{ url('operator/create') }}' class="btn btn-primary">+ Tambah Data</a>
      </div>
    
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Action</th> <!-- Added Action column -->
            </tr>
        </thead>
        <tbody>
            <?php $i = $data->firstItem()?>
            @foreach ($data as $item)
            <tr>
                <td>{{$i}}</td>
                {{-- <td>{{$item->id}}</td> --}}
                <td>{{$item->id}}</td>
                <td>{{{$item->nama}}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->hp}}</td>
                <td>
                    <a href='{{url('operator/'.$item->id. '/edit')}}' class="btn btn-warning btn-sm">Edit
                        {{-- <i class="nav-icon fas fa-edit"></i> --}}
                        {{-- <i class="bi bi-pencil-square"></i> --}}
                    </a>
                    <form onsubmit="return confirm('Yakin akan menghapus data ini?')" class='d-inline' action="{{url('operator/'.$item->id)}}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm">Hapus
                            {{-- <i class="fas fa-trash"></i> --}}
                            {{-- <i class="bi bi-trash"></i> --}}
                        </button>
                    </form>
                </td>
            </tr>
            <?php $i++ ?>
            @endforeach
            
        </tbody>
    </table>
    {{$data->links()}}
</div>
@endsection