@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Tambah Nilai')

<div class="content-wrapper container">
  <div class="page-heading">
      <div class="page-title">
          <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                  <h3>Tambah Nilai</h3>
                  <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                  <div class="text-end">
                      <h4>{{ $peserta->nama }}</h4>
                      <p class="text-subtitle text-muted">{{ $peserta->nim }}</p>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="page-content">
    <form action="{{ route('nilai.store') }}" method="post" id="nilaiForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="nim_peserta" value="{{ $peserta->nim }}"> <!-- Nim peserta -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('uspenyelia.pengajuannilai', ['id_penyelia' => $penyelia->id]) }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nilai" class="form-label">Nilai</label>
                                            <input class="form-control" name="nilai" id="nilai" placeholder="Masukkan nilai 0-100" type="text" value="{{ Session::get('nilai') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="evaluasi" class="form-label">Evaluasi</label>
                                            <textarea class="form-control" name="evaluasi" id="evaluasi" rows="3" placeholder="Evaluasi" required>{{ Session::get('evaluasi') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary me-1 mb-1" id="submitBtn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                    $('#nilaiForm').submit();
                }
            });
        });

        $('#nilaiForm').submit(function (event) {
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