<?php

namespace App\Http\Controllers;

use App\Models\COA;
use App\Models\JurnalEntry;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurnalController extends Controller
{
    public function index(){
        $jurnals = JurnalEntry::orderBy('date', 'desc')->get();
        $accounts = COA::orderBy('no_code')->get();
        return view('accounting.journal.index', compact('jurnals', 'accounts'));
    }

    public function add(){
        $accounts = COA::orderBy('no_code')->get();
        return view('accounting.journal.add', compact('accounts'));
    }

    public function show($id, Request $request){
        if ($request->ajax()) {
            try{
                $jurnal = JurnalEntry::where('id',$id)->with('account')->firstOrFail();
                return response()->json(['success' => true, 'data' => $jurnal]);
            }catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => 'Gagal mendapatkan Data, error: ' . $e->getMessage()]);
            }
        }
        return redirect()->back();
    }

    public function store(Request $request){
        // Fungsi untuk membersihkan format Rp dan pemisah ribuan
        $cleanRupiah = function ($value) {
            return (int) str_replace(['Rp', '.', ',', ' '], '', $value);
        };

        // Bersihkan setiap nilai dalam debit dan credit
        $request->merge([
            'debit' => array_map($cleanRupiah, $request->input('debit', [])),
            'credit' => array_map($cleanRupiah, $request->input('credit', [])),
        ]);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date|string',        
            'description' => 'nullable|string',        
            'account_id.*' => 'required|string|exists:osano.chart_of_accounts,id', 
            'name.*' => 'required|string',       
            'debit.*' => 'nullable|numeric',       
            'credit.*' => 'nullable|numeric'       
        ]);

        //dd($validator->fails(), $validator->errors()->all(), $request->all());

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

            $accountIds = $request->input('account_id', []);
            $names = $request->input('name', []);
            $debits = $request->input('debit', []);
            $credits = $request->input('credit', []);

            for ($i = 0; $i < count($accountIds); $i++) {
                $jurnal = new JurnalEntry();
                $jurnal->date = DateTime::createFromFormat('d M Y', $request->input('date'))
                    ->format('Y-m-d');
                $jurnal->description = $request->input('description');
                $jurnal->chart_of_account_id = $accountIds[$i];
                $jurnal->name = $names[$i] ?? null; 
                $jurnal->debit = $debits[$i] ?? 0; 
                $jurnal->credit = $credits[$i] ?? 0;
                $jurnal->is_generated = 0;
                
                $jurnal->save();
            }
            
            return redirect()->route('jurnal.index')->with('success', 'Berhasil membuat Transaksi Jurnal pada '.$jurnal->date);
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Ooopss, Gagal membuat data Transaksi Jurnal. Error: '.$e->getMessage());
        }
    }

     public function update($id, Request $request){
        // Fungsi untuk membersihkan format Rp dan pemisah ribuan
        $cleanRupiah = function ($value) {
            return (int) str_replace(['Rp', '.', ',', ' '], '', $value);
        };

        // Bersihkan setiap nilai dalam debit dan credit
        $request->merge([
            'debit' => $cleanRupiah($request->get('debit')),
            'credit' => $cleanRupiah($request->get('credit')),
        ]);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date|string',        
            'description' => 'nullable|string',        
            'account_id' => 'required|string|exists:osano.chart_of_accounts,id', 
            'name' => 'required|string',       
            'debit' => 'nullable|numeric',       
            'credit' => 'nullable|numeric'       
        ]);

        //dd($validator->fails(), $validator->errors()->all(), $request->all());

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
            $jurnal = JurnalEntry::findOrFail($id);
            if($jurnal->is_generated == 1){
                return redirect()->route('jurnal.index')->with('error', 'Generated jurnal hanya boleh diubah dan dihapus pada halaman transaksi terkait');
            }

            $jurnal->date = DateTime::createFromFormat('d M Y', $request->input('date'))
                ->format('Y-m-d');
            $jurnal->description = $request->input('description');
            $jurnal->chart_of_account_id = $request->get('account_id');
            $jurnal->name = $request->get('name'); 
            $jurnal->debit = $request->get('debit'); 
            $jurnal->credit = $request->get('credit');
            $jurnal->save();
            
            return redirect()->route('jurnal.index')->with('success', 'Berhasil memperbarui Transaksi Jurnal '.$jurnal->name);
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Ooopss, Gagal memperbarui data Transaksi Jurnal. Error: '.$e->getMessage());
        }
    }

    public function destroy ($id){
        try{
            $jurnal = JurnalEntry::findOrFail($id);
            if($jurnal->is_generated == 1){
                return redirect()->route('jurnal.index')->with('error', 'Generated jurnal hanya boleh diubah dan dihapus pada halaman transaksi terkait');
            }
            $jurnal->delete();

            return redirect()->route('jurnal.index')->with('success', 'Berhasil menghapus data Jurnal '.$jurnal->name);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Ooopss, Gagal menghapus data Jurnal. Error: '.$e->getMessage());
        }
    }

    public function closeYear(Request $request)
    {
        $year = $request->input('year', date('Y'));

        try {
            // Penutupan akun pendapatan
            $pendapatan = JurnalEntry::whereHas('account.accountType', function ($query) {
                $query->where('type', 'revenue');
            })->get();

            foreach ($pendapatan as $entry) {
                JurnalEntry::create([
                    'date' => "$year-12-31",
                    'description' => "Penutupan Pendapatan",
                    'chart_of_account_id' => $entry->chart_of_account_id,
                    'debit' => $entry->credit,
                    'credit' => 0,
                ]);

                JurnalEntry::create([
                    'date' => "$year-12-31",
                    'description' => "Penutupan ke Laba Ditahan",
                    'chart_of_account_id' => 30300, // ID akun Laba Ditahan
                    'debit' => 0,
                    'credit' => $entry->credit,
                ]);
            }

            // Penutupan akun beban
            $beban = JurnalEntry::whereHas('account.accountType', function ($query) {
                $query->where('type', 'expense');
            })->get();

            foreach ($beban as $entry) {
                JurnalEntry::create([
                    'date' => "$year-12-31",
                    'description' => "Penutupan Beban",
                    'chart_of_account_id' => 30300, // ID akun Laba Ditahan
                    'debit' => $entry->debit,
                    'credit' => 0,
                ]);

                JurnalEntry::create([
                    'date' => "$year-12-31",
                    'description' => "Penutupan ke Beban",
                    'chart_of_account_id' => $entry->chart_of_account_id,
                    'debit' => 0,
                    'credit' => $entry->debit,
                ]);
            }

            return redirect()->back()->with('success', 'Penutupan akhir tahun berhasil dilakukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function openYear(Request $request)
    {
        $year = $request->input('year', date('Y') + 1);

        try {
            // Membuka saldo awal untuk akun neraca
            $saldoAkun = JurnalEntry::selectRaw('chart_of_account_id, SUM(debit - credit) as saldo')
                ->groupBy('chart_of_account_id')
                ->havingRaw('saldo <> 0')
                ->get();

            foreach ($saldoAkun as $entry) {
                $saldo = $entry->saldo;
                $debit = $saldo > 0 ? $saldo : 0;
                $credit = $saldo < 0 ? abs($saldo) : 0;

                JurnalEntry::create([
                    'date' => "$year-01-01",
                    'description' => "Saldo Awal",
                    'chart_of_account_id' => $entry->chart_of_account_id,
                    'debit' => $debit,
                    'credit' => $credit,
                ]);
            }

            return redirect()->back()->with('success', 'Pembukaan saldo awal berhasil dilakukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
