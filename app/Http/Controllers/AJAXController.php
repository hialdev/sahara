<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Debt;
use App\Models\DebtProcess;
use App\Models\Invoice;
use App\Models\InvoiceProcess;
use App\Models\Packaging;
use App\Models\Principle;
use App\Models\PrincipleAddress;
use App\Models\ProcessProduct;
use App\Models\ProcessPurchaseOrder;
use App\Models\Product;
use App\Models\PurchaseOrderProduct;
use App\Models\Quotation;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AJAXController extends Controller
{
    // ---------------------------------------
    // ------------- Product -----------------
    // ---------------------------------------
    public function getProducts(){
        $products = Product::all();
        return response()->json($products);
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);
        $response = (object)[
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'id_satuan_barang' => $product->id_satuan_barang,
            'satuan' => $product->satuan->name,
        ];
        return response()->json($response);
    }

    public function getPackagingBySatuan($satuan_id)
    {
        $packagings = Packaging::where('id_satuan_barang', $satuan_id)->get();
        return response()->json($packagings);
    }

    public function storeProduct(Request $request)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'satuan' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Mengambil semua pesan kesalahan menjadi array
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat product baru
            Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'id_satuan_barang' => $request->satuan,
            ]);

            // Berhasil membuat product
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully.'
            ], 200);
            
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan data
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat product.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    // ---------------------------------------
    // ------------- Satuan -----------------
    // ---------------------------------------
    public function getSatuans(){
        $satuans = Satuan::all();
        return response()->json($satuans);
    }
    
    // ---------------------------------------
    // ------------- Satuan -----------------
    // ---------------------------------------
    public function getPackagings(){
        $packagings = Packaging::all();
        return response()->json($packagings);
    }

    // ---------------------------------------
    // ------------- Client -----------------
    // ---------------------------------------
    public function getClients(){
        $clients = Client::all();
        return response()->json($clients);
    }

    public function getClientDetails($id)
    {
        $client = Client::find($id);
        $addresses = $client->addresses->toArray();
        $address = ClientAddress::where('client_id', $client->id)->where('address_tag', 'office')->first();
        $response = (object) [
            "name" => $client->name,
            "npwp" => $client->npwp,
            "email" => $client->email,
            "contact_name" => $client->contact_name,
            "contact_email" => $client->contact_email,
            "contact_phone" => $client->contact_phone,
            "address" => [
                "address" => $address->address,
                "city" => $address->city,
                "postal_code" => $address->postal_code,
            ],
            "addresses" => $addresses,
        ];
        return response()->json($response);
    }

    public function getAddressDetails($id){
        $response = ClientAddress::findOrFail($id);
        return response()->json($response);
    }
    // ---------------------------------------
    // ------------- Principle -----------------
    // ---------------------------------------
    public function getPrinciples(){
        $principles = Principle::all();
        return response()->json($principles);
    }

    public function getPrincipleDetails($id)
    {
        $principle = Principle::find($id);
        $addresses = $principle->addresses->toArray();
        $address = PrincipleAddress::where('principle_id', $principle->id)->where('address_tag', 'office')->first();
        $response = (object) [
            "name" => $principle->name,
            "npwp" => $principle->npwp,
            "email" => $principle->email,
            "contact_name" => $principle->contact_name,
            "contact_email" => $principle->contact_email,
            "contact_phone" => $principle->contact_phone,
            "address" => [
                "address" => $address->address,
                "city" => $address->city,
                "postal_code" => $address->postal_code,
            ],
            "addresses" => $addresses,
        ];
        return response()->json($response);
    }

    public function getPrincipleAddressDetails($id){
        $response = PrincipleAddress::findOrFail($id);
        return response()->json($response);
    }
    // ---------------------------------------
    // ------------- Quotation -----------------
    // ---------------------------------------
    public function getQuotations(){
        $quotations = Quotation::all();
        return response()->json($quotations);
    }
    public function getQuotationDetails($id){
        $quotation = Quotation::findOrFail($id);
        return response()->json($quotation);
    }
    public function getQuotationClient($client_id){
        $quotation = Quotation::where('client_id', $client_id)->get();
        return response()->json($quotation);
    }
    // ---------------------------------------
    // ------------- Purchase -----------------
    // ---------------------------------------
    public function getPurchaseProducts(Request $request) {
        $purchaseId = $request->get('purchaseId');
        $ids = $request->get('ids');
        
        // Pastikan $ids diubah menjadi array jika dikirim sebagai string yang dipisahkan koma
        $idsArray = explode(',', $ids);
        
        // Ambil data PurchaseOrderProduct bersama dengan jumlah qty dari ProcessProduct secara langsung
        $products = PurchaseOrderProduct::withTrashed()->with(['product' => function ($query) {
                                            $query->withTrashed();
                                        }, 'processProducts' => function ($query) {
                                            $query->withTrashed();
                                        }])
            ->where('purchase_order_id', $purchaseId)
            ->whereIn('id', $idsArray)
            ->get();

        //dd($ids, $products, $idsArray, $request->all());
        $productIds = $products->pluck('product_id');

        // Ambil semua data `ProcessProduct` yang memiliki `product_id` sesuai dengan $productIds 
        // dan yang memiliki `purchase_id` yang terkait di `ProcessPurchaseOrder`
        $processProductsData = ProcessProduct::whereHas('processOrder', function($query) use ($purchaseId) {
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
    
        return response()->json($products);
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
     
    public function getProcessDetail($id, $process_id)
    {
        // ------- Data Process Detail ----------- //
        // Mengambil data ProcessPurchaseOrder beserta relasi ProcessProduct dan relasi Product
        $processPurchaseOrder = ProcessPurchaseOrder::with(['getProducts.product'])
            ->find($process_id);
        // Memastikan data ditemukan
        if (!$processPurchaseOrder) {
            return response()->json(['success' => false, 'message' => 'Process not found'], 404);
        }
        $processProducts = $processPurchaseOrder->getProducts;
        $processProductIds = $processProducts->pluck('product_id')->all();
        $processProductsGroupId = $processPurchaseOrder->getProducts->groupBy('product_id');
        // --------------- Mengambil Qty ---------------- //
        // Ambil data PurchaseOrderProduct bersama dengan jumlah qty dari ProcessProduct
        $purchaseProducts = PurchaseOrderProduct::with(['product', 'processProducts'])
            ->where('purchase_order_id', $id)
            ->whereIn('product_id', $processProductIds)
            ->get();

        // Ambil semua data yang diperlukan sekaligus untuk mengurangi query ke database
        $processProductsData = ProcessProduct::whereHas('processOrder', function($query) use ($id) {
                $query->where('purchase_order_id', $id);
            })
            ->whereIn('product_id', $processProductIds)
            ->get()
            ->groupBy('product_id');
        
        // Hitung nilai done_qty, on_process_qty, waiting_qty, dan left_qty untuk setiap produk
        $qtyProducts = $purchaseProducts->map(function ($purchaseProduct) use ($processProductsData, $processProductsGroupId) {
            // Panggil fungsi checkQty untuk menghitung qty terkait
            $qtyData = $this->checkQty($purchaseProduct->product_id, $purchaseProduct->qty, $processProductsData);
            // Jika ada ProcessProduct terkait, iterasi untuk memperbarui waiting_qty berdasarkan kondisi yang diberikan
            if ($processProductsGroupId->has($purchaseProduct->product_id)) {
                foreach ($processProductsGroupId[$purchaseProduct->product_id] as $processProduct) {
                    // Kurangi waiting_qty berdasarkan qty dari setiap ProcessProduct
                    $qtyData['waiting_qty'] -= $processProduct->qty;
                    $qtyData['left_qty'] += $processProduct->qty;
                    $qtyData['edited_qty'] = $processProduct->qty;
                    $purchaseProduct->price_buy = $processProduct->price_buy;
                }
            }

            // Tambahkan data kalkulasi ke dalam hasil
            $purchaseProduct->done_qty = $qtyData['done_qty'];
            $purchaseProduct->on_process_qty = $qtyData['on_process_qty'];
            $purchaseProduct->waiting_qty = $qtyData['waiting_qty'];
            $purchaseProduct->left_qty = $qtyData['left_qty'];
            $purchaseProduct->edited_qty = $qtyData['edited_qty'];
            
            return $purchaseProduct;
        });

        // Mengembalikan hasil akhir
        return response()->json([
            'success' => true,
            'data' => [
                'process' => $processPurchaseOrder,
                'products' => $qtyProducts,
            ],
        ]);
    }


    //----------------------------------------------------------------
    // Invoice
    //----------------------------------------------------------------
    public function getInvoices($id)
    {
        $invoices = Invoice::where('client_id', $id)->get();
        return response()->json($invoices);
    }
    public function getInvoiceDetails($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['success' => false,'message' => 'Invoice not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $invoice]);
    }

    public function getInvoiceProcessDetails($id, $process_id)
    {
        $process = InvoiceProcess::find($process_id);
        if (!$process) {
            return response()->json(['success' => false,'message' => 'Invoice process not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $process]);
    }

    //----------------------------------------------------------------
    // Debt
    //----------------------------------------------------------------
    public function getDebts($id)
    {
        $debts = Debt::where('principle_id', $id)->get();
        return response()->json($debts);
    }
    public function getDebtDetails($id)
    {
        $debt = Debt::find($id);
        if (!$debt) {
            return response()->json(['success' => false,'message' => 'Debt not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $debt]);
    }

    public function getDebtProcessDetails($id, $process_id)
    {
        $process = DebtProcess::find($process_id);
        if (!$process) {
            return response()->json(['success' => false,'message' => 'Debt process not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $process]);
    }
    
}
