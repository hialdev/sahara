<?php

namespace App\Http\Controllers;

use App\Models\COA;
use App\Models\Debt;
use App\Models\JurnalEntry;
use App\Models\ProcessProduct;
use App\Models\ProcessPurchaseOrder;
use App\Models\PurchaseOrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProcessPurchaseController extends Controller
{
    public function store(Request $request, $id) {
        // Validation rules
        $rules = [
            'principle' => 'required|string|exists:osano.principles,id',
            'logistic' => 'nullable|string|exists:osano.logistics,id',
            'description' => 'nullable|string',
            'date' => 'required|string',
            'address-jemput' => 'nullable|string|exists:osano.principle_address,id',
            'is-logistic-sahara' => 'required|boolean',
            'products' => 'required|array',
            'products.*' => 'exists:osano.purchase_order_products,id',
            'file-spk' => 'nullable|file|mimes:pdf,docx,doc,ppt|max:7168',
            'file-surjal' => 'nullable|file|mimes:pdf,docx,doc,ppt|max:7168',
        ];
    
        // Process each product from the request
        foreach ($request->get('products', []) as $productId) {
            $qtyKey = "process-qty-" . $productId;
            $process = ProcessProduct::find($productId);
    
            if (!$process) {
                continue; // Skip if no data
            }
    
            // Fetch the related PurchaseOrderProduct
            $purchaseProduct = PurchaseOrderProduct::where('product_id', $process->product_id)
                ->where('purchase_order_id', $id)
                ->first();
    
            if (!$purchaseProduct) {
                continue; // Skip if no data
            }
    
            // Initialize variables to store qty for different statuses
            $waitingQty = 0;
            $onProcessQty = 0;
            $doneQty = 0;
    
            // Retrieve all related ProcessOrderProducts
            $processProducts = ProcessProduct::whereHas('processOrder', function($query) use ($id) {
                $query->where('purchase_order_id', $id);
            })->where('product_id', $process->product_id)->get();
    
            foreach ($processProducts as $processProduct) {
                $processOrder = $processProduct->processOrder;
    
                // Check the process status
                if ($processOrder) {
                    if ($processOrder->is_finished == 2) {
                        $doneQty += $processProduct->qty;
                    } elseif ($processOrder->is_finished == 1) {
                        $onProcessQty += $processProduct->qty;
                    } else {
                        $waitingQty += $processProduct->qty;
                    }
                }
            }
    
            // Calculate the remaining qty
            $leftQty = $purchaseProduct->qty - ($doneQty + $onProcessQty + $waitingQty);
            $leftQty = max(0, $leftQty); // Ensure it's not negative
    
            // Add validation rule: qty should not exceed left_qty
            $rules[$qtyKey] = 'required|integer|min:0|max:' . $leftQty;
        }

        //Validate Price Buy
        foreach ($request->get('products', []) as $productId) {
            $qtyKey = "price-buy-" . $productId;
            $process = ProcessProduct::find($productId);
    
            $rules[$qtyKey] = 'required|integer';
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
    
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText], 400);
            }
    
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessageText);
        }

        //dd($request->all());
        // Handle store logic...
        // Jika tidak ada produk yang ditemukan
        if (count($request->products) < 0) {
            $errorMessage = 'Tidak ada product yang ditemukan';
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 400);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        $no_surat = ProcessPurchaseOrder::generateNomorSurat();
        try {
            // Menyimpan file PO jika ada
            $spkFilePath = '';
            $surjalFilePath = '';
            if ($request->hasFile('file-spk')) {
                $spkFilePath = $request->file('file-spk')->store('purchase-orders', 'public');
            };
            if ($request->hasFile('file-surjal')) {
                $surjalFilePath = $request->file('file-surjal')->store('purchase-orders', 'public');
            }
            
            // Simpan purchase baru ke database
            $purchaseStore = ProcessPurchaseOrder::create([
                'no' => $no_surat,
                'date' => $request->date,
                'purchase_order_id' => $id,
                'principle_id' => $request->principle,
                'address_id' => $request->get('address-jemput') ?? null,
                'is_logistic_in_sahara' => $request->get('is-logistic-sahara') == 1 ? 1 : 0,
                'logistic_id' => $request->logistic ?? null,
                'spk_file' => $spkFilePath ?? null,
                'surjal_file' => $surjalFilePath ?? null,
                'description' => $request->description,
                'products' => json_encode($request->products),
                'status' => '0', // Status : 0 -> waiting, 1 -> delivered, 2 -> waiting delivery, 3 -> finished
            ]);

            // Simpan setiap produk yang terkait dengan purchase order
            foreach ($request->products as $purchaseProductId) {
                $purchase = PurchaseOrderProduct::find($purchaseProductId);
                ProcessProduct::create([
                    'process_id' => $purchaseStore->id,
                    'product_id' => $purchase->product_id,
                    'price_buy' => $request->get('price-buy-'.$purchaseProductId),
                    'qty' => $request->get('process-qty-'.$purchaseProductId),
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
            return redirect()->route('purchase.show', $id)
                ->with('success', 'Processing Purchase / PO Principle created successfully.');
        } catch (\Exception $e) {
            // Penanganan error
            $errorMessage = 'Gagal memproses / membuat PO Principle, error: ' . $e->getMessage();

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
    
    public function update(Request $request, $id, $process_id)
    {
        // Validation rules (same as store)
        $rules = [
            'principle' => 'required|string|exists:osano.principles,id',
            'logistic' => 'nullable|string|exists:osano.logistics,id',
            'description' => 'nullable|string',
            'date' => 'required|string',
            'address_jemput' => 'nullable|string|exists:osano.principle_address,id',
            'is_logistic_sahara' => 'nullable|boolean',
            'products' => 'required|array',
            'products.*' => 'exists:osano.purchase_order_products,id',
            'file_spk' => 'nullable|file|mimes:pdf,docx,doc,ppt|max:7168',
            'file_surjal' => 'nullable|file|mimes:pdf,docx,doc,ppt|max:7168',
        ];

        $products = $request->get('products',[]);
        foreach ($products as $productId) {
            $qtyKey = "process-qty-" . $productId;

            $purchaseProduct = PurchaseOrderProduct::where('id', $productId)
                ->where('purchase_order_id', $id)
                ->first();
            
            if (!$purchaseProduct) {
                continue;
            }

            // Calculate quantities
            $waitingQty = 0;
            $onProcessQty = 0;
            $doneQty = 0;
            $nowQty = 0;
            $processProducts = ProcessProduct::whereHas('processOrder', function($query) use ($id) {
                $query->where('purchase_order_id', $id);
            })->where('product_id', $purchaseProduct->product_id)->get();
            foreach ($processProducts as $processProduct) {
                $processOrder = $processProduct->processOrder;
                if ($processOrder) {
                    if ($processOrder->is_finished == 2) {
                        $doneQty += $processProduct->qty;
                    } elseif ($processOrder->is_finished == 1) {
                        $onProcessQty += $processProduct->qty;
                    } else {
                        $waitingQty += $processProduct->qty;
                        $nowQty += $processProduct->qty;
                    }
                }
            }
            
            $processPO = ProcessPurchaseOrder::find($process_id);
            $processProductsById = $processPO->getProducts->groupBy('product_id');
            $pp = $processProductsById[$purchaseProduct->product_id][0];
            $leftQty = ($purchaseProduct->qty - ($doneQty + $onProcessQty + $waitingQty)) + $pp->qty;
            $leftQty = max(0, $leftQty);
            $rules[$qtyKey] = 'nullable|integer|min:0|max:' . $leftQty;
        }

        //Validate Price Buy
        foreach ($request->get('products', []) as $productId) {
            $qtyKey = "price-buy-" . $productId;
    
            $rules[$qtyKey] = 'required|integer';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);

            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText], 400);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessageText);
        }

        try {
            $purchaseOrder = ProcessPurchaseOrder::findOrFail($process_id);
        
            // Path file lama
            $spkFilePath = $purchaseOrder->spk_file;
            $surjalFilePath = $purchaseOrder->surjal_file;
        
            // Menghapus file lama jika ada file baru yang diunggah
            if ($request->hasFile('file_spk')) {
                if ($spkFilePath && Storage::disk('public')->exists($spkFilePath)) {
                    Storage::disk('public')->delete($spkFilePath); // Hapus file lama
                }
                $spkFilePath = $request->file('file_spk')->store('purchase-orders', 'public'); // Simpan file baru
            }
        
            if ($request->hasFile('file_surjal')) {
                if ($surjalFilePath && Storage::disk('public')->exists($surjalFilePath)) {
                    Storage::disk('public')->delete($surjalFilePath); // Hapus file lama
                }
                $surjalFilePath = $request->file('file_surjal')->store('purchase-orders', 'public'); // Simpan file baru
            }
            
            //dd($request->all(), $spkFilePath, $surjalFilePath, json_encode($request->products));
        
            // Melakukan update ke database
            $purchaseOrder->update([
                'date' => $request->date,
                'principle_id' => $request->principle,
                'address_id' => $request->get('address_jemput') ?? null,
                'is_logistic_in_sahara' => $request->get('is_logistic_sahara') == '1' ? 1 : 0,
                'logistic_id' => $request->logistic ?? null,
                'spk_file' => $spkFilePath,
                'surjal_file' => $surjalFilePath,
                'description' => $request->description,
                'products' => json_encode($request->products),
                'is_finished' => 0,
            ]);
        
            // Update ProcessProduct entries as before
            //dd($request->all());
            $fd = ProcessProduct::where('process_id', $purchaseOrder->id)->withTrashed()->forceDelete();
            //dd($fd);
            foreach ($request->products as $purchaseProductId) {
                $purchase = PurchaseOrderProduct::find($purchaseProductId);
                ProcessProduct::create([
                    'process_id' => $purchaseOrder->id,
                    'product_id' => $purchase->product_id,
                    'price_buy' => $request->get('price-buy-' . $purchaseProductId),
                    'qty' => $request->get('process-qty-' . $purchaseProductId),
                ]);
            }

        
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Purchase order updated successfully.',
                    'redirect_url' => route('purchase.show', ['id' => $purchaseOrder->id])
                ]);
            }
        
            return redirect()->route('purchase.show', $id)
                ->with('success', 'Purchase order updated successfully.');
        } catch (\Exception $e) {
            $errorMessage = 'Failed to update purchase order: ' . $e->getMessage();
        
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 500);
            }
        
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function processing(Request $request, $id, $process_id){
        try {
            $processPurchase = ProcessPurchaseOrder::findOrFail($process_id);

            $statusProducts = $this->getStatusProducts($id);
            $checkLeftQty = $statusProducts->every(function ($statusProduct) {
                return ($statusProduct->qty - ($statusProduct->waiting_qty + $statusProduct->done_qty + $statusProduct->on_process_qty)) >= 0;
            });
            
            // Melakukan update ke database
            if($processPurchase->is_finished == 0 && $checkLeftQty){
                $processPurchase->update([
                    'is_finished' => 1,
                ]);
            }else{
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal Memperbarui status, coba perbaiki Qty yang diproses pada setiap Product.',
                        'redirect_url' => route('purchase.show', ['id' => $id])
                    ]);
                }
            
                return redirect()->route('purchase.show', $id)
                    ->with('error', 'Gagal Memperbarui status, coba perbaiki Qty yang diproses pada setiap Product.');
            }
        
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proses Purchase Order kini menjadi status diproses.',
                    'redirect_url' => route('purchase.show', ['id' => $id])
                ]);
            }
        
            return redirect()->route('purchase.show', $id)
                ->with('success', 'proses Purchase order  kini menjadi status diproses.');
        } catch (\Exception $e) {
            $errorMessage = 'Failed to update purchase order: ' . $e->getMessage();
        
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 500);
            }
        
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function finish(Request $request, $id, $process_id){
        try {
            $processPurchase = ProcessPurchaseOrder::findOrFail($process_id);

            // Melakukan update ke database
            if($processPurchase->is_finished == 1){
                $processPurchase->update([
                    'is_finished' => 2,
                ]);
            }else{

            }
        
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proses Purchase Order kini menjadi status diproses.',
                    'redirect_url' => route('purchase.show', ['id' => $id])
                ]);
            }
        
            return redirect()->route('purchase.show', $id)
                ->with('success', 'proses Purchase order  kini menjadi status diproses.');
        } catch (\Exception $e) {
            $errorMessage = 'Failed to update purchase order: ' . $e->getMessage();
        
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 500);
            }
        
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function destroy(Request $request, $id, $process_id){
        try {
            $processPurchase = ProcessPurchaseOrder::findOrFail($process_id);
        
            // Melakukan update ke database
            if($processPurchase->is_finished == 0 || Auth::user()->hasRole('executive')){
                $processPurchase->forceDelete();
                foreach ($processPurchase->getProducts as $pcprod) {
                    $pcprod->forceDelete();
                }
                $processPurchase->debt->forceDelete();

                $payable = 'Hutang ke Principle '.$processPurchase->principle->name.' berdasarkan Nomor '.$processPurchase->no.' dan '.$processPurchase->debt->no; 
                $cogs = 'Beban Pokok Penjualan berdasarkan Nomor '.$processPurchase->no.' dan '.$processPurchase->debt->no; 
                $pay = JurnalEntry::where('name', $payable)->where('is_generated', 1)->first();
                $cog = JurnalEntry::where('name', $cogs)->where('is_generated', 1)->first();
                if($pay) $pay->delete();
                if($cog) $cog->delete();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proses Purchase Order ke Principle beserta data terkait (termasuk Jurnal) berhasil dihapus.',
                    'redirect_url' => route('purchase.show', ['id' => $id])
                ]);
            }
        
            return redirect()->route('purchase.show', $id)
                ->with('success', 'Proses Purchase order ke Principle berhasil dihapus.');
        } catch (\Exception $e) {
            $errorMessage = 'Failed to delete purchase order: ' . $e->getMessage();
        
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessage], 500);
            }
        
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }


    // -------------------------------------------
    // Get Status Products
    // -------------------------------------------
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

    public function debt($id, $process_id, Request $request){
        $validate = Validator::make($request->all(),[
            'payable_account_id' => [
                'required',
                'exists:osano.chart_of_accounts,id',
                function ($attribute, $value, $fail) {
                    $account = COA::where('id', $value)->first();
                    if (!$account || !preg_match('/^(2)/', $account->no_code)) {
                        $fail('The ' . $attribute . ' must have a no_code starting with 2 (liability).');
                    }
                },
            ],
            'cogs_account_id' => [
                'required',
                'exists:osano.chart_of_accounts,id',
                function ($attribute, $value, $fail) {
                    $account = COA::where('id', $value)->first();
                    if (!$account || !preg_match('/^(5)/', $account->no_code)) {
                        $fail('The ' . $attribute . ' must have a no_code starting with 5 (expense).');
                    }
                },
            ],
        ]);
        if($validate->fails()){
            return redirect()->back()->withInput()->with('error', 'Tentukan account yang benar, Kode akun Payable / Liability (2x) dan Expense (5x)');
        }

        try {
            $process = ProcessPurchaseOrder::where('id',$process_id)->firstOrFail();
            if($process->is_finished == 2 && !$process->debt){
                $total_debt = 0;
                foreach ($process->getProducts as $prod) {
                    $total_debt += $prod->qty * $prod->price_buy;
                }
                //dd($total_debt);
                $debt = new Debt();
                $no_surat = $debt->generateNomorSurat();
                $debt->create([
                    'no' => $no_surat,
                    'date' => Carbon::now(),
                    'process_id' => $process_id,
                    'principle_id' => $process->principle_id,
                    'payable_account_id' => $request->get('payable_account_id'),
                    'cogs_account_id' => $request->get('cogs_account_id'),
                    'total_debt' => $total_debt,
                    'status' => '0',
                    'description' => $process->description,
                ]);

                $payable = new JurnalEntry();
                $payable->date = Carbon::now();
                $payable->description = 'Transaksi dari Generate Debt';
                $payable->chart_of_account_id = $request->get('payable_account_id');
                $payable->name = 'Hutang ke Principle '.$process->principle->name.' berdasarkan Nomor '.$process->no.' dan '.$no_surat; 
                $payable->is_generated = 1; 
                $payable->debit = 0; 
                $payable->credit = $total_debt;
                $payable->save();

                $cogs = new JurnalEntry();
                $cogs->date = Carbon::now();
                $cogs->description = 'Transaksi dari Generate Debt';
                $cogs->chart_of_account_id = $request->get('cogs_account_id');
                $cogs->name = 'Beban Pokok Penjualan berdasarkan Nomor '.$process->no.' dan '.$no_surat; 
                $cogs->debit = $total_debt; 
                $cogs->credit = 0;
                $cogs->is_generated = 1;
                $cogs->save();

                return redirect()->route('debt.index')
                        ->with('success', 'Generate Debt, Jurnal (Hutang / Payable, Beban Penjualan) for Process Order '.$process->no.' successfully.');
            }else{
                return redirect()->route('purchase.show', $id)
                    ->with('error', 'Error Generate Debt for Process Order '.$process->no.', Debt telah dibuat atau Pastikan Process Order yang telah selesai di proses sepenuhnya.');
            }
            return redirect()->route('purchase.show', $id)
                ->with('success', 'Generate Debt for Process Order '.$process->no.' successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat debt process order, error: ' . $e->getMessage());
        }
    }

}
