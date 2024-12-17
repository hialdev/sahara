<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ProcessPurchaseOrder;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function dashboard(){
        $ro = PurchaseOrder::count();
        $pop = ProcessPurchaseOrder::count();
        $ong = ProcessPurchaseOrder::where('is_finished', 1)->count();
        $fin = Invoice::count();
        $qt = Quotation::count();

        $comparation = (object)[
            'data' => [0,0,0],
            'categories' => ["Quotation", "PO Client", "Invoice / Piutang", "PO Principle / Hutang"],
            'colors' => ["#ef7831", "#2385e0", "#432d74", "#f4942c"],
        ];
        $comparation->data = [
            $qt,
            $ro,
            $fin, 
            $pop,
        ];

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(29); // This will give us 30 days including today

        $purchaseData = PurchaseOrder::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $dates = [];
        $totals = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $currentDate = $date->format('Y-m-d');
            $dates[] = $currentDate;
            $totals[] = $purchaseData->where('date', $currentDate)->first()->total ?? 0;
        }

        return view('dashboard.index', compact('ro', 'pop', 'ong', 'fin', 'totals', 'dates', 'comparation'));
    }
}
