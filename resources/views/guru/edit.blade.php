@extends('templates.master')

@section('content')
<h1 class="h3 mb-0 text-gray-800">Edit Data Guru</h1>

<div class="row">
    <div class="col-xl-6 col-md-8 col-sm-8">
        <div class="card mt-3 p-3">
            <form action="/guru/{{ $data->id }}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="nama_guru">Nama guru</label>
                    <input type="text" name="nama_guru" class="form-control" value="{{ $data->nama_guru }}" disabled>
                </div>

                <div class="form-group">
                    <label for="alamat_guru">Alamat Guru</label>
                    <textarea name="alamat_guru" class="form-control @error('alamat_guru') is-invalid @enderror" cols="20" rows="3" disabled>{{ $data->alamat_guru }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status_aktif">Status Aktif</label>
                    <select name="status_aktif" class="form-control">
                        <option value="0" {{ $data->status_aktif == 0 ? 'selected' : ''}}>Tidak aktif</option>
                        <option value="1" {{ $data->status_aktif == 1 ? 'selected' : ''}}>Aktif</option>
                    </select>
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