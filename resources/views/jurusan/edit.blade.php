@extends('templates.master')

@section('content')
<h1 class="h3 mb-0 text-gray-800">Edit Jurusan</h1>

<div class="row mt-3">
    <div class="col-xl-7 col-md-9 col-sm-8">
        <div class="card p-3">
            <form action="/jurusan/{{ $jurusan->id }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="nama_jurusan">Nama Jurusan</label>
                    <input type="text" name="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror" value="{{ $jurusan->nama_jurusan}}" autofocus>
                    @error('nama_jurusan')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <a href="/jurusan" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection