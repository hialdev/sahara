<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Satuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    public function index(){
        $quotations = Quotation::all();

        return view('quotation.index', compact('quotations'));
    }

    public function add(){
        $satuans = Satuan::all();
        $products = Product::all();
        $clients = Client::all();
        return view('quotation.add', compact('clients', 'satuans', 'products'));
    }

    public function store(Request $request)
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

        // Generate nomor surat
        $no_surat = Quotation::generateNomorSurat();
        
        try {
            // Simpan quotation baru
            $quotation = Quotation::create([
                'no' => $no_surat,
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
                return response()->json(['success' => true, 'message' => 'Quotation created successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('quotation.index')
                ->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal membuat quotation, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat quotation, error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $quotation = Quotation::findOrFail($id);
        $satuans = Satuan::all();
        $products = Product::all();
        $clients = Client::all();
        return view('quotation.edit', compact('clients', 'satuans', 'products', 'quotation'));
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
            $quotation = Quotation::find($id);
            // Simpan quotation baru
            $quotation->update([
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
                return response()->json(['success' => true, 'message' => 'Quotation updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('quotation.index')
                ->with('success', 'Quotation updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal update quotation, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal update quotation, error: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            Quotation::destroy($id);
            return redirect()->route('quotation.index')
                ->with('success', 'quotation deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus quotation, error: ' . $e->getMessage());
        }
    }

    public function print($id){
        $quotation = Quotation::findOrFail($id);
        
        return view('quotation.print', compact('quotation'));
    }

    public function download($id){
        $quotation = Quotation::findOrFail($id);
        $pdf = Pdf::setOption(['defaultFont' => 'serif'])->loadView('quotation.pdf', [
            'title' => 'Quotation Sahara No '.$quotation->no,
            'quotation' => $quotation
        ]);
    
        return $pdf->download('quotation-'.$quotation->no.'.pdf');
    }
}
