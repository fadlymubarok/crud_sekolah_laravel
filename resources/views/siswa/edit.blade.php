@extends('templates.master')

@section('content')
<h1 class="h3 mb-0 text-gray-800">Edit Siswa</h1>

<div class="row">
    <div class="col-xl-6 col-md-8 col-sm-8">
        <div class="card mt-3 p-3">
            <form action="/siswa/{{ $siswa->id }}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="nama_siswa">Nama siswa</label>
                    <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $siswa->nama_siswa) }}">
                    @error('nama_siswa')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tgl_lahir_siswa">Tanggal Lahir Siswa</label>
                    <input type="date" name="tgl_lahir_siswa" class="form-control @error('tgl_lahir_siswa') is-invalid @enderror" value="{{ old('tgl_lahir_siswa', $siswa->tgl_lahir_siswa) }}">
                    @error('tgl_lahir_siswa')
                    <div class=" text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat_siswa">Alamat siswa</label>
                    <textarea name="alamat_siswa" class="form-control @error('alamat_siswa') is-invalid @enderror" cols="20" rows="3">{{ $siswa->alamat_siswa}}</textarea>
                    @error('alamat_siswa')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <a href="/siswa" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection