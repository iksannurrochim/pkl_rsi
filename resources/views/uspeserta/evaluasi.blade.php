@extends('layouts.templatepeserta')

@section('model')
@section('judul', 'Pengajuan Nilai')

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Evaluasi Peserta</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6>Ajukan Nilai</h6>
                            </div>
                            <div class="card-body">
                                <div class="ms-3 name text-center">
                                    <a class="text-muted mb-0" style="font-size: 0.9em;">Ajukan nilai dan evaluasi kepada penyelia apabila sudah memenuhi standar untuk menyelesaikan PKL</a><br>
                                    <a class="text-muted mb-0" style="font-size: 0.9em;">Pilih tombol di bawah untuk mengajukan nilai dan evaluasi, tunggu sampai penyelia memberi penilaian</a>
                                </div>
                                <div class="ms-3 mt-4 name text-center">
                                    @if($aju_nilai && $aju_nilai->pengajuan == 1)
                                        <span class="badge bg-success">Sudah Dinilai <i class="bi bi-check-circle-fill"></i></span>
                                        <br><br>
                                        <a href="{{ route('nilai.nilaipeserta', ['nim' => $peserta->nim]) }}" class="btn btn-primary">Lihat Nilai</a>
                                        {{-- <button id="batalkanAjukanNilaiBtn" type="button" class="btn btn-danger">Batalkan Ajukan</button> --}}
                                    @elseif($aju_nilai && $aju_nilai->pengajuan == 0)
                                        <span class="badge bg-warning text-dark">Menunggu Penilaian</span>
                                        <br><br>
                                        <form action="{{route('uspeserta.batal-ajukan', ['nim_peserta' => $peserta->nim])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Batal Ajukan</button>
                                        </form>
                                        {{-- <button id="batalkanAjukanNilaiBtn" type="button" class="btn btn-danger">Batalkan Ajukan</button> --}}
                                    @else
                                        <form action="{{ route('uspeserta.evaluasi') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ajukan Nilai</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Konfirmasi Ajukan -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pengajuan Nilai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengajukan nilai?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="konfirmasiForm" action="{{ route('uspeserta.evaluasi') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Ajukan Nilai</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ajukanNilaiBtn = document.querySelector('#ajukanNilaiBtn');
        const batalkanAjukanNilaiBtn = document.querySelector('#batalkanAjukanNilaiBtn');
        const konfirmasiModal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));
        const konfirmasiBatalModal = new bootstrap.Modal(document.getElementById('konfirmasiBatalModal'));

        ajukanNilaiBtn.addEventListener('click', function(e) {
            e.preventDefault();
            konfirmasiModal.show();
        });

        batalkanAjukanNilaiBtn.addEventListener('click', function(e) {
            e.preventDefault();
            konfirmasiBatalModal.show();
        });

        const konfirmasiForm = document.getElementById('konfirmasiForm');
        konfirmasiForm.addEventListener('submit', function() {
            konfirmasiModal.hide();
        });

        const batalAjukanNilaiForm = document.getElementById('batalAjukanNilaiForm');
        batalAjukanNilaiForm.addEventListener('submit', function() {
            konfirmasiBatalModal.hide();
        });
    });
</script>

@endsection
