@extends('templates.master')

@section('content')
<h1 class="h3 mb-0 text-gray-800">Tambah Kelas</h1>

<div class="row">
    <div class="col-xl-6 col-md-8 col-sm-8">
        <div class="card mt-3 p-3">
            <form action="/kelas/{{ $kelas->id }}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" disabled>
                </div>

                <div class="form-group">
                    <label for="jurusan_id">Jurusan</label>
                    <input type="text" name="nama_kelas" class="form-control" value="{{ $jurusan->nama_jurusan }}" disabled>
                </div>

                <div class="form-group">
                    <label for="guru_id">Guru</label>
                    <select name="guru_id" class="form-control">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $data)
                        <option value="{{ $data->id }}" {{ $kelas->guru_id == $data->id ? 'selected' : '' }}>{{ $data->nama_guru }}</option>
                        @endforeach
                    </select>
                    <small class="text-secondary">*Isi jika ingin diganti</small>
                    @error('guru_id')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
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