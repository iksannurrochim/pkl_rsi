@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Pengajuan Nilai')

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Pengajuan Nilai</h3>
        <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    @foreach($pesertaList as $peserta)
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xl">
                                                <img src="{{ asset('template/assets/compiled/jpg/1.jpg')}}" alt="Face 1">
                                            </div>
                                            <div class="ms-3 name">
                                                <h4 class="font-bold">{{ $peserta->nama }}</h4>
                                                <a class="text-muted mb-0" style="font-size: 0.9em;">NIM : {{ $peserta->nim }}</a>
                                            </div>
                                            <div class="ms-auto">
                                                @php
                                                    // Akses relasi aju_nilai dan cek nilai pengajuan
                                                    $ajuNilai = $peserta->aju_nilai->first();
                                                    $pengajuan = $ajuNilai ? $ajuNilai->pengajuan : null;
                                                @endphp
                                                @if($pengajuan === 0)
                                                    <a href='{{ route("nilai.shownilai", $peserta->nim) }}' class="btn btn-primary">Tambah Nilai</a>
                                                @elseif($pengajuan === 1)
                                                    <a href='{{ route("uspenyelia.lihatnilai", $peserta->nim) }}' class="btn btn-success">Lihat Nilai</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
