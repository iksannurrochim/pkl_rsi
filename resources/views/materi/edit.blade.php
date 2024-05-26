@extends('layouts.templatepenyelia')
@section('model')
@section('judul', 'Edit Materi')

<style>
    .form-control[readonly] {
        background-color: #e9ecef;
        color: #495057;
    }
</style>

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Edit Materi</h3>
    </div>
    <div class="page-content">
        <form action="{{ route('materi.update', $materi->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('materi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nama_file" class="form-label">Nama Materi</label>
                                                <input type="text" class="form-control" id="nama_file" name="nama_file" value="{{ $materi->nama_file }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fileMateri" class="form-label">Upload File</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupFileAddon01" onclick="document.getElementById('fileMateri').click()" style="cursor: pointer;">
                                                            Upload File
                                                        </span>
                                                        <input type="file" class="form-control" id="fileMateri" name="file" accept="application/pdf" style="display: none;" onchange="showFileMateriName(this)">
                                                    </div>
                                                    <input type="text" class="form-control" id="fileMateriName" name="fileMateriName" placeholder="Nama File" value="{{ basename($materi->file) }}" readonly>
                                                </div>
                                                {{-- <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti file.</small> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showFileMateriName(input) {
        var fileName = input.files[0].name;
        document.getElementById('fileMateriName').value = fileName;
    }
</script>
@endsection
