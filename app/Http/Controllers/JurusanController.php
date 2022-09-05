<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Mockery\Undefined;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Jurusan';
        $data = Jurusan::all();
        return view('jurusan.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create';
        return view('jurusan.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:jurusan|max:255'
        ]);

        Jurusan::create($request->all());
        return redirect('jurusan')->with('success', 'Data jurusan berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function show(Jurusan $jurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'edit';
        $jurusan = Jurusan::find($id);
        if ($jurusan == null) {
            return redirect('jurusan')->with('error', 'Data tidak ada!');
        }
        return view('jurusan.edit', compact('jurusan', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == null) {
            return redirect('jurusan')->with('error', 'Data gagal diupdate!');
        }

        $old_data = Jurusan::find($id);
        if ($old_data == null) {
            return redirect('jurusan')->with('error', 'Data gagal diupdate!');
        }

        $rule = [
            'nama_jurusan' => 'required|max:255'
        ];

        if ($request->nama_jurusan != $old_data->nama_jurusan) {
            $rule['nama_jurusan'] = 'required|unique:jurusan|max:255';
        }

        $validate = $request->validate($rule);

        // $old_data->nama_jurusan = $request->nama_jurusan;
        // $old_data->save();
        Jurusan::where('id', $id)
            ->update($validate);
        return redirect('jurusan')->with('success', 'Data jurusan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurusan  $jurusan
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

        $jurusan = Jurusan::find($id);
        if ($jurusan == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Data gagal dihapus!'
            ]);
        }

        $jurusan->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
