
@extends('layouts.templatepeserta')
@section('model')
@section('judul', 'Progres Peserta')


<style>
    /* Atur lebar maksimum untuk kolom tabel */
    .table-responsive table td {
        max-width: 300px; /* Ubah sesuai kebutuhan */
        word-wrap: break-word; /* Memaksa teks untuk pindah baris jika terlalu panjang */
    }
</style>

<div class="content-wrapper container">
                
    <div class="page-heading">
        {{-- <h3>Progres Peserta</h3> --}}
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row" id="table-striped-dark">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Progres</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                            </div>
                            <!-- table strip dark -->
                            <div class="table-responsive">
                                <table class="table table-striped table-dark mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kegiatan yang Terlaksana</th>
                                            <th>Keterangan (Hambatan, Tantangan, dan Pelaksanaan)</th>
                                            <th>Aksi</th>
                                            <th>Verifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($progres as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->progres }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                @if ($item->status != 'Sudah')
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->no}}">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{$item->no}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$item->no}}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{$item->no}}">Konfirmasi Hapus</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus data ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ url('uspeserta/'.$item->no) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    @if ($item->status == 'Belum')
                                                        <a href="{{ url('uspeserta/'.$item->no.'/editprogres') }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'Belum')
                                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                                @elseif ($item->status == 'Sudah')
                                                    <span class="badge bg-success">{{ $item->status }}</span>
                                                @else
                                                    <span>{{ $item->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">Tidak ada data progres tersedia.</td>
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
    // Tampilkan SweetAlert setelah berhasil verifikasi
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Hapus!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        // Handle successful deletion with SweetAlert
        $('[id^=deleteModal]').on('hidden.bs.modal', function (event) {
            if ($(this).data('bs.modal')._isShown) {
                Swal.fire({
                    title: 'Berhasil Menghapus Progres',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000 // Show for 2 seconds
                });
            }
        });
    });
</script> --}}
@endsection