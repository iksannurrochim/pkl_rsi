@extends('layouts.templateadmin')
@section('model')
@section('judul', 'Ubah Password')

<style>
    .form-control[readonly] {
        background-color: #e9ecef;
        color: #495057;
    }
</style>

<div class="content-wrapper container">
    <div class="page-heading">
        <h3>Ubah Password</h3>
    </div>
    <div class="page-content">
        <form action="{{ route('ubah_password.update', $user->nomor_id) }}" method="post" id="progresForm" enctype="multipart/form-data">
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
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label>Password Lama</label>
                                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" placeholder="Password Lama" value="{{ old('nomor_id') }}"required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label>Password Baru</label>
                                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Password Baru" value="{{ old('nama') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label>Verifikasi Password Baru</label>
                                                <input type="password" class="form-control @error('ver_password') is-invalid @enderror" id="ver_password" name="ver_password" placeholder="Verifikasi Password Baru" value="{{ old('email') }}" required>
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
@endsection
