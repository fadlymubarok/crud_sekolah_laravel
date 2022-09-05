<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{

    public function __construct()
    {
        if (Gate::allows('is_admin')) {
            abort(403);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Guru';
        $data = Guru::join('users', 'users.guru_id', '=', 'guru.id')
            ->select('users.username', 'users.is_admin', 'guru.id', 'guru.nama_guru', 'guru.alamat_guru', 'guru.status_aktif')
            ->where('users.is_admin', 0)
            ->get();

        return view('guru.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create';
        return view('guru.create', compact('title'));
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
            'nama_depan' => 'required|max:255',
            'nama_belakang' => 'required|max:255',
            'tanggal_lahir_guru' => 'required',
            'alamat_guru' => 'required|min:5',
        ]);

        $validate['nama_guru'] = $request->nama_depan . " " . $request->nama_belakang;
        $validate['status_aktif'] = 1;

        Guru::create($validate);

        // Make User
        $get_data = Guru::select('guru_id', 'nama_guru', 'username')
            ->join('users', 'users.guru_id', 'guru.id')
            ->where('nama_guru', $validate['nama_guru'])
            ->orderBy('guru.id', 'desc')
            ->get();

        $name = str_replace(' ', '.', strtolower($validate['nama_guru']));

        $get_guru = Guru::orderBy('id', 'desc')->first();
        $guru_id = $get_guru->id;

        if ($get_data->count() > 0) {
            $data_akhir = $get_data->first();
            $get_angka = (int)substr($data_akhir->username, -1, 2);
            if (intval($get_angka) <= 0) {
                $name = str_replace(' ', '.', strtolower($validate['nama_guru'])) . '.1';
            } else {
                $name = str_replace($get_angka, $get_angka + 1, $data_akhir->username);
            }
        }
        $data_user = [
            'username' => $name,
            'password' => Hash::make('12345678'),
            'guru_id'  => $guru_id
        ];

        User::create($data_user);
        return redirect('guru')->with('success', 'Data guru berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == null) return redirect('guru')->with('error', 'Data Tidak ada!');
        $data = Guru::find($id);

        if ($data == null) return redirect('guru')->with('error', 'Data Tidak ada!');

        $title = 'Edit';
        return view('guru.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == null) return redirect('guru')->with('error', 'Data Tidak ada!');
        $old_data = Guru::find($id);

        if ($old_data == null) return redirect('guru')->with('error', 'Data Tidak ada!');

        $old_data->status_aktif = $request->status_aktif;
        $old_data->save();

        return redirect('guru')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $guru
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

        $guru = Guru::find($id);
        if ($guru == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Data gagal dihapus!'
            ]);
        }

        // delete user
        $user = User::where('guru_id', $guru->id)->first();

        $guru->delete();
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
