@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Daftar Penyelia')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Penyelia</h3>
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
                    Penyelia
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                {{-- <th class=>No</th> --}}
                                {{-- <th class="col">ID</th> --}}
                                <th>Nama</th>
                                <th>NIP</th>
                                {{-- <th>Asal Instansi</th> --}}
                                {{-- <th class="col">Alamat</th> --}}
                                {{-- <th class="col">Tanggal Lahir</th> --}}
                                <th>Email</th>
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
                                {{-- <td>{{$i}}</td> --}}
                                {{-- <td>{{$item->id}}</td> --}}
                                <td title="{{$item->nama}}">{{{$item->nama}}}</td>
                                <td title="{{$item->id}}">{{$item->id}}</td>
                                {{-- <td title="{{isset($instansiManagers[$item->instansi_id]) ? $instansiManagers[$item->instansi_id] : 'N/A'}}"> {{ isset($instansiManagers[$item->instansi_id]) ? $instansiManagers[$item->instansi_id] : 'N/A' }}</td> --}}
                                {{-- <td title="{{$item->alamat}}">{{$item->alamat}}</td> --}}
                                <td title="{{$item->email}}">{{$item->email}}</td>
                                {{-- <td>{{$item->hp}}</td> --}}
                                {{-- <td>{{$item->tanggal_lahir}}</td> --}}
                                {{-- <td title="{{$item->jurusan}}">{{$item->jurusan}}</td> --}}
                                {{-- <td>{{$item->lama_kegiatan}}</td> --}}
                                <td>
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a href='{{url('penyelia/'.$item->id. '/edit')}}' title="Edit" type="button" class="btn btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button title="Hapus" type="button" name="submit" class="btn btn-danger delete-btn" data-id="{{$item->id}}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        
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
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    {{-- <script src="{{ asset('template/assets/extensions/sweetalert2/sweetalert2.min.js')}}"></script>>
    <script src="{{ asset('template/assets/static/js/pages/sweetalert2.js')}}"></script>> --}}
    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin akan menghapus data ini?',
                    text: "Tindakan ini tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{url('penyelia')}}/" + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (data) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // Toast success
            var successToast = '{{ session("success") }}';
            if (successToast) {
                toastr.success(successToast, '', {
                    closeButton: true,
                    progressBar: true,
                });
            }
        });
    </script>
@endsection
