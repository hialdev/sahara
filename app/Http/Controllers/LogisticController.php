<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\LogisticAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LogisticController extends Controller
{
    public function index(){
        $logistics = Logistic::all();

        return view('crud.logistic.index', compact('logistics'));
    }

    public function add(){
        return view('crud.logistic.add');
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
        //     $imagePath = $request->file('image')->store('Logistics', 'public');
        // }

        try {
            // Create new logistic
            $logistic = Logistic::create([
                'name' => $request->name,
                'email' => $request->email,
                'description' => $request->description,
                'contact_name' => $request->contact_name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
            ]);
            
            if($logistic){
                LogisticAddress::create([
                    'logistic_id' => $logistic->id,
                    'address_tag' => 'office',
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }

            return redirect()->route('logistic.index')
                ->with('success', 'Logistic created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat logistic, error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $logistic = Logistic::findOrFail($id);
        return view('crud.logistic.edit', compact('logistic'));
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

        $logistic = Logistic::findOrFail($id);

        try {
            // Create new logistic
            $logistic->update([
                'name' => $request->name ?? $logistic->name,
                'email' => $request->email ?? $logistic->email,
                'description' => $request->description ?? $logistic->description,
                'contact_name' => $request->contact_name ?? $logistic->contact_name,
                'contact_email' => $request->contact_email ?? $logistic->contact_email,
                'contact_phone' => $request->contact_phone ?? $logistic->contact_phone,
            ]);
                
            return redirect()->route('logistic.index')
                ->with('success', 'Logistic updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui logistic, error: ' . $e->getMessage());
        }
    }

    public function setting($id){
        $logistic = Logistic::findOrFail($id);
        return view('crud.logistic.setting', compact('logistic'));
    }

    public function destroy($id){
        try {
            Logistic::destroy($id);
            return redirect()->route('logistic.index')
                ->with('success', 'Logistic deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus logistic, error: ' . $e->getMessage());
        }
    }

    public function addressManage($logistic_id, Request $request){
        $validator = Validator::make($request->all(), [
            'purpose' => 'required|string|in:edit,add',
            'address_tag' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Cek unik di database osano
                    $existsInOsano = DB::connection('osano')->table('logistic_address')
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
            // Create new logistic
            if($request->get('purpose') == 'edit'){
                $address = LogisticAddress::findOrFail($request->id);
                $address->update([
                    'logistic_id' => $logistic_id,
                    'address_tag' => $request->address_tag,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }elseif ($request->get('purpose') == 'add') {
                LogisticAddress::create([
                    'logistic_id' => $logistic_id,
                    'address_tag' => $request->address_tag,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'telp' => $request->telp,
                    'fax' => $request->fax,
                ]);
            }
                
            return redirect()->route('logistic.index')
                ->with('success', 'Logistic updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui logistic, error: ' . $e->getMessage());
        }
    }

    public function addressDestroy($logistic_id, $id){
        try {
            LogisticAddress::destroy($id);
            return redirect()->route('logistic.index')
                ->with('success', 'Logistic Address untuk logistic id '.$logistic_id.' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus alamat logistic, error: ' . $e->getMessage());
        }
    }
}
