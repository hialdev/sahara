<?php

namespace App\Http\Controllers;

use App\Models\COA;
use App\Models\Invoice;
use App\Models\InvoiceProcess;
use App\Models\JurnalEntry;
use App\Models\Logistic;
use App\Models\Principle;
use App\Models\ProcessProduct;
use App\Models\ProcessPurchaseOrder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index(){
        $invoices = Invoice::all();

        return view('invoice.index', compact('invoices'));
    }

    public function show($id){
        $invoice = Invoice::findOrFail($id);
        $po = PurchaseOrder::where('id',$invoice->purchaseOrder->id)->with(['invoice','address' => function ($query) {
                                                $query->withTrashed();
                                            }, 'client' => function ($query) {
                                                $query->withTrashed();
                                            }, 'getProducts' => function ($query) {
                                                $query->withTrashed();
                                            }, 'purchaseOrderProducts' => function ($query) {
                                                $query->withTrashed();
                                            }])->first();
        $accounts = COA::orderBy('no_code')->get();
        return view('invoice.show', compact('po', 'invoice', 'accounts'));
    }

    public function print($id){
        $invoice = Invoice::findOrFail($id);
        return view('invoice.print', compact('invoice'));
    }

    public function download($id)
    {
        $getSet = Setting::all()->keyBy('the_key');
        $invoice = Invoice::findOrFail($id);
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;
        
        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('invoice.pdf', [
            'title' => 'Invoice for ' . $invoice->client->name . ' No ' . $invoice->no,
            'invoice' => $invoice,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('invoice-' . $invoice->no . '.pdf');
    }

    

    public function delete($id){
        try {
            $invoice = Invoice::findOrFail($id);
            if($invoice->status == 0)
                $invoice->forceDelete();
            $invoice->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus invoice '.$invoice->no);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus invoice, Error: '.$e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $invoice = Invoice::findOrFail($id);
            $receivable = 'Piutang / Penjualan barang '.$invoice->purchaseOrder->client->name.' berdasarkan Nomor '.$invoice->purchaseOrder->no.' dan '.$invoice->no; 
            $revenue = 'Pendapatan penjualan berdasarkan Nomor '.$invoice->purchaseOrder->no.' dan '.$invoice->no; 
            $rec = JurnalEntry::where('name', $receivable)->where('is_generated', 1)->first();
            $rev = JurnalEntry::where('name', $revenue)->where('is_generated', 1)->first();
            //dd($rec, $rev);
            if($rec) $rec->delete();
            if($rev) $rev->delete();

            $invoice->forceDelete();
            $invoice->processes->map(function($process) {
                $process->forceDelete();
            });

            return redirect()->route('invoice.index')->with('success', 'Berhasil menghapus permanen invoice '.$invoice->no);
        } catch (\Exception $e) {
            return redirect()->route('invoice.index')->with('error', 'Gagal menghapus permanen invoice, Error: '.$e->getMessage());
        }
    }


    // ----------------------------------------------------------------
    // Process Invoice
    // ----------------------------------------------------------------

    public function processAdd($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date_paid' => 'nullable|string|date',
            'invoice_id' => 'required|exists:osano.invoices,id',
            'amount_paid' => 'required|numeric|max:'.$invoice->sisaPiutang(),
            'proof_paid' => 'nullable||file|mimes:pdf,docx,doc,ppt|max:2048',
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
            return redirect()->route('invoice.show', $id)
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }
        // Generate nomor surat
        $no_surat = InvoiceProcess::generateNomorSurat();
        //dd($request->all(), $no_surat);
        
        try {
            $filePath = '';
            if ($request->hasFile('proof_paid')) {
                $filePath = $request->file('proof_paid')->store('invoices/process', 'public');
            }

            InvoiceProcess::create([
                'no' => $no_surat,
                'date_paid' => $request->date_paid,
                'invoice_id' => $request->invoice_id,
                'description' => $request->description,
                'amount_paid' => $request->amount_paid,
                'proof_paid' => $filePath,
            ]);

            $this->updateStatusInvoice($id);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Paid Invoice updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('invoice.show', $id)
                ->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal membuat pembayaran invoice, error: ' . $e->getMessage()]);
            }

            return redirect()->route('invoice.show', $id)->withInput()
                ->with('error', 'Gagal membuat pembayaran invoice, error: ' . $e->getMessage());
        }
    }

    public function processUpdate($id, $process_id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $process = InvoiceProcess::findOrFail($process_id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'date_paid' => 'nullable|string|date',
            'invoice_id' => 'required|exists:osano.invoices,id',
            'amount_paid' => 'required|numeric|max:'.$invoice->sisaPiutang()+$process->amount_paid,
            'proof_paid' => 'nullable|file|mimes:pdf,docx,doc,ppt|max:2048',
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
            return redirect()->route('invoice.show', $id)
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

                $filePath = $request->file('proof_paid')->store('invoices/process', 'public');
                $process->proof_paid = $filePath;
            }

            $process->update([
                'date_paid' => $request->date_paid,
                'description' => $request->description,
                'amount_paid' => $request->amount_paid,
                'proof_paid' => $filePath,
            ]);

            $this->updateStatusInvoice($id);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Paid Invoice updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('invoice.show', $id)
                ->with('success', 'Paid Invoice updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal update pembayaran invoice, error: ' . $e->getMessage()]);
            }

            return redirect()->route('invoice.show', $id)->withInput()
                ->with('error', 'Gagal update pembayaran invoice, error: ' . $e->getMessage());
        }
    }

    private function updateStatusInvoice($id){
        $invoice = Invoice::findOrFail($id);
        
        if($invoice->sisaPiutang() == $invoice->total_invoice){
            $invoice->status = '0';
        }else if($invoice->sisaPiutang() > 0){
            $invoice->status = '1';
        }else if($invoice->sisaPiutang() == 0){
            $invoice->status = '2';
        }

        $invoice->save();

        return true;
    }

    public function makeJurnal($id, $process_id, Request $request){
        $validate = Validator::make($request->all(),[
            'receive_account_id' => [
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
            return redirect()->back()->withInput()->with('error', 'Tentukan account yang benar, Pilih akun penerima pembayaran tersebut');
        }
        
        try {
            $invoice = Invoice::where('id',$id)->firstOrFail();
            $process = InvoiceProcess::where('id',$process_id)->firstOrFail();

            $received = new JurnalEntry();
            $received->date = Carbon::now();
            $received->description = 'Transaksi dari Generate Invoice Process '.$process->no;
            $received->chart_of_account_id = $request->get('receive_account_id');
            $received->name = $process->getNameJurnal('receive', $invoice->client->name, $invoice->purchaseOrder->no, $invoice->no, $process->no); 
            $received->is_generated = 1;
            $received->debit = $process->amount_paid; 
            $received->credit = 0;
            $received->save();

            $piutang = new JurnalEntry();
            $piutang->date = Carbon::now();
            $piutang->description = 'Transaksi dari Generate Invoice Process '.$process->no;
            $piutang->chart_of_account_id = $invoice->receivable_account_id;
            $piutang->name = $process->getNameJurnal('piutang', $invoice->client->name, $invoice->purchaseOrder->no, $invoice->no, $process->no); 
            $piutang->is_generated = 1; 
            $piutang->debit = $process->amount_paid; 
            $piutang->credit = 0;
            $piutang->save();

            return redirect()->route('invoice.show', $id)
                    ->with('success', 'Generate Jurnal for Invoice Process '.$process->no.' successfully.');
          
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat Jurnal, error: ' . $e->getMessage());
        }
    }

    public function processDestroy($id, $process_id){
        try {
            $invProcess = InvoiceProcess::findOrFail($process_id);
            if (!empty($invProcess->proof_paid) && Storage::exists($invProcess->proof_paid)) {
                Storage::delete($invProcess->proof_paid);
            }
            $invProcess->forceDelete();
            $receive = $invProcess->getNameJurnal('receive', $invProcess->invoice->client->name, $invProcess->invoice->purchaseOrder->no, $invProcess->invoice->no, $invProcess->no);
            $piutang = $invProcess->getNameJurnal('piutang', $invProcess->invoice->client->name, $invProcess->invoice->purchaseOrder->no, $invProcess->invoice->no, $invProcess->no);
            $rec = JurnalEntry::where('name', $receive)->where('is_generated', 1)->first();
            $piu = JurnalEntry::where('name', $piutang)->where('is_generated', 1)->first();
            if ($rec) $rec->delete();
            if ($piu) $piu->delete();
            
            $this->updateStatusInvoice($id);

            return redirect()->route('invoice.show', $id)->with('success', 'Berhasil menghapus permanen pembayaran invoice beserta jurnal entri terkait '.$invProcess->no);
        } catch (\Exception $e) {
            return redirect()->route('invoice.show', $id)->with('error', 'Gagal menghapus permanen pembayaran invoice beserta jurnal entri terkait, Error: '.$e->getMessage());
        }
    }

}