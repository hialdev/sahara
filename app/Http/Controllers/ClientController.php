<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();

        return view('crud.client.index', compact('clients'));
    }

    public function add(){
        return view('crud.client.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'npwp' => 'required|numeric',
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

        // // Handle file upload
        // $imagePath = '';
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('clients', 'public');
        // }
        try {
            // Create new client
            $client = Client::create([
                'name' => $request->name,
                'npwp' => $request->npwp,
                'email' => $request->email,
                'description' => $request->description,
                'contact_name' => $request->contact_name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
            ]);
            
            if($client){
                ClientAddress::create([
                    'client_id' => $client->id,
                    'address_tag' => 'office',
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }

            return redirect()->route('client.index')
                ->with('success', 'client created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat client, error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $client = Client::findOrFail($id);
        return view('crud.client.edit', compact('client'));
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'npwp' => 'required|numeric',
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

        $client = Client::findOrFail($id);

        try {
            // Create new client
            $client->update([
                'name' => $request->name ?? $client->name,
                'npwp' => $request->npwp ?? $client->npwp,
                'email' => $request->email ?? $client->email,
                'description' => $request->description ?? $client->description,
                'contact_name' => $request->contact_name ?? $client->contact_name,
                'contact_email' => $request->contact_email ?? $client->contact_email,
                'contact_phone' => $request->contact_phone ?? $client->contact_phone,
            ]);
                
            return redirect()->route('client.index')
                ->with('success', 'client updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui client, error: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            Client::destroy($id);
            return redirect()->route('client.index')
                ->with('success', 'client deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus client, error: ' . $e->getMessage());
        }
    }

    public function addressManage($client_id, Request $request){
        $validator = Validator::make($request->all(), [
            'purpose' => 'required|string|in:edit,add',
            'address_tag' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Cek unik di database osano
                    $existsInOsano = DB::connection('osano')->table('client_address')
                                        ->where('address_tag', $value)
                                        ->exists();
                    if ($existsInOsano) {
                        $fail('Ooopss... Address Tag / Penanda alamat telah digunakan dan bersifat uniq.');
                    }
                }
            ],
            'id' => 'nullable',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'fax' => 'nullable|numeric',
            'telp' => 'nullable|numeric',
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
            // Create new client
            if($request->get('purpose') == 'edit'){
                $address = ClientAddress::findOrFail($request->id);
                $address->update([
                    'client_id' => $client_id,
                    'address_tag' => $request->address_tag,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }elseif ($request->get('purpose') == 'add') {
                ClientAddress::create([
                    'client_id' => $client_id,
                    'address_tag' => $request->address_tag,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }
                
            return redirect()->route('client.index')
                ->with('success', 'client updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui client, error: ' . $e->getMessage());
        }
    }

    public function addressDestroy($client_id, $id){
        try {
            ClientAddress::destroy($id);
            return redirect()->route('client.index')
                ->with('success', 'client Address untuk client id '.$client_id.' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus alamat client, error: ' . $e->getMessage());
        }
    }
}
