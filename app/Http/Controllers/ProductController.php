<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $datas = Product::all();
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
                'name' => 'satuan',
                'type' => 'relation',
                'rlt_type' => 'single',
                'rlt_name' => 'satuan',
                'rlt_index' => null,
                'rlt_key' => 'name',
            ],
            [
                'name' => 'created_at',
                'type' => 'text',
            ],
        ];

        return view('crud.product.index', compact('datas', 'columns'));
    }

    public function add(){
        return view('crud.product.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string',
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

        // // Handle file upload
        // $imagePath = '';
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('products', 'public');
        // }

        try {
            // Create new product
            Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'id_satuan_barang' => $request->satuan,
            ]);
                
            return redirect()->route('product.index')
                ->with('success', 'product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat product, error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        return view('crud.product.edit');
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string',
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

        $product = Product::findOrFail($id);

        try {
            // Create new product
            $product->update([
                'title' => $request->title ?? $product->title,
                'description' => $request->description ?? $product->description,
                'id_satuan_barang' => $request->satuan ?? $product->id_satuan_barang,
            ]);
                
            return redirect()->route('product.index')
                ->with('success', 'product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui product, error: ' . $e->getMessage());
        }
    }

    public function setting($id) {
        $product = Product::findOrFail($id);

        return view('crud.product.setting', compact('product'));
    }

    public function destroy($id){
        try {
            Product::destroy($id);
            return redirect()->route('product.index')
                ->with('success', 'product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus product, error: ' . $e->getMessage());
        }
    }
}
