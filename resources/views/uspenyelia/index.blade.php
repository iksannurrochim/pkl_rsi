@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Daftar Peserta')

<div class="content-wrapper container">
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Peserta</h3>
                <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    {{-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable jQuery</li>
                    </ol> --}}
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Peserta
                </h5>
            </div>
        <div class="card-body">
            <div class="table-responsive datatable-minimal">
                <table class="table" id="table2">
                    <thead>
                        <tr>
                            <th class=>No</th>
                            {{-- <th class="col">ID</th> --}}
                            <th class="col">NIM</th>
                            <th class="col">Nama</th>
                            <th class="col">Asal Instansi</th>
                            {{-- <th class="col">Alamat</th> --}}
                            {{-- <th class="col">Tanggal Lahir</th> --}}
                            <th class="col">Email</th>
                            {{-- <th class="col">No HP</th> --}}
                            <th class="col">Program Studi</th>
                            {{-- <th class="col">Lama Kegiatan</th> --}}
                            <th class="col">Aksi</th>
                            <th class="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peserta as $index => $item)
                        <tr>
                            <td>{{ $peserta->firstItem() + $index }}</td>
                            {{-- <td>{{$item->id}}</td> --}}
                            <td title="{{$item->nim}}">{{$item->nim}}</td>
                            <td title="{{$item->nama}}">{{{$item->nama}}}</td>
                            <td title="{{ isset($instansiManagers[$item->instansi_id]) ? $instansiManagers[$item->instansi_id] : 'N/A' }}">{{ isset($instansiManagers[$item->instansi_id]) ? $instansiManagers[$item->instansi_id] : 'N/A' }}</td>
                            {{-- <td title="{{$item->alamat}}">{{$item->alamat}}</td> --}}
                            <td title="{{$item->user->email}}">{{$item->user->email}}</td>
                            {{-- <td title="{{$item->hp}}">{{$item->hp}}</td> --}}
                            <td title="{{$item->jurusan}}">{{$item->jurusan}}</td>
                            <td>
                                <a title="Lihat Progres" href='{{ route("uspenyelia.progrespeserta", $item->nim) }}' class="btn btn-warning btn-sm"><i class="bi bi-clipboard-data-fill"></i></a>

                            </td>
                            <td>
                                @php
                                    $badgeColor = ($item->status == 'Aktif') ? 'success' : (($item->status == 'Lulus') ? 'primary' : 'secondary');
                                    // Tambahkan kondisi untuk menentukan status "Selesai"
                                    if(isset($statusSelesai[$item->nim]) && $statusSelesai[$item->nim] == 1) {
                                        $status = 'Selesai';
                                        $badgeColor = 'info'; // Atur warna badge untuk status "Selesai"
                                        $icon = 'bi-check-circle-fill'; // Atur ikon untuk status "Selesai"
                                    } else {
                                        $status = $item->status;
                                        $icon = '';
                                    }
                                @endphp
                                <span class="badge bg-{{ $badgeColor }}">{{ $status }} <i class="bi {{ $icon }}"></i></span>
                            </td>
                            
                            
                        </tr>
                        
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
    </section>
          
    {{-- <script src="{{ asset('template/assets/static/js/components/dark.js')}}"></script>
    <script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('template/assets/compiled/js/app.js')}}"></script>  --}}
    {{-- <script src="{{ asset('template/assets/extensions/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('template/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('template/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('template/assets/static/js/pages/datatables.js')}}"></script> --}}
@endsection
{{-- @endsection --}}
