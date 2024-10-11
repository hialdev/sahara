<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Packaging;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AJAXController extends Controller
{
    // ---------------------------------------
    // ------------- Product -----------------
    // ---------------------------------------
    public function getProducts(){
        $products = Product::all();
        return response()->json($products);
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);
        $response = (object)[
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'id_satuan_barang' => $product->id_satuan_barang,
            'satuan' => $product->satuan->name,
        ];
        return response()->json($response);
    }

    public function getPackagingBySatuan($satuan_id)
    {
        $packagings = Packaging::where('id_satuan_barang', $satuan_id)->get();
        return response()->json($packagings);
    }

    public function storeProduct(Request $request)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'satuan' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Mengambil semua pesan kesalahan menjadi array
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat product baru
            Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'id_satuan_barang' => $request->satuan,
            ]);

            // Berhasil membuat product
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully.'
            ], 200);
            
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan data
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat product.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    // ---------------------------------------
    // ------------- Satuan -----------------
    // ---------------------------------------
    public function getSatuans(){
        $satuans = Satuan::all();
        return response()->json($satuans);
    }
    
    // ---------------------------------------
    // ------------- Satuan -----------------
    // ---------------------------------------
    public function getPackagings(){
        $packagings = Packaging::all();
        return response()->json($packagings);
    }

    // ---------------------------------------
    // ------------- Client -----------------
    // ---------------------------------------
    public function getClients(){
        $clients = Client::all();
        return response()->json($clients);
    }

    public function getClientDetails($id)
    {
        $client = Client::findOrFail($id);
        $address = ClientAddress::where('client_id', $client->id)->where('address_tag', 'office')->first();
        $response = (object) [
            "name" => $client->name,
            "npwp" => $client->npwp,
            "email" => $client->email,
            "contact_name" => $client->contact_name,
            "contact_email" => $client->contact_email,
            "contact_phone" => $client->contact_phone,
            "address" => [
                "address" => $address->address,
                "city" => $address->city,
                "postal_code" => $address->postal_code,
            ],
        ];
        return response()->json($response);
    }

    // ---------------------------------------
    // ------------- Product -----------------
    // ---------------------------------------
    public function getQuotations(){
        $quotations = Quotation::all();
        return response()->json($quotations);
    }
    public function getQuotationDetails($id){
        $quotation = Quotation::findOrFail($id);
        return response()->json($quotation);
    }
    public function getQuotationClient($client_id){
        $quotation = Quotation::where('client_id', $client_id)->get();
        return response()->json($quotation);
    }
}
