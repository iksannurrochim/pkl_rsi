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
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a href='{{url('instansi/'.$item->id. '/edit')}}' title="Edit" type="button" class="btn btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form id="delForm{{$item->id}}" action="{{url('instansi/'.$item->id)}}" method="post" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button title="Hapus" type="button" class="btn btn-danger delete-btn" data-id="{{$item->id}}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('.delete-btn').click(function () {
            var formId = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda tidak dapat mengembalikan data yang dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to delete the data
                    $.ajax({
                        url: $('#delForm' + formId).attr('action'),
                        method: 'POST',
                        data: $('#delForm' + formId).serialize(),
                        success: function (response) {
                            Swal.fire({
                                title: 'Berhasil Menghapus Instansi',
                                text: 'Instansi Berhasil Dihapus',
                                icon: 'success',
                                timer: 1500, 
                                timerProgressBar: true, // Display progress bar
                                showConfirmButton: false // Hide the 'OK' button
                            }).then((result) => {
                                // Reload the page upon SweetAlert confirmation
                                location.reload();
                            });
                        },
                        error: function (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Gagal Menghapus Instansi',
                                text: 'Terjadi kesalahan saat menghapus instansi',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
