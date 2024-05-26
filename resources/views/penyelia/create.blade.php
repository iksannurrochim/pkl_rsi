@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Tambah Penyelia')

<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Form Tambah Penyelia</h3>
          <p class="text-subtitle text-muted">
            Lengkapi Data Untuk Menambah Penyelia.
          </p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav
            aria-label="breadcrumb"
            class="breadcrumb-header float-start float-lg-end"
          >
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Tambah Penyelia</a></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
      <div class="row match-height">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Form</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form id="form-penyelia" method="post" action="{{ url('penyelia') }}" class="form" data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" class="form-control" placeholder="Nama" name="nama" data-parsley-required="true" value="{{ Session::get('nama') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="id" class="form-label">NIP</label>
                                <input type="text" id="id" class="form-control" placeholder="Nomor Identitas" name="id" data-parsley-required="true" value="{{ Session::get('id') }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" data-parsley-required="true" value="{{ Session::get('email') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary me-1 mb-1" id="submitBtn">Submit</button>
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
</div>
{{-- <script src="{{ asset('template/assets/static/js/components/dark.js')}}"></script> --}}
<script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
{{-- <script src="{{ asset('template/assets/compiled/js/app.js')}}"></script> --}}
<script src="{{ asset('template/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('template/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ asset('template/assets/static/js/pages/parsley.js')}}"></script>
<script src="{{ asset('template/assets/extensions/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('template/assets/static/js/pages/sweetalert2.js')}}"></script>

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
                    $('#form-penyelia').submit();
                }
            });
        });
        $('#form-penyelia').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            // Perform form submission via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    // Show SweetAlert upon successful submission
                    Swal.fire({
                        title: 'Berhasil Menambahkan Penyelia',
                        text: 'Penyelia berhasil ditambahkan!',
                        icon: 'success',
                        timer: 1500, 
                        timerProgressBar: true, // Display progress bar
                        showConfirmButton: false // Hide the 'OK' button
                    }).then((result) => {
                        // Redirect to progres page upon SweetAlert confirmation
                        window.location.href = "{{ url('penyelia') }}";
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
