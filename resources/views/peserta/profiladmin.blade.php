@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Dashboard Admin')


<div class="page-heading">
    <h3>Dashboard Operator</h3>
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
                                    <h6 class="text-muted font-semibold">Peserta</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahPeserta }}</h6>
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
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Penyelia</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahPenyelia }}</h6>
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
                                    <div class="stats-icon green mb-2 d-flex align-items-center justify-content-center">
                                        <i class="iconly-boldHome"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Instansi</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahInstansi }}</h6>
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
                            <h4>Asal Instansi</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-12 col-xl-4">
                    
                </div>
                <div class="col-12 col-xl-8">
                    
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img alt="image" src="{{ $users->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $users->foto) }}" class="rounded-circle profile-widget-picture" style="width: 70px; height: 70px; display: block; margin: 0 auto;">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth::user()->username }}</h5>
                            <a href="/operator/edit_profil_operator"  style="border-bottom: 1px solid blue;"><i class="bi bi-pencil-square"></i>Lihat</a>
                            <h6 class="text-muted mb-0"></h6>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h4>Peserta</h4>
                </div>
                <div class="card-body">
                    <div id="chart-visitors-profile"></div>
                </div>
            </div> --}}
        {{-- </div> --}}

        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img alt="image" src="{{ $users->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $users->foto) }}" class="rounded-circle profile-widget-picture" style="width: 70px; height: 70px; display: block; margin: 0 auto;">
                            </div>
                            <div class="ms-3 name">
                                <h4 class="font-bold">{{ Auth::user()->username }}</h4>
                                
                                <a class="text-muted mb-0" style="font-size: 0.9em; ">{{ Auth::user()->email }}</a>
                                <br>
                                <a href="/operator/edit_profil_operator"  style="border-bottom: 1px solid blue;"><i class="bi bi-pencil-square"></i>Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = {!! json_encode($labels) !!};
        const values = {!! json_encode($values) !!};

        const ctx = document.getElementById('chart-profile-visit').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection