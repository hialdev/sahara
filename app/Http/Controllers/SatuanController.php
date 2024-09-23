<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index(){
        $datas = Satuan::all();
        $columns = [
            [
                'name' => 'name',
                'type' => 'text',
            ],
            [
                'name' => 'created_at',
                'type' => 'text',
            ]
        ];
        return view('crud.satuan.index', compact('datas', 'columns'));
    }

    public function add(){
        return view('crud.satuan.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
            // Create new satuan product
            Satuan::create([
                'name' => $request->name,
            ]);
                
            return redirect()->route('satuan.index')
                ->with('success', 'satuan product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat satuan product, error: ' . $e->getMessage());
        }
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
            // Update Satuan 
            $satuan = Satuan::findOrFail($id);
            $satuan->update([
                'name' => $request->name ?? $satuan->name,
            ]);
                
            return redirect()->route('satuan.index')
                ->with('success', 'satuan product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui satuan product, error: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            Satuan::destroy($id);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus satuan product, error: ' . $e->getMessage());
        }
        return redirect()->route('satuan.index')
                ->with('success', 'Satuan product berhasil dihapus.');
    }
}
