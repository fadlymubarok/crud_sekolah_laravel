@extends('templates.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Guru</h1>
    <a href="/guru/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Create new</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Guru</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Username</th>
                        <th>Alamat Guru</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nama_guru }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->alamat_guru }}</td>
                        <td>@if($row->status_aktif == 1)
                            <div class="badge badge-info py-2 px-3">Aktif</div>
                            @else
                            <div class="badge badge-danger py-2 px-3">Tidak aktif</div>
                            @endif
                        </td>
                        <td>
                            <a href="/guru/{{ $row->id }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                            <button type="submit" class="btn btn-danger" onclick="remove('{{ $row->id }}')"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function funRemove(id) {
        $.ajax({
            url: '{{ url("guru") }}/' + id,
            dataType: 'json',
            type: "delete",
            data: {
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Harap tunggu...',
                    text: "Loading...",
                    didOpen: function() {
                        showCancelButton: false,
                        Swal.showLoading()
                    }
                })
            },
            success: function(data) {
                if (data.status == 404) {
                    Swal.hideLoading();
                    Swal.fire("Error! ", data.message, "error");
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Done',
                        text: data.message,
                        showCancelButton: false,
                    }).then(function(isTrue) {
                        if (isTrue.value) {
                            location.reload()
                        }
                    })
                }
            }
        })
    }
</script>
@endsection