@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Tambah Peserta')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Form Tambah Peserta</h3>
                <p class="text-subtitle text-muted">Lengkapi Data Untuk Menambah Peserta.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Tambah Peserta</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- // Basic multiple Column Form section start -->
    <form id="pesertaForm" action='{{url('peserta')}}' method='post'>
        @csrf
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" data-parsley-validate>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" id="nama" class="form-control" placeholder="Nama" name="nama" data-parsley-required="true" value="{{ Session::get('nama') }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="nim" class="form-label">NIM</label>
                                                <input type="text" id="nim" class="form-control" placeholder="Nomor Identitas" name="nim" data-parsley-required="true" value="{{ Session::get('nim') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="jurusan" class="form-label">Program Studi</label>
                                                <input type="text" id="jurusan" class="form-control" placeholder="Program Studi" name="jurusan" data-parsley-required="true" value="{{ Session::get('jurusan') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="instansi_id" class="form-label">Asal Instansi</label>
                                                <fieldset class="form-group">
                                                    <select name="instansi_id" class="form-select" id="basicSelect" required>
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($instansis as $item)
                                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" data-parsley-required="true" value="{{ Session::get('email') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="hp" class="form-label">No. HP</label>
                                                <input type="text" id="hp" class="form-control" name="hp" placeholder="Nomor HP" data-parsley-required="true" value="{{ Session::get('hp') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat" required>{{ Session::get('alamat') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" placeholder="Tanggal Lahir" data-parsley-required="true" value="{{ Session::get('tanggal_lahir') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="id_penyelia" class="form-label">Penyelia</label>
                                                <fieldset class="form-group">
                                                    <select name="id_penyelia" class="form-select" id="basicSelect" required>
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($penyelia as $item)
                                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="button" id="submitBtn" class="btn btn-primary me-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </form>
</div>
<script src="{{ asset('template/assets/static/js/initTheme.js')}}"></script>
<script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{ asset('template/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('template/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ asset('template/assets/static/js/pages/parsley.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $('#submitBtn').click(function () {
            Swal.fire({
                title: 'Apakah data yang dimasukkan sudah benar?',
                text: "Pastikan data yang dimasukkan sudah sesuai sebelum disimpan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Tidak, batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#pesertaForm').submit();
                }
            });
        });

        $('#pesertaForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            // Perform form submission via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    // Show SweetAlert upon successful submission
                    Swal.fire({
                        title: 'Berhasil Menambahkan Peserta',
                        text: 'Peserta berhasil ditambahkan!',
                        icon: 'success',
                        timer: 1500, 
                        timerProgressBar: true, // Display progress bar
                        showConfirmButton: false // Hide the 'OK' button
                    }).then((result) => {
                        // Redirect to progres page upon SweetAlert confirmation
                        window.location.href = "{{ url('peserta') }}";
                    });
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle error case if necessary
                }
            });
        });
    });
</script>
@endsection
