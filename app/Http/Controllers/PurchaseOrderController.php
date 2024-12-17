<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\COA;
use App\Models\Debt;
use App\Models\Invoice;
use App\Models\JurnalEntry;
use App\Models\Logistic;
use App\Models\Principle;
use App\Models\ProcessProduct;
use App\Models\ProcessPurchaseOrder;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\Satuan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function index(){
        $purchases = PurchaseOrder::with
            (['client' => function ($query) {
                $query->withTrashed();
            }, 'address' => function ($query) {
                $query->withTrashed();
            }, 'getProducts' => function ($query) {
                $query->withTrashed();
            }])->get();

        return view('purchase.index', compact('purchases'));
    }

    public function process(){
        $purchases = ProcessPurchaseOrder::all();

        return view('purchase.process', compact('purchases'));
    }

    public function indexDeleted(){
        $purchases = PurchaseOrder::onlyTrashed()
            ->with
            (['client' => function ($query) {
                $query->withTrashed();
            }, 'address' => function ($query) {
                $query->withTrashed();
            }, 'getProducts' => function ($query) {
                $query->withTrashed();
            }])->get();

        return view('purchase.trash.index', compact('purchases'));
    }

    public function restore($id){

        try {
            $po = PurchaseOrder::onlyTrashed()->where('id',$id)->with(['processOrders' => function($q){
                                                                    $q->withTrashed();
                                                                }])->first();
            if(count($po->processOrders) > 0){
                foreach ($po->processOrders as $process) {
                    $process->restore();
                    ProcessProduct::onlyTrashed()->where('process_id', $process->id)->restore();
                }
            }

            $po->restore();
            return redirect()->route('purchase.index.deleted')
                ->with('success', 'Purchase '. $po->no .' restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal restore purchase , error: ' . $e->getMessage());
        }
    }

    public function add(){
        $satuans = Satuan::all();
        $products = Product::all();
        $clients = Client::all();
        return view('purchase.add', compact('clients', 'satuans', 'products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|string',
            'client' => 'required|string', // Pastikan client adalah ID yang valid
            'address' => 'required|string', // Pastikan client adalah ID yang valid
            'quotation' => 'nullable|string', // Pastikan quotation adalah ID yang valid jika ada
            'po_number' => 'required|string',
            'po_file' => 'required|file|mimes:pdf,docx,doc,ppt|max:2048', // Validasi file hanya untuk tipe tertentu
            'description' => 'required|string',
            'products' => 'required|json',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);

            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText], 400);
            }

            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessageText);
        }

        // Decode products dari JSON menjadi array
        $products = json_decode($request->products, true);

        // Jika decoding gagal, kembalikan pesan error
        if ($products === null) {
            $errorMessage = 'Invalid products data format.';
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 400);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Generate nomor surat
        $no_surat = PurchaseOrder::generateNomorSurat();

        try {
            // Menyimpan file PO jika ada
            $filePath = '';
            if ($request->hasFile('po_file')) {
                $filePath = $request->file('po_file')->store('request-orders', 'public');
            }

            // Simpan purchase baru ke database
            $purchase = PurchaseOrder::create([
                'no' => $no_surat,
                'date' => $request->date,
                'client_id' => $request->client,
                'address_id' => $request->address,
                'quotation_id' => $request->quotation ?? null,
                'po_number' => $request->po_number,
                'po_file' => $filePath,
                'description' => $request->description,
                'products' => json_encode($products),
                'status' => '0', // Status : 0 -> waiting, 1 -> delivered, 2 -> waiting delivery, 3 -> finished
            ]);

            // Simpan setiap produk yang terkait dengan purchase order
            foreach ($products as $product) {
                PurchaseOrderProduct::create([
                    'purchase_order_id' => $purchase->id,
                    'product_id' => $product['id'], // Pastikan key yang tepat diambil
                    'packaging_id' => $product['packaging_id'],
                    'qty' => $product['qty'],
                    'price' => $product['price_sale'],
                    'description' => $product['description'],
                ]);
            }

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Request Order / Purchase from Client created successfully.', 
                    'redirect_url' => route('purchase.show', ['id' => $purchase->id])
                ]);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('purchase.index')
                ->with('success', 'Request Order / Purchase from Client created successfully.');
        } catch (\Exception $e) {
            // Penanganan error
            $errorMessage = 'Gagal membuat Request Order / Purchase from Client, error: ' . $e->getMessage();

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 500);
            }

            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function show($id){
        $po = PurchaseOrder::where('id',$id)->with(['invoice','address' => function ($query) {
                                                $query->withTrashed();
                                            }, 'client' => function ($query) {
                                                $query->withTrashed();
                                            }, 'getProducts' => function ($query) {
                                                $query->withTrashed();
                                            }, 'purchaseOrderProducts' => function ($query) {
                                                $query->withTrashed();
                                            }])->first();
        $principles = Principle::all();
        $logistics = Logistic::all();
        $processeds = ProcessPurchaseOrder::with('getProducts')->where('purchase_order_id', $id)->latest()->get();
        $statusProducts = $this->getStatusProducts($id);
        $accounts = COA::all();
        return view('purchase.show', compact('accounts', 'po', 'principles', 'logistics', 'processeds', 'statusProducts'));
    }

    public function showDeleted($id){
        $po = PurchaseOrder::onlyTrashed()->where('id',$id)->with(['address' => function ($query) {
                                                $query->withTrashed();
                                            }, 'client' => function ($query) {
                                                $query->withTrashed();
                                            }, 'getProducts' => function ($query) {
                                                $query->withTrashed();
                                            }, 'purchaseOrderProducts' => function ($query) {
                                                $query->withTrashed();
                                            }, 'processOrders' => function ($query) {
                                                $query->withTrashed();
                                            }])->firstOrFail();
        $principles = Principle::all();
        $logistics = Logistic::all();
        $processeds = ProcessPurchaseOrder::onlyTrashed()->with(['getProducts' => function ($query) {
                                                $query->withTrashed();
                                            }, 'principle' => function ($query) {
                                                $query->withTrashed();
                                            }])->where('purchase_order_id', $id)->latest()->get();
        $statusProducts = $this->getStatusProducts($id);
        
        return view('purchase.trash.show', compact('po', 'principles', 'logistics', 'processeds', 'statusProducts'));
    }

    public function getStatusProducts($purchaseId) {
        // Ambil data PurchaseOrderProduct bersama dengan jumlah qty dari ProcessProduct secara langsung
        // Ambil ID produk dari `PurchaseOrderProduct` yang terkait dengan `purchaseId`
        $products = PurchaseOrderProduct::withTrashed()
                                            ->with(['product' => function ($query) {
                                                $query->withTrashed();
                                            }, 'processProducts' => function ($query) {
                                                $query->withTrashed();
                                            }])
            ->where('purchase_order_id', $purchaseId)
            ->get();

        $productIds = $products->pluck('product_id');

        // Ambil semua data `ProcessProduct` yang memiliki `product_id` sesuai dengan $productIds 
        // dan yang memiliki `purchase_id` yang terkait di `ProcessPurchaseOrder`
        $processProductsData = ProcessProduct::withTrashed()->whereHas('processOrder', function($query) use ($purchaseId) {
                $query->withTrashed();
                $query->where('purchase_order_id', $purchaseId);

            })
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');
        
        // Hitung nilai done_qty, on_process_qty, waiting_qty, dan left_qty untuk setiap produk
        $products = $products->map(function ($product) use ($processProductsData) {
            // Panggil fungsi checkQty untuk menghitung qty terkait
            $qtyData = $this->checkQty($product->product_id, $product->qty, $processProductsData);
    
            // Tambahkan data kalkulasi ke dalam hasil
            $product->done_qty = $qtyData['done_qty'];
            $product->on_process_qty = $qtyData['on_process_qty'];
            $product->waiting_qty = $qtyData['waiting_qty'];
            $product->left_qty = $qtyData['left_qty'];
    
            return $product;
        });
        
        return $products;
    }
    
    // Fungsi untuk menghitung qty terkait
    private function checkQty($productId, $purchaseQty, $processProductsData) {
        // Ambil semua ProcessProduct terkait dari hasil yang sudah diambil sebelumnya
        $relatedProcessProducts = $processProductsData->get($productId, collect());
    
        // Inisialisasi variabel untuk menyimpan qty yang selesai, sedang diproses, dan menunggu
        $doneQty = 0;
        $onProcessQty = 0;
        $waitingQty = 0;
    
        // Iterasi melalui setiap ProcessProduct
        foreach ($relatedProcessProducts as $processProduct) {
            $processOrder = $processProduct->processOrder;
    
            // Periksa status proses
            if ($processOrder) {
                if ($processOrder->is_finished == 2) {
                    $doneQty += $processProduct->qty;
                } elseif ($processOrder->is_finished == 1) {
                    $onProcessQty += $processProduct->qty;
                } elseif ($processOrder->is_finished == 0) {
                    $waitingQty += $processProduct->qty;
                }
            }
        }
    
        // Hitung qty yang tersisa
        $leftQty = max(0, $purchaseQty - ($doneQty + $onProcessQty + $waitingQty));
    
        return [
            'done_qty' => $doneQty,
            'on_process_qty' => $onProcessQty,
            'waiting_qty' => $waitingQty,
            'left_qty' => $leftQty
        ];
    }

    public function edit($id){
        $purchase = PurchaseOrder::findOrFail($id);
        if($purchase->getStatus() != 0){
            return redirect()->route('purchase.index')->with('error', 'Purchase already processed, so cannot edit');
        }

        $clients = Client::all();
        $satuans = Satuan::all();
        $products = Product::all();

        return view('purchase.edit', compact('clients', 'satuans', 'products', 'purchase'));
    }

    public function update($id, Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|string',
            'client' => 'required',
            'for' => 'required|string',
            'message' => 'required|string',
            'keterangan' => 'required|string',
            'products' => 'required|json', // Validasi bahwa ini adalah JSON string
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        // Decode products dari JSON menjadi array
        $products = json_decode($request->products, true);

        // Jika decoding gagal, kembalikan pesan error
        if ($products === null) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Invalid products data format.']);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid products data format.');
        }

        try {
            $purchase = PurchaseOrder::find($id);

            if($purchase->getStatus() != 0){
                return redirect()->back()->with('error', 'Purchase already processed, so cannot edit');
            }

            // Simpan purchase baru
            $purchase->update([
                'date' => $request->date,
                'client_id' => $request->client,
                'for' => $request->for,
                'message' => $request->message,
                'keterangan' => $request->keterangan,
                'products' => json_encode($products), // Simpan sebagai JSON ke database
                'status' => '0', // 0 -> offering, 1 -> purchased, 2 -> closed
            ]);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'purchase updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('purchase.index')
                ->with('success', 'purchase updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal update purchase, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal update purchase, error: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $po = PurchaseOrder::findOrFail($id);
            if(count($po->processOrders) > 0){
                foreach ($po->processOrders as $process) {
                    $process->delete();
                }
                $po->delete();
            }else{
                $po->forceDelete();
            }
            return redirect()->route('purchase.index')
                ->with('success', 'purchase deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus purchase, error: ' . $e->getMessage());
        }
    }

    public function destroyDeleted($id){
        try {
            $po = PurchaseOrder::onlyTrashed()->where('id',$id)->firstOrFail();
            if(count($po->processOrders) > 0){
                foreach ($po->processOrders as $process) {
                    $process->forceDelete();
                }
                $po->invoice->forceDelete();
            }else{
                $po->forceDelete();
            }
            
            $receivable = 'Piutang / Penjualan barang '.$po->client->name.' berdasarkan Nomor '.$po->no.' dan '.$po->invoice->no; 
            $revenue = 'Pendapatan penjualan berdasarkan Nomor '.$po->no.' dan '.$po->invoice->no; 
            $rec = JurnalEntry::where('name', $receivable)->where('is_generated', 1)->first();
            $rev = JurnalEntry::where('name', $revenue)->where('is_generated', 1)->first();
            if($rec) $rec->delete();
            if($rev) $rev->delete();

            return redirect()->route('purchase.index.deleted')
                ->with('success', 'purchase beserta data terkait (termasuk Jurnal) hapus permanent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus purchase secara permanen, error: ' . $e->getMessage());
        }
    }

    public function invoice($id, Request $request){
        $validate = Validator::make($request->all(),[
            'receivable_account_id' => [
                'required',
                'exists:osano.chart_of_accounts,id',
                function ($attribute, $value, $fail) {
                    $account = COA::where('id', $value)->first();
                    if (!$account || !preg_match('/^(1)/', $account->no_code)) {
                        $fail('The ' . $attribute . ' must have a no_code starting with 1 (assets).');
                    }
                },
            ],
            'revenue_account_id' => [
                'required',
                'exists:osano.chart_of_accounts,id',
                function ($attribute, $value, $fail) {
                    $account = COA::where('id', $value)->first();
                    if (!$account || !preg_match('/^(4)/', $account->no_code)) {
                        $fail('The ' . $attribute . ' must have a no_code starting with 4 (revenue).');
                    }
                },
            ],
        ]);
        if($validate->fails()){
            return redirect()->back()->withInput()->with('error', 'Tentukan account yang benar, Kode akun Assets (1x) dan Revenue (4x)');
        }
        
        try {
            $po = PurchaseOrder::where('id',$id)->firstOrFail();
            if($po->getStatus() == 3 && !$po->invoice){
                $total_invoice = 0;
                foreach ($po->getProducts as $prod) {
                    $total_invoice += $prod->qty * $prod->price;
                }
                //dd($total_invoice);
                $invoice = new Invoice();
                $no_surat = $invoice->generateNomorSurat();
                $invoice->create([
                    'no' => $no_surat,
                    'date' => Carbon::now(),
                    'purchase_order_id' => $id,
                    'total_invoice' => $total_invoice,
                    'receivable_account_id' => $request->get('receivable_account_id'),
                    'revenue_account_id' => $request->get('revenue_account_id'),
                    'client_id' => $po->client_id,
                    'po_file' => $po->po_file,
                    'description' => $po->description,
                ]);
                
                $receivable = new JurnalEntry();
                $receivable->date = Carbon::now();
                $receivable->description = 'Transaksi dari Generate Invoice';
                $receivable->chart_of_account_id = $request->get('receivable_account_id');
                $receivable->name = 'Piutang / Penjualan barang '.$po->client->name.' berdasarkan Nomor '.$po->no.' dan '.$no_surat; 
                $receivable->debit = $total_invoice; 
                $receivable->credit = 0;
                $receivable->is_generated = 1;
                $receivable->save();

                $revenue = new JurnalEntry();
                $revenue->date = Carbon::now();
                $revenue->description = 'Transaksi dari Generate Invoice';
                $revenue->chart_of_account_id = $request->get('revenue_account_id');
                $revenue->name = 'Pendapatan penjualan berdasarkan Nomor '.$po->no.' dan '.$no_surat; 
                $revenue->is_generated = 1; 
                $revenue->debit = 0; 
                $revenue->credit = $total_invoice;
                $revenue->save();

                return redirect()->route('invoice.index')
                        ->with('success', 'Generate Invoice and Jurnal (Receivable, Revenue) for Purchase Order '.$po->no.' successfully.');
            }else{
                return redirect()->route('purchase.show', $id)
                    ->with('error', 'Error Generate Invoice for Purchase Order '.$po->no.', Pastikan Purchase Order yang telah selesai di proses sepenuhnya.');
            }
            return redirect()->route('purchase.show', $id)
                ->with('success', 'Generate Invoice for Purchase Order '.$po->no.' successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat invoice purchase order, error: ' . $e->getMessage());
        }
    }

}
