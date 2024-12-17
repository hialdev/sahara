<?php

namespace App\Http\Controllers;

use App\Models\Principle;
use App\Models\PrincipleAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrincipleController extends Controller
{
    public function index(){
        $principles = Principle::all();

        return view('crud.principle.index', compact('principles'));
    }

    public function add(){
        return view('crud.principle.add');
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

        // // Handle file upload
        // $imagePath = '';
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('principles', 'public');
        // }

        try {
            // Create new principle
            $principle = Principle::create([
                'name' => $request->name,
                'email' => $request->email,
                'description' => $request->description,
                'contact_name' => $request->contact_name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
            ]);
            
            if($principle){
                PrincipleAddress::create([
                    'principle_id' => $principle->id,
                    'address_tag' => 'office',
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }

            return redirect()->route('principle.index')
                ->with('success', 'principle created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat principle, error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $principle = Principle::findOrFail($id);
        return view('crud.principle.edit', compact('principle'));
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

        $principle = Principle::findOrFail($id);

        try {
            // Create new principle
            $principle->update([
                'name' => $request->name ?? $principle->name,
                'email' => $request->email ?? $principle->email,
                'description' => $request->description ?? $principle->description,
                'contact_name' => $request->contact_name ?? $principle->contact_name,
                'contact_email' => $request->contact_email ?? $principle->contact_email,
                'contact_phone' => $request->contact_phone ?? $principle->contact_phone,
            ]);
                
            return redirect()->route('principle.index')
                ->with('success', 'principle updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui principle, error: ' . $e->getMessage());
        }
    }

    public function setting($id) {
        $principle = Principle::findOrFail($id);
        
        return view('crud.principle.setting', compact('principle'));
    }

    public function destroy($id){
        try {
            Principle::destroy($id);
            return redirect()->route('principle.index')
                ->with('success', 'principle deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus principle, error: ' . $e->getMessage());
        }
    }

    public function addressManage($principle_id, Request $request){
        $validator = Validator::make($request->all(), [
            'purpose' => 'required|string|in:edit,add',
            'address_tag' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Cek unik di database osano
                    $existsInOsano = DB::connection('osano')->table('principle_address')
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
            // Create new principle
            if($request->get('purpose') == 'edit'){
                $address = PrincipleAddress::findOrFail($request->id);
                $address->update([
                    'principle_id' => $principle_id,
                    'address_tag' => $request->address_tag,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }elseif ($request->get('purpose') == 'add') {
                PrincipleAddress::create([
                    'principle_id' => $principle_id,
                    'address_tag' => $request->address_tag,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }
                
            return redirect()->route('principle.index')
                ->with('success', 'principle updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui principle, error: ' . $e->getMessage());
        }
    }

    public function addressDestroy($principle_id, $id){
        try {
            PrincipleAddress::destroy($id);
            return redirect()->route('principle.index')
                ->with('success', 'Principle Address untuk principle id '.$principle_id.' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus alamat principle, error: ' . $e->getMessage());
        }
    }
}
