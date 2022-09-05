@extends('templates.master')

@section('content')
<h1 class="h3 mb-0 text-gray-800">Tambah Kelas</h1>

<div class="row">
    <div class="col-xl-6 col-md-8 col-sm-8">
        <div class="card mt-3 p-3">
            <form action="/kelas" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas') }}" placeholder="X-1" autofocus>
                    @error('nama_kelas')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jurusan_id">Jurusan</label>
                    <select name="jurusan_id" class="form-control">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusan as $data)
                        <option value="{{ $data->id }}" {{ old('jurusan_id') == $data->id ? 'selected' : '' }}>{{ $data->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="guru_id">Guru</label>
                    @if($guru->count() > 0)
                    <select name="guru_id" class="form-control">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $data)
                        <option value="{{ $data->id }}" {{ old('guru_id') == $data->id ? 'selected' : '' }}>{{ $data->nama_guru }}</option>
                        @endforeach
                    </select>
                    @error('guru_id')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                    @else
                    <input type="text" class="form-control" value="Tambah Guru Baru!!" disabled>
                    @endif
                </div>

                <div class="form-group">
                    <a href="/kelas" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection