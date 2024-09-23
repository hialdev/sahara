<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index(){
        $datas = DB::table('applications')->get();
        $columns = [
            [
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'name' => 'description',
                'type' => 'text',
            ],
            [
                'name' => 'url',
                'type' => 'text',
            ],
            [
                'name' => 'image',
                'type' => 'image',
            ],
            [
                'name' => 'icon',
                'type' => 'icon',
            ],
            [
                'name' => 'use_icon',
                'type' => 'toggle',
            ],
            [
                'name' => 'created_at',
                'type' => 'text',
            ]
        ];
        return view('crud.application.index', compact('datas', 'columns'));
    }

    public function add(){
        return view('crud.application.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon' => 'required|string|max:255',
            'use_icon' => 'nullable',
            'description' => 'nullable|string',
            'url' => 'required|url',
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

        $imagePath = '';
        // Simpan image ke storage
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('applications', 'public');
        }

        try {
            // Simpan data aplikasi ke database
            Application::create([
                'title' => $request->title,
                'image' => $imagePath ?? '',
                'icon' => $request->icon,
                'use_icon' => $request->use_icon ? 1 : 0,
                'description' => $request->description ?? '',
                'url' => $request->url,
            ]);
        
            // Cek apakah penyimpanan berhasil
            return redirect()->route('application.index')
                ->with('success', 'Aplikasi berhasil disimpan.');
        
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        }

    }

    public function edit($id){
        $application = Application::find($id);

        return view('crud.application.edit', compact('application'));
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon' => 'required|string|max:255',
            'use_icon' => 'nullable',
            'description' => 'nullable|string',
            'url' => 'required|url',
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
            $application = Application::findOrFail($id);
        
            // Simpan data selain image terlebih dahulu
            $application->update([
                'title' => $request->title,
                'icon' => $request->icon,
                'use_icon' => $request->use_icon ? 1 : 0,
                'description' => $request->description ?? $application->description,
                'url' => $request->url,
            ]);
        
            // Jika ada image baru, proses penyimpanan image
            if ($request->hasFile('image')) {
                // Hapus image lama dari storage
                if ($application->image) {
                    Storage::disk('public')->delete($application->image);
                }
        
                // Simpan image baru ke storage
                $imagePath = $request->file('image')->store('applications', 'public');
        
                // Update kolom image pada database
                $application->update(['image' => $imagePath]);
            }
        
            return redirect()->route('application.index')
                ->with('success', 'Aplikasi berhasil diperbarui.');
        
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan perubahan application ('.$id.'), error: ' . $e->getMessage());
        }
        
    }

    public function destroy($id){
        try {
            // Temukan aplikasi berdasarkan ID
            $application = Application::findOrFail($id);
    
            // Hapus image dari storage jika ada
            if ($application->image) {
                Storage::disk('public')->delete($application->image);
            }
    
            // Hapus aplikasi dari database
            $application->delete();
    
            return redirect()->route('application.index')
                ->with('success', 'Aplikasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus aplikasi ('.$id.'), error: ' . $e->getMessage());
        }
    }
}
