@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Edit Profil')

<style>
    .form-control[readonly] {
        background-color: #e9ecef;
        color: #495057;
    }
</style>

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Edit Profil</h3>
    </div>
    <div class="page-content">
        <form id="editForm" action="{{ route('edit_profil_penyelia.update', $penyelia->id) }}" method="post"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row mt-1 mb-1">
                                        <div class="form-group text-center w-100">
                                            <div style="text-align: center;">
                                                <img alt="image" src="{{ $penyelia->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $penyelia->foto) }}" class="rounded-circle profile-widget-picture" style="width: 120px; height: 120px; display: block; margin: 0 auto;">
                                            </div>
                                            <br>
                                            <span class="bi bi-pencil-square" onclick="document.getElementById('fileProfile').click()" style="cursor: pointer;">
                                                Pilih Foto Profil
                                            </span>
                                            <input type="file" id="fileProfile" name="fileProfile" accept="image/*" style="display: none;" onchange="showFileName(this)">
                                            <div id="fileName" class="mt-2"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input class="form-control" name="nama" id="nama" placeholder="Nama" value="{{ old('nama', $penyelia->nama) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="id" class="form-label">NIP</label>
                                                <input class="form-control" name="id" id="id" placeholder="NIP" value="{{ old('id', $penyelia->id) }}" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email', $penyelia->user->email) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="hp" class="form-label">No HP</label>
                                                <input class="form-control" name="hp" id="hp" placeholder="No HP" value="{{ old('hp', $penyelia->hp) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" id="submitBtn">Submit</button>
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

<script src="{{ asset('template/assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/extensions/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('template/assets/static/js/pages/parsley.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    $('#submitBtn').click(function (event) {
        event.preventDefault(); // Prevent default form submission
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "ingin mengubah data",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah data',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#editForm')[0];
                var formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // Show SweetAlert upon successful submission
                        Swal.fire({
                            title: 'Berhasil Mengubah Data',
                            text: 'Data Berhasil Diubah',
                            icon: 'success',
                            timer: 1500,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then((result) => {
                            // Redirect to dashboard upon SweetAlert confirmation
                            window.location.href = "{{ url('dashboard') }}";
                        });
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        // Handle error case if necessary
                    }
                });
            }
        });
    });
});
</script>

<script>
    

    function showFileName(input) {
        var fileName = input.files[0].name;
        $('#fileName').text(fileName);
    }
</script>
@endsection
