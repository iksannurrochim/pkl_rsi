@extends('layouts.templatepeserta')
@section('model')
@section('judul', 'Dashboard Peserta')

<div class="content-wrapper container">
                
    <div class="page-heading">
        <h3>Dashboard Peserta</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    {{-- <h4>Profil</h4> --}}
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl">
                                            <img alt="image" src="{{ $peserta->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $peserta->foto) }}" >
                                        </div>
                                        <div class="ms-3 name">
                                            <h4 class="font-bold">{{ Auth::user()->username }}</h4>
                                            <a class="text-muted mb-0" style="font-size: 0.9em; ">NIM : {{ $peserta->nim }} | {{ $peserta->jurusan }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Status PKL</h6>
                                </div>
                                <div class="card-body">
                                    <div class="ms-3 name text-center">
                                        <h4 class="font-bold">Penyelia : {{ $peserta->penyelia->nama }}</h4>
                                        <a class="text-muted mb-0" style="font-size: 0.9em; ">(NIP : {{ $peserta->penyelia->id }})</a>
                                    </div>
                                    <div class="ms-3 mt-4 name text-center">
                                        <a class="text-muted mb-0 font-bold" style="font-size: 0.9em;">Status</a>
                                    </div>
                                    <div class="ms-3 mt-1 text-center">
                                        @if($peserta->status == 'Aktif')
                                            @php
                                                $pengajuan = $peserta->aju_nilai->where('pengajuan', 1)->first();
                                            @endphp
                                            @if($pengajuan)
                                                <span class="badge bg-primary">Selesai <i class="bi bi-check-circle-fill"></i></span>
                                            @else
                                                <span class="badge bg-success">Aktif</span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Peserta</h6>
                                        <h6 class="font-extrabold mb-0">1</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Materi</h6>
                                        <h6 class="font-extrabold mb-0">183.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Progres Sudah Diverifikasi</h6>
                                        <h6 class="font-extrabold mb-0">80.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-12">
                        {{-- <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                {{-- <div class="card">
                    <div class="card-body py-4 px-5">
                        
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('template/assets/compiled/jpg/1.jpg')}}" alt="Face 1">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->username }}</h5>
                                <a class="text-muted mb-0" style="font-size: 0.7em; font-weight: bold;">{{ Auth::user()->email }}</a>
                            </div>
                        </div>
                    </div>
                </div> --}}
                
                <div class="card">
                    <div class="card-header">
                        <h4>Profil</h4>
                        <a href="/peserta/edit_profil" class=" position-absolute top-0 end-0 mt-3 me-3" style="border-bottom: 1px solid blue;"><i class="bi bi-pencil-square"></i>ubah</a>
                    </div>
                    <div class="card-body">
                        <div class="ms-3 name">
                            {{-- <h4 class="font-bold">Penyelia : {{ $peserta->penyelia->nama }}</h4> --}}
                            <a class="font-bold mb-0" style="font-size: 0.9em; ">Mahasiswa</a>
                            
                            
                        </div>
                        <div class="ms-3 name">
                            <a class="text-muted mb-0 font-bold" style="font-size: 0.9em; ">{{ Auth::user()->email }}</a>
                        </div>
                        <div class="ms-3 name">
                            <a class="text-muted mb-0 font-bold" style="font-size: 0.9em; ">{{ $peserta->instansi->nama }}</a>
                        </div>
                        <div class="ms-3 name">
                            <a class="text-muted mb-0 font-bold" style="font-size: 0.9em; ">{{ $peserta->hp }}</a>
                        </div>
                        <div class="ms-3 name">
                            <a class="text-muted mb-0 font-bold" style="font-size: 0.9em; ">{{ $peserta->jurusan }}</a>
                        </div>
                        <hr> <!-- Garis -->
                        <div class="ms-3 mt-2 name text-center">
                            <a class="text-muted mb-0" style="font-size: 0.9em;">Pendidikan dan Pelatihan</a>
                        </div>
                        <div class="ms-3 text-center">
                            <a class="text-muted mb-0" style="font-size: 0.9em;">Rumah Sakit Islam Kendal</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
                </div>

@endsection