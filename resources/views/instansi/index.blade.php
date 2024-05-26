@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Daftar Instansi')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Instansi</h3>
                <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                {{-- <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable jQuery</li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>

    <!-- Minimal jQuery Datatable start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Instansi
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                {{-- <th class=>No</th> --}}
                                {{-- <th class="col">ID</th> --}}
                                <th>Nama Instansi</th>
                                <th>Alamat</th>
                                {{-- <th>Asal Instansi</th> --}}
                                {{-- <th class="col">Alamat</th> --}}
                                {{-- <th class="col">Tanggal Lahir</th> --}}
                                {{-- <th>Email</th> --}}
                                {{-- <th class="col">No HP</th> --}}
                                {{-- <th>Jurusan</th> --}}
                                {{-- <th class="col">Lama Kegiatan</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = $data->firstItem()?>
                            @foreach ($data as $item)
                            <tr>
                                <td title="{{$item->nama}}">{{{$item->nama}}}</td>
                                <td title="{{$item->alamat}}">{{$item->alamat}}</td>
                                <td>
                                    {{-- <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a href='{{url('instansi/'.$item->id. '/edit')}}' title="Edit" type="button" class="btn btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form onsubmit="return confirm('Yakin akan menghapus data ini?')" class='d-inline' action="{{url('instansi/'.$item->id)}}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                            <button title="Hapus" type="submit" name="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div> --}}

                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a href='{{url('instansi/'.$item->id. '/edit')}}' title="Edit" type="button" class="btn btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{$item->id}}">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{url('instansi/'.$item->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        

    </section>

    {{-- <script src="{{ asset('template/assets/static/js/components/dark.js')}}"></script> --}}
    <script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    {{-- <script src="{{ asset('template/assets/compiled/js/app.js')}}"></script> --}}
    <script src="{{ asset('template/assets/extensions/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('template/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('template/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('template/assets/static/js/pages/datatables.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
<script>
    // Tampilkan SweetAlert setelah berhasil verifikasi
    @if (session('delete'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menghapus Peserta!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>

@endsection