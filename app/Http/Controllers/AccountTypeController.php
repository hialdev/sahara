<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountTypeController extends Controller
{
    public function index(){
        $types = AccountType::orderBy('code', 'asc')->get();
        return view('accounting.account_type.index', compact('types'));
    }

    public function show($id, Request $request){
        if ($request->ajax()) {
            try{
                $type = AccountType::findOrFail($id);
                return response()->json(['success' => true, 'data' => $type]);
            }catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => 'Gagal mendapatkan Data, error: ' . $e->getMessage()]);
            }
        }
        return redirect()->back();
        
    }

    public function setting($id){
        $actype = AccountType::findOrFail($id);
        return view('accounting.account_type.setting', compact('actype'));
    }

    public function store (Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:osano.account_types,code|numeric',
            'name' => 'required|string',
            'type' => 'required|string'
        ]);

        if($validator->fails()){
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
        }

        try{
            $actype = new AccountType();
            $actype->code = $request->get('code');
            $actype->name = $request->get('name');
            $actype->type = $request->get('type');
            $actype->save();

            return redirect()->route('account_type.index')->with('success', 'Berhasil membuat data Account Type '.$actype->name);
        }catch(\Exception $e){
            return redirect()->route('account_type.index')->with('error', 'Ooopss, Gagal membuat data Account. Error: '.$e->getMessage());
        }
    }

    public function update (Request $request, $id){
        $validator = Validator::make($request->all(), [
            'code' => 'nullable|unique:osano.account_types,code|numeric',
            'name' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        if($validator->fails()){
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
        }

        try{
            $actype = AccountType::findOrFail($id);
            if($actype->is_urgent == 1){
                return redirect()->route('account_type.setting', $id)->with('error', 'Data ini tidak bisa dihapus atau dirubah, karena digunakan untuk kebutuhan logika aplikasi');
            }
            $actype->code = $request->get('code') ?? $actype->code;
            $actype->name = $request->get('name') ?? $actype->name;
            $actype->type = $request->get('type') ?? $actype->type;
            $actype->save();

            return redirect()->route('account_type.index')->with('success', 'Berhasil membuat data Account Type '.$actype->name);
        }catch(\Exception $e){
            return redirect()->route('account_type.index')->with('error', 'Ooopss, Gagal membuat data Account. Error: '.$e->getMessage());
        }
    }

    public function destroy ($id){
        try{
            $actype = AccountType::findOrFail($id);
            if($actype->is_urgent == 1){
                return redirect()->route('account_type.setting', $id)->with('error', 'Data ini tidak bisa dihapus atau dirubah, karena digunakan untuk kebutuhan logika aplikasi');
            }
            $actype->delete();

            return redirect()->route('account_type.index')->with('success', 'Berhasil menghapus data Account Type '.$actype->name);
        }catch(\Exception $e){
            return redirect()->route('account_type.index')->with('error', 'Ooopss, Gagal menghapus data Account. Error: '.$e->getMessage());
        }
    }
}
