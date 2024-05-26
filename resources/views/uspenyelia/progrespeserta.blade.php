@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Progres Peserta')


<style>
    /* Atur lebar maksimum untuk kolom tabel */
    .table-responsive table td {
        max-width: 300px; /* Ubah sesuai kebutuhan */
        word-wrap: break-word; /* Memaksa teks untuk pindah baris jika terlalu panjang */
    }

    .card-header {
        padding-bottom: 2px; 
        margin-bottom: 2px; 
    }
</style>

<div class="content-wrapper container">
                
    <div class="page-heading">
        {{-- <h3>Progres Peserta</h3> --}}
        <div class="page-title">
            <div class="row" id="table-striped-dark">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Progres Peserta</h3>
                    <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
                </div>
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <div class="text-end">
                        <h4>{{ $peserta->nama }}</h4>
                        {{-- <p> {{ $peserta->nama }}</p> --}}
                        <p class="text-subtitle text-muted">{{ $peserta->nim }}</p>
                    </div>
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
                            <a href="{{ route('uspenyelia.index', ['id_penyelia' => $penyelia->id]) }}" class="btn btn-primary">Kembali</a>
                            {{-- <h4 class="card-title">Verifikasi</h4> --}}
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
                                            {{-- <th>Nama</th> --}}
                                            <th>Tanggal</th>
                                            <th>Kegiatan yang Terlaksana</th>
                                            <th>Keterangan (Hambatan, Tantangan, dan Pelaksanaan)</th>
                                            
                                            <th>Verifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse($progres as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->progres }}</td>
                                            <td>{{ $item->keterangan }}</td>

                                            <td>
                                                @if ($item->status == 'Belum' || is_null($item->status))
                                                    <!-- Tombol Verifikasi dengan Modal Konfirmasi -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verifikasiModal{{$item->no}}">
                                                        Verifikasi
                                                    </button>
                                                    <!-- Modal Konfirmasi Verifikasi -->
                                                    <div class="modal fade" id="verifikasiModal{{$item->no}}" tabindex="-1" aria-labelledby="verifikasiModalLabel{{$item->no}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('uspenyelia.verifprogres', ['id_penyelia' => $penyelia->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="no" value="{{ $item->no }}">
                                                                    <input type="hidden" name="status" value="Sudah">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="verifikasiModalLabel{{$item->no}}">Konfirmasi Verifikasi</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin melakukan verifikasi progres?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger">Verifikasi</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($item->status == 'Sudah')
                                                    <!-- Tombol Batalkan dengan Modal Konfirmasi -->
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#batalkanModal{{$item->no}}">
                                                        Batalkan
                                                    </button>
                                                    <!-- Modal Konfirmasi Pembatalan Verifikasi -->
                                                    <div class="modal fade" id="batalkanModal{{$item->no}}" tabindex="-1" aria-labelledby="batalkanModalLabel{{$item->no}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('uspenyelia.batalVerifikasi', ['id_penyelia' => $penyelia->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="no" value="{{ $item->no }}">
                                                                    <input type="hidden" name="status" value="Belum">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="batalkanModalLabel{{$item->no}}">Konfirmasi Pembatalan Verifikasi</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin membatalkan verifikasi progres?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-warning">Batalkan Verifikasi</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span>{{ $item->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">Progres masih kosong x_x.</td>
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
            title: 'Verifikasi Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    // Tampilkan SweetAlert setelah berhasil membatalkan verifikasi
    @if (session('cancel'))
        Swal.fire({
            icon: 'success',
            title: 'Verifikasi Dibatalkan!',
            text: '{{ session('cancel') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>

@endsection