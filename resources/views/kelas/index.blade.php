@extends('templates.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Kelas</h1>
    <a href="/kelas/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Create new</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jurusan</th>
                        <th>Nama Kelas</th>
                        <th>Nama Wali Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->jurusan->nama_jurusan }}</td>
                        <td>{{ $row->nama_kelas }}</td>
                        <td>{{ $row->guru->nama_guru }}</td>
                        <td>
                            <a href="/kelas/{{ $row->id }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
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
            url: "{{ url('kelas') }}/" + id,
            type: 'delete',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Harap tunggu',
                    text: 'Loading...',
                    didOpen: function() {
                        showCancelButton: false,
                        Swal.showLoading();
                    }
                })
            },
            success: function(data) {
                if (data.status == 404) {
                    Swal.fire({
                        title: 'error',
                        icon: 'error',
                        text: data.message,
                    })
                } else {
                    Swal.fire({
                        title: 'Done',
                        icon: 'success',
                        text: data.message,
                        showCancelButton: false,
                    }).then(function(isTrue) {
                        if (isTrue.value) {
                            location.reload();
                        }
                    })
                }
            }
        })
    }
</script>
@endsection