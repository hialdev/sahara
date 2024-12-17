<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackagingController extends Controller
{
    public function index(){
        $datas = Packaging::with('satuan')->get();
        return view('crud.packaging.index', compact('datas'));
    }

    public function add(){
        return view('crud.packaging.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|numeric',
            'satuan' => 'required',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
        
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        try {
            // Create new packaging product
            Packaging::create([
                'name' => $request->name,
                'capacity' => $request->capacity,
                'id_satuan_barang' => $request->satuan,
            ]);
                
            return redirect()->route('packaging.index')
                ->with('success', 'packaging product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat packaging product, error: ' . $e->getMessage());
        }
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|numeric',
            'satuan' => 'required',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
        
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        try {
            // Update packaging 
            $packaging = Packaging::findOrFail($id);
            $packaging->update([
                'name' => $request->name ?? $packaging->name,
                'capacity' => $request->capacity ?? $packaging->capacity,
                'id_satuan_barang' => $request->satuan ?? $packaging->id_satuan_barang,
            ]);
                
            return redirect()->route('packaging.index')
                ->with('success', 'packaging product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui packaging product, error: ' . $e->getMessage());
        }
    }

    public function setting($id){
        $packaging = Packaging::findOrFail($id);

        return view('crud.packaging.setting', compact('packaging'));
    }

    public function destroy($id){
        try {
            Packaging::destroy($id);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus packaging product, error: ' . $e->getMessage());
        }
        return redirect()->route('packaging.index')
                ->with('success', 'packaging product berhasil dihapus.');
    }
}
