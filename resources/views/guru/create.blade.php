@extends('templates.master')

@section('content')
<h1 class="h3 mb-0 text-gray-800">Tambah Data Guru</h1>

<div class="row">
    <div class="col-xl-8 col-md-9 col-sm-10">
        <div class="card mt-3 p-3">
            <form action="/guru" method="post">
                @csrf

                <div class="d-flex">
                    <div class="form-group w-50 mr-2">
                        <label for="nama_depan">Nama depan</label>
                        <input type="text" name="nama_depan" class="form-control @error('nama_depan') is-invalid @enderror" autofocus>
                        @error('nama_depan')
                        <div class="text-danger"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class="form-group w-50">
                        <label for="nama_belakang">Nama belakang</label>
                        <input type="text" name="nama_belakang" class="form-control @error('nama_belakang') is-invalid @enderror">
                        @error('nama_belakang')
                        <div class="text-danger"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex">
                    <div class="form-group w-50 mr-2">
                        <label for="tanggal_lahir_guru">Tanggal Lahir Guru</label>
                        <input type="date" name="tanggal_lahir_guru" class="form-control @error('tanggal_lahir_guru') is-invalid @enderror">
                        @error('tanggal_lahir_guru')
                        <div class="text-danger"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class="form-group w-50">
                        <label for="alamat_guru">Alamat Guru</label>
                        <textarea name="alamat_guru" class="form-control @error('alamat_guru') is-invalid @enderror" cols="20" rows="3"></textarea>
                        @error('alamat_guru')
                        <div class="text-danger"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <a href="/guru" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection