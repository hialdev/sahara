<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\COA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(){
        $actypes = AccountType::orderBy('code', 'asc')->get();
        $parents = COA::where('is_parent', 1)->orWhere('is_parent', '1')->orderBy('no_code', 'asc')->get();
        return view('accounting.account.index', compact('actypes', 'parents'));
    }

    public function show($id, Request $request){
        if ($request->ajax()) {
            try{
                $coa = COA::where('id',$id)->with('accountType')->firstOrFail();
                return response()->json(['success' => true, 'data' => $coa]);
            }catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => 'Gagal mendapatkan Data, error: ' . $e->getMessage()]);
            }
        }
        return redirect()->back();
    }

    public function setting($id){
        $account = COA::findOrFail($id);
        return view('accounting.account.setting', compact('account'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'account_code' => 'required|string|regex:/^[0-9.]+$/',
            'account_name' => 'required|string',
            'account_type' => 'required|numeric',
            'parent_account' => 'nullable|numeric',
            'is_parent' => 'nullable|boolean',
        ]);
        //dd($request->all());
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        try{

            $nocode = $request->has('is_parent') && $request->has('is_parent') == '1' ? $request->get('account_type').'.'.$request->get('account_code') : $request->get('account_type').'.'.$request->get('parent_account').'.'.$request->get('account_code');
            $actype = AccountType::where('code', $request->get('account_type'))->firstOrFail();

            $coa = new COA();
            $coa->no_code = $nocode;
            $coa->account_code = $request->get('account_code');
            $coa->account_name = $request->get('account_name');
            $coa->account_type = $actype->id;
            $coa->is_parent = $request->get('is_parent') ?? 0;
            $coa->save();
            
            return redirect()->route('account.index')->with('success', 'Berhasil membuat data Account '.$coa->account_name);
        }catch (\Exception $e) {
            return redirect()->route('account.index')->with('error', 'Ooopss, Gagal membuat data Account. Error: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'account_code' => 'required|string|regex:/^[0-9.]+$/',
            'account_name' => 'required|string',
            'account_type' => 'required|numeric',
            'parent_account' => 'nullable|numeric',
            'is_parent' => 'nullable|boolean',
        ]);
        //dd($request->all());
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessageText);
        }

        try{

            $nocode = $request->has('is_parent') && $request->has('is_parent') == '1' ? $request->get('account_type').'.'.$request->get('account_code') : $request->get('account_type').'.'.$request->get('parent_account').'.'.$request->get('account_code');
            $actype = AccountType::where('code', $request->get('account_type'))->firstOrFail();

            $coa = COA::findOrFail($id);
            if($coa->is_urgent == 1){
                return redirect()->route('account.setting', $id)->with('error', 'Data ini tidak bisa dihapus atau dirubah, karena digunakan untuk kebutuhan logika aplikasi');
            }
            $coa->no_code = $nocode;
            $coa->account_code = $request->get('account_code');
            $coa->account_name = $request->get('account_name');
            $coa->account_type = $actype->id;
            $coa->is_parent = $request->get('is_parent') ?? 0;
            $coa->save();
            
            return redirect()->route('account.index')->with('success', 'Berhasil memperbarui data Account '.$coa->account_name);
        }catch (\Exception $e) {
            return redirect()->route('account.index')->with('error', 'Ooopss, Gagal membuat data Account. Error: '.$e->getMessage());
        }
    }

    public function destroy ($id){
        try{
            $coa = COA::findOrFail($id);
            if($coa->is_urgent == 1){
                return redirect()->route('account.setting', $id)->with('error', 'Data ini tidak bisa dihapus atau dirubah, karena digunakan untuk kebutuhan logika aplikasi');
            }
            $coa->delete();

            return redirect()->route('account.index')->with('success', 'Berhasil menghapus data Account '.$coa->account_name);
        }catch(\Exception $e){
            return redirect()->route('account.index')->with('error', 'Ooopss, Gagal menghapus data Account. Error: '.$e->getMessage());
        }
    }
}