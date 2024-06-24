@extends('layouts.templatepenyelia')

@section('model')
@section('judul', 'Nilai Peserta')

<style>
    .table-responsive table td {
        max-width: 300px;
        word-wrap: break-word;
    }
</style>

<div class="content-wrapper container">
    <div class="page-heading d-flex justify-content-between align-items-center">
        <div>
            <h3>Nilai Peserta</h3>
            <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
        </div>
        <div class="text-end">
            <h4>{{ $peserta->nama }}</h4>
            <p class="text-subtitle text-muted">{{ $peserta->nim }}</p>
        </div>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row" id="table-striped-dark">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('uspenyelia.pengajuannilai', $penyelia->id) }}" class="btn btn-secondary">Kembali</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-dark mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nilai</th>
                                            <th>Evaluasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nilai as $item)
                                        <tr>
                                            <td>{{ $item->nilai }}</td>
                                            <td>{{ $item->evaluasi }}</td>
                                            <td>
                                                <a href="{{ route('nilai.edit', $item->nim_peserta) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->nim_peserta}}">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{$item->nim_peserta}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$item->nim_peserta}}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{$item->nim_peserta}}">Konfirmasi Hapus</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus data ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('nilai.destroyNilai', $item->nim_peserta) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada nilai yang diberikan</td>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tampilkan SweetAlert setelah berhasil verifikasi
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    });
</script>
@endsection
