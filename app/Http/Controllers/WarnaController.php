<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warna;

class WarnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Warna::all();
        return view('data-warna', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createWarna()
    {
        return view('add-warna');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWarna(Request $request)
    {
        $request->validate([
            'warna' => 'required',
        ]);

        Warna::create([
            'warna' => $request['warna'],
        ]);

        return redirect('data-warna');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editWarna($id)
    {
        $warna = Warna::findorFail($id);
        return view('edit-warna', compact('warna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateWarna(Request $request, $id)
    {
        $request->validate([
            'warna' => 'required',
        ]);

        $warna = Warna::find($id);

        $warna = $warna->update([
            'warna' => $request['warna'],
        ]);

        return redirect('data-warna');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyWarna($id)
    {
        $warna = Warna::findOrFail($id);
        $warna->delete();
        return redirect('data-warna');
    }
}
