<?php

namespace App\Http\Controllers;

use App\Models\COA;
use App\Models\Debt;
use App\Models\DebtProcess;
use App\Models\JurnalEntry;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DebtController extends Controller
{
    
    public function index(){
        $debts = Debt::all();

        return view('debt.index', compact('debts'));
    }

    public function show($id){
        $debt = Debt::findOrFail($id);
        $accounts = COA::orderBy('no_code')->get();
        return view('debt.show', compact('debt', 'accounts'));
    }

    public function print($id){
        $debt = Debt::findOrFail($id);
        return view('debt.print', compact('debt'));
    }

    public function download($id)
    {
        $getSet = Setting::all()->keyBy('the_key');
        $debt = Debt::findOrFail($id);
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;
        
        $svg = (object) [
            'delivery' => base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#435ebe" d="M3 4a2 2 0 0 0-2 2v11h2a3 3 0 0 0 3 3a3 3 0 0 0 3-3h6a3 3 0 0 0 3 3a3 3 0 0 0 3-3h2v-5l-3-4h-3V4m-7 2l4 4l-4 4v-3H4V9h6m7 .5h2.5l1.97 2.5H17M6 15.5A1.5 1.5 0 0 1 7.5 17A1.5 1.5 0 0 1 6 18.5A1.5 1.5 0 0 1 4.5 17A1.5 1.5 0 0 1 6 15.5m12 0a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5a1.5 1.5 0 0 1-1.5-1.5a1.5 1.5 0 0 1 1.5-1.5" /></svg>'),
            'principle' => base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#435ebe" d="M7 12c2.2 0 4-1.8 4-4S9.2 4 7 4S3 5.8 3 8s1.8 4 4 4m4 8v-5.3c-1.1-.4-2.5-.7-4-.7c-3.9 0-7 1.8-7 4v2zm4-16c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/></svg>'),
            'pic' => base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#435ebe" d="M12 16q-1.725 0-3.225.525T6 18v2h12v-2q-1.275-.95-2.775-1.475T12 16m-6 6q-.825 0-1.412-.587T4 20V4q0-.825.588-1.412T6 2h12q.825 0 1.413.588T20 4v16q0 .825-.587 1.413T18 22zm6-8q1.45 0 2.475-1.025T15.5 10.5t-1.025-2.475T12 7T9.525 8.025T8.5 10.5t1.025 2.475T12 14"/></svg>'),
        ];

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('debt.pdf', [
            'title' => 'Debt for PO to ' . $debt->principle->name . ' with No ' . $debt->no,
            'debt' => $debt,
            'kop_image' => $kop_image,
            'svg' => $svg
        ])->setPaper('folio', 'landscape');

        return $pdf->download('debt-' . $debt->no . '.pdf');
    }

    public function delete($id){
        try {
            $debt = Debt::findOrFail($id);
            if($debt->status == 0)
                $debt->forceDelete();
            $debt->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus debt '.$debt->no);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus debt, Error: '.$e->getMessage());
        }
    }

    public function makeJurnal($id, $process_id, Request $request){
        $validate = Validator::make($request->all(),[
            'payment_account_id' => [
                'required',
                'exists:osano.chart_of_accounts,id',
                function ($attribute, $value, $fail) {
                    $account = COA::where('id', $value)->first();
                    if (!$account || !preg_match('/^(1)/', $account->no_code)) {
                        $fail('The ' . $attribute . ' must have a no_code starting with 1 (assets).');
                    }
                },
            ],
        ]);
        if($validate->fails()){
            return redirect()->back()->withInput()->with('error', 'Tentukan account yang benar, Pilih akun yang menjadi alat pembayaran tersebut');
        }
        
        try {
            $debt = Debt::where('id',$id)->firstOrFail();
            $process = DebtProcess::where('id',$process_id)->firstOrFail();
            //dd($request->all(), $debt, $process);
            $payment = new JurnalEntry();
            $payment->date = Carbon::now();
            $payment->description = 'Transaksi dari Generate Debt Process '.$process->no;
            $payment->chart_of_account_id = $request->get('payment_account_id');
            $payment->name = $process->getNameJurnal('payment', $debt->principle->name, $debt->processOrder->no, $debt->no, $process->no); 
            $payment->is_generated = 1;
            $payment->debit = 0;
            $payment->credit = $process->amount_paid; 
            $payment->save();

            $hutang = new JurnalEntry();
            $hutang->date = Carbon::now();
            $hutang->description = 'Transaksi dari Generate Debt Process '.$process->no;
            $hutang->chart_of_account_id = $debt->payable_account_id;
            $hutang->name = $process->getNameJurnal('hutang', $debt->principle->name, $debt->processOrder->no, $debt->no, $process->no); 
            $hutang->is_generated = 1; 
            $hutang->debit = $process->amount_paid; 
            $hutang->credit = 0;
            $hutang->save();

            return redirect()->route('debt.show', $id)
                    ->with('success', 'Generate Jurnal for Debt Process '.$process->no.' successfully.');
          
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat Jurnal, error: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $debt = Debt::findOrFail($id);
            $debt->forceDelete();
            $debt->processes->map(function($process) {
                $process->forceDelete();
            });
            $payable = 'Hutang ke Principle '.$debt->processOrder->principle->name.' berdasarkan Nomor '.$debt->processOrder->no.' dan '.$debt->no; 
            $cogs = 'Beban Pokok Penjualan berdasarkan Nomor '.$debt->processOrder->no.' dan '.$debt->no; 
            $pay = JurnalEntry::where('name', $payable)->where('is_generated', 1)->first();
            $cog = JurnalEntry::where('name', $cogs)->where('is_generated', 1)->first();
            if($pay) $pay->delete();
            if($cog) $cog->delete();
            return redirect()->route('debt.index')->with('success', 'Berhasil menghapus permanen debt '.$debt->no);
        } catch (\Exception $e) {
            return redirect()->route('debt.index')->with('error', 'Gagal menghapus permanen debt, Error: '.$e->getMessage());
        }
    }


    // ----------------------------------------------------------------
    // Process Debt
    // ----------------------------------------------------------------

    public function processAdd($id, Request $request)
    {
        $debt = Debt::findOrFail($id);
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date_paid' => 'nullable|string|date',
            'debt_id' => 'required|exists:osano.debts,id',
            'amount_paid' => 'required|numeric|max:'.$debt->sisaHutang(),
            'proof_paid' => 'required||file|mimes:pdf,docx,doc,ppt|max:2048',
            'description' => 'nullable|string',
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
            return redirect()->route('debt.show', $id)
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }
        // Generate nomor surat
        $no_surat = DebtProcess::generateNomorSurat();
        //dd($request->all(), $no_surat);
        
        try {
            $filePath = '';
            if ($request->hasFile('proof_paid')) {
                $filePath = $request->file('proof_paid')->store('debts/process', 'public');
            }

            DebtProcess::create([
                'no' => $no_surat,
                'date_paid' => $request->date_paid,
                'debt_id' => $request->debt_id,
                'description' => $request->description,
                'amount_paid' => $request->amount_paid,
                'proof_paid' => $filePath,
            ]);

            $this->updateStatusDebt($id);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Paid Debt updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('debt.show', $id)
                ->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal membuat pembayaran debt, error: ' . $e->getMessage()]);
            }

            return redirect()->route('debt.show', $id)->withInput()
                ->with('error', 'Gagal membuat pembayaran debt, error: ' . $e->getMessage());
        }
    }

    public function processUpdate($id, $process_id, Request $request)
    {
        $debt = Debt::findOrFail($id);
        $process = DebtProcess::findOrFail($process_id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'date_paid' => 'nullable|string|date',
            'debt_id' => 'required|exists:osano.debts,id',
            'amount_paid' => 'required|numeric|max:'.$debt->sisaHutang()+$process->amount_paid,
            'proof_paid' => 'required||file|mimes:pdf,docx,doc,ppt|max:2048',
            'description' => 'nullable|string',
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
            return redirect()->route('debt.show', $id)
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }
        
        try {
            $filePath = '';
            if ($request->hasFile('proof_paid')) {
                if (!empty($process->proof_paid) && Storage::exists($process->proof_paid)) {
                    Storage::delete($process->proof_paid);
                }

                $filePath = $request->file('proof_paid')->store('debts/process', 'public');
                $process->proof_paid = $filePath;
            }

            $process->update([
                'date_paid' => $request->date_paid,
                'description' => $request->description,
                'amount_paid' => $request->amount_paid,
                'proof_paid' => $filePath,
            ]);

            $this->updateStatusDebt($id);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Paid Debt updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('debt.show', $id)
                ->with('success', 'Paid Debt updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal update pembayaran debt, error: ' . $e->getMessage()]);
            }

            return redirect()->route('debt.show', $id)->withInput()
                ->with('error', 'Gagal update pembayaran debt, error: ' . $e->getMessage());
        }
    }

    private function updateStatusDebt($id){
        $debt = Debt::findOrFail($id);
        
        if($debt->sisaHutang() == $debt->total_debt){
            $debt->status = '0';
        }else if($debt->sisaHutang() > 0){
            $debt->status = '1';
        }else if($debt->sisaHutang() == 0){
            $debt->status = '2';
        }

        $debt->save();

        return true;
    }

    public function processDestroy($id, $process_id){
        try {
            $debtProcess = DebtProcess::findOrFail($process_id);
            if (!empty($debtProcess->proof_paid) && Storage::exists($debtProcess->proof_paid)) {
                Storage::delete($debtProcess->proof_paid);
            }
            $debtProcess->forceDelete();
            $payment = $debtProcess->getNameJurnal('payment', $debtProcess->debt->principle->name, $debtProcess->debt->processOrder->no, $debtProcess->debt->no, $debtProcess->no);
            $hutang = $debtProcess->getNameJurnal('hutang', $debtProcess->debt->principle->name, $debtProcess->debt->processOrder->no, $debtProcess->debt->no, $debtProcess->no);
            $pay = JurnalEntry::where('name', $payment)->where('is_generated', 1)->first();
            $hut = JurnalEntry::where('name', $hutang)->where('is_generated', 1)->first();
            if ($pay) $pay->delete();
            if ($hut) $hut->delete();
            
            $this->updateStatusDebt($id);

            return redirect()->route('debt.show', $id)->with('success', 'Berhasil menghapus permanen pembayaran debt beserta data jurnal terkaitnya '.$debtProcess->no);
        } catch (\Exception $e) {
            return redirect()->route('debt.show', $id)->with('error', 'Gagal menghapus permanen pembayaran debt beserta data jurnal terkaitnya , Error: '.$e->getMessage());
        }
    }
}
