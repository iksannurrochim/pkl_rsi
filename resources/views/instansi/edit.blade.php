@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Edit Instansi')

<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Form Edit Instansi</h3>
          <p class="text-subtitle text-muted">
            Lengkapi Data Untuk Edit Instansi.
          </p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav
            aria-label="breadcrumb"
            class="breadcrumb-header float-start float-lg-end"
          >
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Edit Instansi</a></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  
    <!-- // Basic multiple Column Form section start -->
    <form id="editForm" action='{{ url('instansi/'.$data->id) }}' method='post'>
    @csrf
    @method('PUT')
    <section id="multiple-column-form">
      <div class="row match-height">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="{{ url('instansi') }}" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form class="form" data-parsley-validate>
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group mandatory">
                        <label for="nama" class="form-label">Nama Instansi</label>
                        <input
                          type="text"
                          id="nama"
                          class="form-control"
                          placeholder="Nama"
                          name='nama'
                          data-parsley-required="true"
                          value="{{ $data->nama }}"
                          required
                        />
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                              <label for="alamat" class="form-label">Alamat</label>
                              <textarea class="form-control" name='alamat' id="alamat" rows="3" placeholder="Alamat" required>{{ $data->alamat }}</textarea>
                        </div>
                      </div>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                      <button type="button" id="submitBtn" class="btn btn-primary me-1 mb-1">
                        Submit
                      </button>
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
          </div>
      </div>
      <script src="{{ asset('template/assets/static/js/components/dark.js')}}"></script>
      <script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
      
      
      <script src="{{ asset('template/assets/compiled/js/app.js')}}"></script>
      
  
      
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
                    $('#editForm').submit();
                }
            });
        });

        $('#editForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            // Perform form submission via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    // Show SweetAlert upon successful submission
                    Swal.fire({
                        title: 'Berhasil Mengedit Instansi',
                        text: 'Instansi berhasil Diedit!',
                        icon: 'success',
                        timer: 1500, 
                        timerProgressBar: true, // Display progress bar
                        showConfirmButton: false // Hide the 'OK' button
                    }).then((result) => {
                        // Redirect to progres page upon SweetAlert confirmation
                        window.location.href = "{{ url('instansi') }}";
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
