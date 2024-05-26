@extends('layouts.templatepeserta')
@section('model')
@section('judul', 'Tambah Progres')

<div class="content-wrapper container">
                
    <div class="page-heading">
        <h3>Tambah Progres</h3>
    </div>
    <div class="page-content">
        <form action='{{url('progres')}}' method='post' id="progresForm">
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
                                      <label for="progres" class="form-label">Kegiatan yang Terlaksana</label>
                                      <textarea class="form-control" name="progres" id="progres" rows="3" placeholder="Kegiatan yang kamu lakukan hari ini" type="text" value="{{ Session::get('progres') }}" required></textarea>
                                      
                                  {{-- <input
                                    type="text"
                                    id="company-column"
                                    class="form-control"
                                    name="company-column"
                                    placeholder="Company"
                                    data-parsley-required="true"
                                  /> --}}
                                </div>
                              </div>

                              <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                      <label for="keterangan" class="form-label">Keterangan (Hambatan, tantangan, dan pelaksanaan)</label>
                                      <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan" type="text" value="{{ Session::get('keterangan') }}" required></textarea>
                                      
                                  {{-- <input
                                    type="text"
                                    id="company-column"
                                    class="form-control"
                                    name="company-column"
                                    placeholder="Company"
                                    data-parsley-required="true"
                                  /> --}}
                                </div>
                              </div>

                              <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                  <label for="tanggal_lahir" class="form-label"
                                    >Tanggal</label
                                  >
                                  <input
                                    type="date"
                                    id="tanggal"
                                    class="form-control"
                                    name="tanggal"
                                    placeholder="Tanggal"
                                    data-parsley-required="true"
                                    value="{{ Session::get('tanggal') }}"
                                    required
                                  />
                                </div>
                            </div>

                          <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                              <button type="button" class="btn btn-primary me-1 mb-1" id="submitBtn">
                                Submit
                              </button>
                              {{-- <button
                                type="reset"
                                class="btn btn-light-secondary me-1 mb-1"
                              >
                                Reset
                              </button> --}}
                            </div>
                          </div>
                        </form>
    </div>
    
</div>
{{-- <script src="{{ asset('template/assets/static/js/components/dark.js')}}"></script>
<script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{ asset('template/assets/compiled/js/app.js')}}"></script> --}}

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
                    $('#progresForm').submit();
                }
            });
        });

        $('#progresForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            // Perform form submission via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    // Show SweetAlert upon successful submission
                    Swal.fire({
                        title: 'Berhasil Menambahkan Progres',
                        text: 'Progres berhasil ditambahkan!',
                        icon: 'success',
                        timer: 1500, 
                        timerProgressBar: true, // Display progress bar
                        showConfirmButton: false // Hide the 'OK' button
                    }).then((result) => {
                        // Redirect to progres page upon SweetAlert confirmation
                        window.location.href = '{{ route('uspeserta.progres') }}';
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