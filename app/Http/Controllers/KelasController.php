<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Kelas';
        $data = Kelas::with(['jurusan', 'guru'])->get();
        return view('kelas.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create';
        $jurusan = Jurusan::all();
        $guru = Guru::select('guru.id', 'guru.nama_guru')
            ->join('users', 'users.guru_id', 'guru.id')
            ->where('guru.status_wali_kelas', 0)
            ->where('users.is_admin', 0)
            ->get();
        return view('kelas.create', compact('title', 'jurusan', 'guru'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_kelas' => 'required|max:255',
            'jurusan_id' => 'required',
            'guru_id'    => 'required'
        ];


        $cek_data = Kelas::where('jurusan_id', $request->jurusan_id)->get();
        if (count($cek_data) > 0) {
            foreach ($cek_data as $row) {
                if ($request->jurusan_id == $row->jurusan_id && strtoupper($request->nama_kelas) == $row->nama_kelas) {
                    $hitung_kelas = count([
                        strtoupper($request->nama_kelas) == $row->nama_kelas
                    ]);

                    $hitung_kelas += $hitung_kelas;
                    if ($hitung_kelas > 0) {
                        $rules['nama_kelas'] = 'required|unique:kelas|max:255';
                    }
                }
            }
        }

        $validate = $request->validate($rules);
        $validate['nama_kelas'] = strtoupper($request->nama_kelas);
        Kelas::create($validate);

        $get_kelas = Kelas::orderBy('id', 'desc')->first();
        Guru::where('id', $get_kelas->guru_id)
            ->update([
                'status_wali_kelas' => 1
            ]);

        return redirect('kelas')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == null) {
            return redirect('kelas')->with('error', 'Data tidak ada!');
        }

        $kelas = Kelas::find($id);
        if ($kelas == null) {
            return redirect('kelas')->with('error', 'Data tidak ada!');
        }

        $title = 'edit';
        $jurusan = Jurusan::find($kelas->jurusan_id);
        $guru = Guru::select('guru.id', 'guru.nama_guru')
            ->join('users', 'users.guru_id', 'guru.id')
            ->where('users.is_admin', 0)
            ->where('guru.status_wali_kelas', 0)
            ->get();
        return view('kelas.edit', compact('title', 'kelas', 'jurusan', 'guru'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == null) {
            return redirect('kelas')->with('error', 'Data gagal diupdate!');
        }

        $kelas = Kelas::find($id);
        $hapus_status = Guru::where('id', $kelas->guru_id)->first();
        if ($kelas == null) {
            return redirect('kelas')->with('error', 'Data gagal diupdate!');
        }

        if ($request->guru_id) {
            $kelas->guru_id = $request->guru_id;
            $hapus_status->status_wali_kelas = 0;
            $kelas->save();
            $hapus_status->save();

            // for new teacher
            $set_status = Guru::where('id', $kelas->guru_id)->first();
            $set_status->status_wali_kelas = 1;
            $set_status->save();
        }

        return redirect('kelas')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Data gagal dihapus!'
            ]);
        }

        $kelas = Kelas::find($id);
        if ($kelas == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Data gagal dihapus!'
            ]);
        }

        $guru = Guru::where('id', $kelas->guru_id)->first();
        $guru->status_wali_kelas = 0;
        $guru->save();

        $kelas->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
