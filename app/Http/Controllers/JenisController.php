<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenis;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Jenis::all();
        return view('data-jenis', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createJenis()
    {
        return view('add-jenis');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        Jenis::create([
            'nama_jenis' => $request['nama_jenis'],
        ]);

        return redirect('data-jenis');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJenis($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editJenis($id)
    {
        $jenis = Jenis::findorFail($id);
        return view('edit-jenis', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateJenis(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        $jenis = Jenis::find($id);

        $jenis = $jenis->update([
            'nama_jenis' => $request['nama_jenis'],
        ]);

        return redirect('data-jenis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyJenis($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();
        return redirect('data-jenis');
    }
}
