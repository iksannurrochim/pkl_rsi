@extends('layouts.templatepenyelia')

@section('model')
@section('judul', 'Edit Nilai')

<div class="content-wrapper container">
    <div class="page-heading d-flex justify-content-between align-items-center">
        <div>
            <h3>Nilai Peserta</h3>
            <p class="text-subtitle text-muted">Pendidikan dan Pelatihan Rumah Sakit Islam Muhammadiyah Kendal.</p>
        </div>
        <div class="text-end">
            <h4>{{ $peserta->nama }}</h4>
            <p class="text-subtitle text-muted">{{ $peserta->nim }}</p>
        </div>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href='{{ route("uspenyelia.lihatnilai", $peserta->nim) }}' class="btn btn-secondary">Kembali</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="createForm" action="{{ route('nilai.update', $nilai->nim_peserta) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nilai">Nilai</label>
                                                <input type="number" class="form-control" id="nilai" name="nilai" value="{{ $nilai->nilai }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="evaluasi">Evaluasi</label>
                                                <textarea class="form-control" id="evaluasi" name="evaluasi" rows="3" required>{{ $nilai->evaluasi }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end"> <!-- Penambahan class text-end untuk menempatkan tombol di sebelah kanan -->
                                        <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="{{ asset('template/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('template/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ asset('template/assets/static/js/pages/parsley.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    $('#createForm').submit();
                }
            });
        });

        $('#createForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            // Perform form submission via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    // Show SweetAlert upon successful submission
                    Swal.fire({
                        title: 'Berhasil Mengedit Penyelia',
                        text: 'Penyelia berhasil Diedit!',
                        icon: 'success',
                        timer: 1500,
                        timerProgressBar: true, // Display progress bar
                        showConfirmButton: false // Hide the 'OK' button
                    }).then((result) => {
                        // Redirect to progres page upon SweetAlert confirmation
                        window.location.href = '{{ route("uspenyelia.lihatnilai", $peserta->nim) }}';
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
