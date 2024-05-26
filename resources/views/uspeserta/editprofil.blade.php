@extends('layouts.templatepeserta')
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
        <form action="{{ route('uspeserta.update', $peserta->nim) }}" method="post" id="progresForm" enctype="multipart/form-data">
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
                                                <img alt="image" src="{{ $peserta->foto == null ? asset('template/assets/compiled/jpg/1.jpg') : asset('files/Profile/' . $peserta->foto) }}" class="rounded-circle profile-widget-picture" style="width: 120px; height: 120px; display: block; margin: 0 auto;">
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
                                                <input class="form-control" name="nama" id="nama" placeholder="Nama" value="{{ old('nama', $peserta->nama) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="nim" class="form-label">NIM</label>
                                                <input class="form-control" name="nim" id="nim" placeholder="NIM" value="{{ old('nim', $peserta->nim) }}" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="jurusan" class="form-label">Program Studi</label>
                                                <input class="form-control" name="jurusan" id="jurusan" placeholder="Program Studi" value="{{ old('jurusan', $peserta->jurusan) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email', $peserta->user->email) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="instansi_id" class="form-label">Asal Instansi</label>
                                                <fieldset class="form-group">
                                                    <select name="instansi_id" class="form-select" id="basicSelect" required>
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($instansis as $item)
                                                            <option value="{{ $item->id }}" {{ $item->id == $peserta->instansi_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="penyelia" class="form-label">Penyelia</label>
                                                <fieldset class="form-group">
                                                    <input type="text" class="form-control" id="penyelia" value="{{ $peserta->penyelia->nama }}" readonly />
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="hp" class="form-label">No HP</label>
                                                <input class="form-control" name="hp" id="hp" placeholder="No HP" value="{{ old('hp', $peserta->hp) }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="status" class="form-label">Status</label>
                                                <input class="form-control" name="status" id="status" placeholder="Status" value="{{ old('status', $peserta->status) }}" required readonly />
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
    

    function showFileName(input) {
        var fileName = input.files[0].name;
        $('#fileName').text(fileName);
    }
</script>
@endsection
