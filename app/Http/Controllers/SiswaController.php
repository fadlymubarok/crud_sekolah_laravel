<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Mockery\Undefined;

class SiswaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'siswa';
        $data = User::select('siswa.id', 'siswa.nama_siswa', 'kelas.nama_kelas', 'jurusan.nama_jurusan', 'guru.nama_guru')
            ->join('kelas', 'kelas.guru_id', 'users.guru_id')
            ->join('jurusan', 'kelas.jurusan_id', 'jurusan.id')
            ->join('siswa', 'siswa.kelas_id', 'kelas.id')
            ->join('guru', 'kelas.guru_id', 'guru.id')
            ->where('users.id', auth()->user()->id)->get();
        return view('siswa.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create';
        return view('siswa.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_siswa' => 'required|max:255',
            'tgl_lahir_siswa' => 'required',
            'alamat_siswa' => 'required'
        ]);

        // lanjut
        $kelas = User::select('kelas.nama_kelas', 'kelas.id')
            ->join('kelas', 'kelas.guru_id', 'users.guru_id')
            ->where('users.id', auth()->user()->id)->first();
        $validate['kelas_id'] = $kelas->id;
        Siswa::create($validate);

        return redirect('siswa')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == null) {
            return redirect('siswa')->with('error', 'Data tidak ada');
        }

        $siswa = Siswa::find($id);
        if ($siswa == null || $siswa->count() <= 0) {
            return redirect('siswa')->with('error', 'Data tidak ada');
        }

        $title = 'edit';
        return view('siswa.edit', compact('siswa', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == null) {
            return redirect('siswa')->with('error', 'Data tidak ada');
        }

        $validate = $request->validate([
            'nama_siswa' => 'required|max:255',
            'tgl_lahir_siswa' => 'required',
            'alamat_siswa' => 'required'
        ]);


        $siswa = Siswa::find($id);
        if ($siswa == null || $siswa->count() <= 0) {
            return redirect('siswa')->with('error', 'Data tidak ada');
        }

        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->tgl_lahir_siswa = $request->tgl_lahir_siswa;
        $siswa->alamat_siswa = $request->alamat_siswa;
        $siswa->save();

        return redirect('siswa')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak ada'
            ]);
        }

        $siswa = Siswa::find($id);
        if ($siswa == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak ada'
            ]);
        }

        $siswa->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
