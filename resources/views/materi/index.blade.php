@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Materi')

<style>
    .table-responsive table td {
        max-width: 300px; /* Ubah sesuai kebutuhan */
        word-wrap: break-word; /* Memaksa teks untuk pindah baris jika terlalu panjang */
    }
</style>

<div class="content-wrapper container">
    <div class="page-heading">
        <div class="page-title">
            <div class="row" id="table-striped-dark">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Materi</h3>
                    <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row" id="table-striped-dark">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('materi.create') }}" class="btn btn-primary">Tambah Materi</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-dark mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($materis as $index => $materi)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#previewModal-{{ $materi->id }}">{{ $materi->nama_file }}</a>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                            <a href="{{ route('materi.edit', $materi->id) }}" title="Edit" type="button" class="btn btn-primary">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $materi->id }}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>

                                                        <!-- Modal Hapus -->
                                                        <div class="modal fade" id="deleteModal-{{ $materi->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $materi->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteModalLabel-{{ $materi->id }}">Konfirmasi Hapus</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin menghapus data ini?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <form action="{{ route('materi.destroy', $materi->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Preview -->
                                                        <div class="modal fade" id="previewModal-{{ $materi->id }}" tabindex="-1" aria-labelledby="previewModalLabel-{{ $materi->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="previewModalLabel-{{ $materi->id }}">Preview Dokumen</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <iframe src="{{ asset($materi->file) }}" frameborder="0" width="100%" height="500px"></iframe>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Silakan tambahkan materi</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    @if (session('cancel'))
        Swal.fire({
            icon: 'success',
            title: 'Dibatalkan!',
            text: '{{ session('cancel') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>

@endsection
