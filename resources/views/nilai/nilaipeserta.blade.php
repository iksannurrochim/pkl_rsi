@extends('layouts.templatepeserta')
@section('model')
@section('judul', 'Nilai Peserta')

<style>
    /* Atur lebar maksimum untuk kolom tabel */
    .table-responsive table td {
        max-width: 300px; /* Ubah sesuai kebutuhan */
        word-wrap: break-word; /* Memaksa teks untuk pindah baris jika terlalu panjang */
    }
</style>

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Nilai Peserta</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row" id="table-striped-dark">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('uspeserta/evaluasi') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body"></div>
                            <!-- table strip dark -->
                            <div class="table-responsive">
                                <table class="table table-striped table-dark mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nilai</th>
                                            <th>Evaluasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nilai as $item)
                                        <tr>
                                            <td>{{ $item->nilai }}</td>
                                            <td>{{ $item->evaluasi }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Belum ada nilai yang diberikan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
