@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Dashboard Penyelia')

<div class="content-wrapper container">
                
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
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
                                        <h6 class="font-extrabold mb-0">{{ $jumlahPesertaPenyelia }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
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
                                        <h6 class="font-extrabold mb-0">{{ $jumlahMateri  }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            {{-- <i class="iconly-boldAdd-User"></i> --}}
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Pengajuan Nilai</h6>
                                        <h6 class="font-extrabold mb-0">{{ $ajukannilai }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Progres Belum Diverifikasi</h6>
                                        <h6 class="font-extrabold mb-0">{{ $jumlahProgresBelum }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <img alt="image" src="{{ $penyelia->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $penyelia->foto) }}" class="rounded-circle profile-widget-picture" style="width: 70px; height: 70px; display: block; margin: 0 auto;">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->username }}</h5>
                                <a class="text-muted mb-0" style="font-size: 0.7em; font-weight: bold;">{{ Auth::user()->email }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    <img alt="image" src="{{ $penyelia->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $penyelia->foto) }}" class="rounded-circle profile-widget-picture" style="width: 70px; height: 70px; display: block; margin: 0 auto;">
                                </div>
                                <div class="ms-3 name">
                                    <h4 class="font-bold">{{ Auth::user()->username }}</h4>
                                    <a class="text-muted mb-0" style="font-size: 0.9em; ">NIP : {{ $penyelia->id }} | {{ Auth::user()->email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection