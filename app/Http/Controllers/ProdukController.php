<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Jenis;
use App\Models\Detail;
use App\Models\Warna;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Res
     * 
     *ponse
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $datas = Produk::with(['jenis', 'detail'])->get();
        // dd($datas);
        return view('data', compact('datas'));
    }
    public function create()
    {
        $dataJenis = Jenis::all();
        $dataProduk = Produk::all();
        $dataWarna = Warna::all();
        $dataDetail = Detail::all();
        return view('add', compact('dataJenis', 'dataProduk', 'dataWarna', 'dataDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validProduk = $request->validate([
            'nama' => 'required|string',
            'jenis_id' => 'required',
            'hpp' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);
        
        $validDetail = $request->validate([
            'warna_id' => 'required',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            'spesifikasi' => 'required',
            'foto_produk' => 'required',
            'foto_produk.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imageName = time() . '.' . $request->foto_produk->extension();
        $request->foto_produk->move(public_path() . '/image/foto_produk/', $imageName);

        $product = Produk::create($validProduk);
        Detail::create([
            'produk_id' => $product->id,
            'nama' => $request['nama'],
            'jenis_id' => $request['jenis_id'],
            'warna_id' => $request['warna_id'],
            'stok' => $request['stok'],
            'deskripsi' => $request['deskripsi'],
            'spesifikasi' => $request['spesifikasi'],
            'hpp' => $request['hpp'],
            'harga_jual' => $request['harga_jual'], 
            'foto_produk' => $imageName,
            
        ]);

        return redirect('data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::findorFail($id);
        $produks = Produk::all();
        return view('detail', ["produk" => $produk, 'produks' => $produks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataJenis = Jenis::all();
        $dataProduk = Produk::findorFail($id);
        $dataWarna = Warna::all();
        $dataDetail = Detail::findorFail($id);

        return view('edit', compact('dataJenis', 'dataProduk', 'dataWarna', 'dataDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validProduk = $request->validate([
            'nama' => 'required|string',
            'jenis_id' => 'required',
            'hpp' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);
        
        $request->validate([
            'warna_id' => 'required',
            'stok' => 'required|numeric',
            // 'foto_produk' => 'required',
            // 'foto_produk.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produk = Produk::find($id);
        $produkDet = Detail::find($id);


        // if($request->foto_produk){
        //     $imageName = time() . '.' . $request->foto_produk->extension();
        //     $request->foto_produk->move(public_path() . '/image/foto_produk/', $imageName);
        //     $dataUpdate['foto_produk'] = $imageName;
        // }

        if ($request->foto_produk){
            $imageName = time() . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path() . '/image/foto_produk/', $imageName);
        } else {
            $imageName = $produkDet->foto_produk;
        }

        $produk = $produk->update($validProduk);
        $produkDet = $produkDet->update([
            // 'produk_id' => $produk->id,
            'detail' => $produkDet->id,
            'nama' => $request['nama'],
            'jenis_id' => $request['jenis_id'],
            'warna_id' => $request['warna_id'],
            'stok' => $request['stok'],
            'hpp' => $request['hpp'],
            'harga_jual' => $request['harga_jual'], 
            'foto_produk' => $imageName,
        ]);

        return redirect('data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return redirect('data');
    }
}
