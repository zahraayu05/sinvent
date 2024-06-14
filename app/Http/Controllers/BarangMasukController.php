<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        return view('view_barangmasuk.index', compact('rsetBarangMasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $abarangmasuk = Barang::all();
        return view('view_barangmasuk.create',compact('abarangmasuk'));
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk' => 'required|date',
            'qty_masuk' => 'required|numeric|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        DB::beginTransaction();
        try {
            
            // Create BarangMasuk entry
            $barangMasuk = BarangMasuk::create([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id123
                ,
            ]);

            // Update Barang stock
            // $barang = Barang::findOrFail($request->barang_id);
            // $barang->stok += $request->qty_masuk;
            // $barang->save();

            DB::commit();

            return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating BarangMasuk entry: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'Terjadi kesalahan saat menyimpan data!']);
        }
    }


    public function show($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        return view('view_barangmasuk.show', compact('barangMasuk'));
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $abarangmasuk = Barang::all();

        return view('view_barangmasuk.edit', compact('barangMasuk', 'abarangmasuk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_masuk'     => 'required',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required|exists:barang,id',
        ]);
        
        
        //create post
        $barangMasuk = BarangMasuk::findOrFail($id);
            $barangMasuk->update([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id,
            ]);

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}