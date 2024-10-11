<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function index(){
        $purchases = PurchaseOrder::all();

        return view('purchase.index', compact('purchases'));
    }

    public function add(){
        $satuans = Satuan::all();
        $products = Product::all();
        $clients = Client::all();
        return view('purchase.add', compact('clients', 'satuans', 'products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|string',
            'client' => 'required|string', // Pastikan client adalah ID yang valid
            'quotation' => 'nullable|string', // Pastikan quotation adalah ID yang valid jika ada
            'po_number' => 'required|string',
            'po_file' => 'required|file|mimes:pdf,docx,doc,ppt|max:2048', // Validasi file hanya untuk tipe tertentu
            'description' => 'required|string',
            'products' => 'required|json',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);

            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText], 400);
            }

            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessageText);
        }

        // Decode products dari JSON menjadi array
        $products = json_decode($request->products, true);

        // Jika decoding gagal, kembalikan pesan error
        if ($products === null) {
            $errorMessage = 'Invalid products data format.';
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 400);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Generate nomor surat
        $no_surat = PurchaseOrder::generateNomorSurat();

        try {
            // Menyimpan file PO jika ada
            $filePath = '';
            if ($request->hasFile('po_file')) {
                $filePath = $request->file('po_file')->store('request-orders', 'public');
            }

            // Simpan purchase baru ke database
            $purchase = PurchaseOrder::create([
                'no' => $no_surat,
                'date' => $request->date,
                'client_id' => $request->client,
                'quotation_id' => $request->quotation ?? null,
                'po_number' => $request->po_number,
                'po_file' => $filePath,
                'description' => $request->description,
                'products' => json_encode($products),
                'status' => '0', // Status : 0 -> waiting, 1 -> delivered, 2 -> waiting delivery, 3 -> finished
            ]);

            // Simpan setiap produk yang terkait dengan purchase order
            foreach ($products as $product) {
                PurchaseOrderProduct::create([
                    'purchase_order_id' => $purchase->id,
                    'product_id' => $product['id'], // Pastikan key yang tepat diambil
                    'packaging_id' => $product['packaging_id'],
                    'qty' => $product['qty'],
                    'price' => $product['price_sale'],
                    'description' => $product['description'],
                ]);
            }

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Request Order / Purchase from Client created successfully.', 
                    'redirect_url' => route('purchase.show', ['id' => $purchase->id])
                ]);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('purchase.index')
                ->with('success', 'Request Order / Purchase from Client created successfully.');
        } catch (\Exception $e) {
            // Penanganan error
            $errorMessage = 'Gagal membuat Request Order / Purchase from Client, error: ' . $e->getMessage();

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 500);
            }

            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function show($id){
        return view('purchase.show');
    }
    
    public function edit($id){
        $purchase = PurchaseOrder::findOrFail($id);
        return view('purchase.edit', compact('clients', 'satuans', 'products', 'purchase'));
    }

    public function update($id, Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|string',
            'client' => 'required',
            'for' => 'required|string',
            'message' => 'required|string',
            'keterangan' => 'required|string',
            'products' => 'required|json', // Validasi bahwa ini adalah JSON string
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
            
            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        // Decode products dari JSON menjadi array
        $products = json_decode($request->products, true);

        // Jika decoding gagal, kembalikan pesan error
        if ($products === null) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Invalid products data format.']);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid products data format.');
        }

        try {
            $purchase = PurchaseOrder::find($id);
            // Simpan purchase baru
            $purchase->update([
                'date' => $request->date,
                'client_id' => $request->client,
                'for' => $request->for,
                'message' => $request->message,
                'keterangan' => $request->keterangan,
                'products' => json_encode($products), // Simpan sebagai JSON ke database
                'status' => '0', // 0 -> offering, 1 -> purchased, 2 -> closed
            ]);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'purchase updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('purchase.index')
                ->with('success', 'purchase updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal update purchase, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal update purchase, error: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            PurchaseOrder::destroy($id);
            return redirect()->route('purchase.index')
                ->with('success', 'purchase deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus purchase, error: ' . $e->getMessage());
        }
    }
}
