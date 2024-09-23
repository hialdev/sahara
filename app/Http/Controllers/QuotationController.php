<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Satuan;
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

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'fax' => 'nullable|numeric',
            'telp' => 'nullable|numeric',
            'contact_name' => 'required',
            'contact_email' => 'required',
            'contact_phone' => 'required',
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

        // Handle file upload
        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('quotations', 'public');
        }

        try {
            // Create new quotation
            $quotation = Quotation::create([
                'name' => $request->name,
                'email' => $request->email,
                'description' => $request->description,
                'contact_name' => $request->contact_name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
            ]);
            

            return redirect()->route('quotation.index')
                ->with('success', 'quotation created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat quotation, error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $quotation = Quotation::findOrFail($id);
        return view('quotation.edit', compact('quotation'));
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'contact_name' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|numeric',
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

        $quotation = Quotation::findOrFail($id);

        try {
            // Create new quotation
            $quotation->update([
                'name' => $request->name ?? $quotation->name,
                'email' => $request->email ?? $quotation->email,
                'description' => $request->description ?? $quotation->description,
                'contact_name' => $request->contact_name ?? $quotation->contact_name,
                'contact_email' => $request->contact_email ?? $quotation->contact_email,
                'contact_phone' => $request->contact_phone ?? $quotation->contact_phone,
            ]);
                
            return redirect()->route('quotation.index')
                ->with('success', 'quotation updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui quotation, error: ' . $e->getMessage());
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
}
