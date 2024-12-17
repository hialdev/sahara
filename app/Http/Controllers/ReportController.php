<?php

namespace App\Http\Controllers;

use App\Models\COA;
use App\Models\JurnalEntry;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Fungsi untuk menampilkan Neraca (Balance Sheet)
    public function balance(Request $request)
    {
        $assets = $this->getCategoryBalance('asset', $request->start_date, $request->end_date);
        $liabilities = $this->getCategoryBalance('liability', $request->start_date, $request->end_date);
        $equity = $this->getCategoryBalance('equity', $request->start_date, $request->end_date);
        //dd($assets, $liabilities, $equity);
        return view('accounting.reports.balance', compact('assets', 'liabilities', 'equity'));
    }

    public function balancePrint(Request $request)
    {
        $assets = $this->getCategoryBalance('asset', $request->start_date, $request->end_date);
        $liabilities = $this->getCategoryBalance('liability', $request->start_date, $request->end_date);
        $equity = $this->getCategoryBalance('equity', $request->start_date, $request->end_date);
        //dd($assets, $liabilities, $equity);
        return view('accounting.reports.print.balance', compact('assets', 'liabilities', 'equity'));
    }

    public function balanceDownload(Request $request){
        $getSet = Setting::all()->keyBy('the_key');
        $assets = $this->getCategoryBalance('asset', $request->start_date, $request->end_date);
        $liabilities = $this->getCategoryBalance('liability', $request->start_date, $request->end_date);
        $equity = $this->getCategoryBalance('equity', $request->start_date, $request->end_date);
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('accounting.reports.pdf.balance', [
            'title' => 'Laporan Neraca (Balance Sheet)',
            'assets' => $assets,
            'liabilities' => $liabilities,
            'equity' => $equity,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('Laporan Neraca (Balance Sheet) - ' . ($request->get('start_date') ?? 'awal') . 'hingga '. ($request->get('end_date') ?? now()) .'.pdf');
    }

    // Fungsi untuk menampilkan Laba Rugi (Income Statement)
    public function incomeStatement(Request $request)
    {
        $revenue = $this->getCategoryBalance('revenue', $request->start_date, $request->end_date);
        $expense = $this->getCategoryBalance('expense', $request->start_date, $request->end_date);
        $netIncome = $revenue['total_credit'] - $expense['total_debit'];

        return view('accounting.reports.income-statement', compact('revenue', 'expense', 'netIncome'));
    }
    public function incomeStatementPrint(Request $request)
    {
        $revenue = $this->getCategoryBalance('revenue', $request->start_date, $request->end_date);
        $expense = $this->getCategoryBalance('expense', $request->start_date, $request->end_date);
        $netIncome = $revenue['total_credit'] - $expense['total_debit'];

        return view('accounting.reports.print.income-statement', compact('revenue', 'expense', 'netIncome'));
    }
    public function incomeStatementDownload(Request $request)
    {
        $revenue = $this->getCategoryBalance('revenue', $request->start_date, $request->end_date);
        $expense = $this->getCategoryBalance('expense', $request->start_date, $request->end_date);
        $netIncome = $revenue['total_credit'] - $expense['total_debit'];

        $getSet = Setting::all()->keyBy('the_key');
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('accounting.reports.pdf.income-statement', [
            'title' => 'Laporan Arus Kas (Cash Flow Statement)',
            'revenue' => $revenue,
            'expense' => $expense,
            'netIncome' => $netIncome,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('Laporan Arus Kas (Cash Flow Statement) - ' . ($request->get('start_date') ?? 'awal') . 'hingga '. ($request->get('end_date') ?? now()) .'.pdf');
    }

    public function cashFlow(Request $request)
    {
        // Cash inflow: Total Debit dari Cash & Bank
        $cashInflow = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '12%'); // Cash & Bank
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->sum('debit');

        // Cash outflow: Total Credit dari Cash & Bank
        $cashOutflow = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '12%'); // Cash & Bank
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->sum('credit');

        $netCashFlow = $cashInflow - $cashOutflow;

        return view('accounting.reports.cash-flow', compact('cashInflow', 'cashOutflow', 'netCashFlow'));
    }
    public function cashFlowPrint(Request $request)
    {
        // Cash inflow: Total Debit dari Cash & Bank
        $cashInflow = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '12%'); // Cash & Bank
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->sum('debit');

        // Cash outflow: Total Credit dari Cash & Bank
        $cashOutflow = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '12%'); // Cash & Bank
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->sum('credit');

        $netCashFlow = $cashInflow - $cashOutflow;

        return view('accounting.reports.print.cash-flow', compact('cashInflow', 'cashOutflow', 'netCashFlow'));
    }

    public function cashFlowDownload(Request $request)
    {
        // Cash inflow: Total Debit dari Cash & Bank
        $cashInflow = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '12%'); // Cash & Bank
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->sum('debit');

        // Cash outflow: Total Credit dari Cash & Bank
        $cashOutflow = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '12%'); // Cash & Bank
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->sum('credit');

        $netCashFlow = $cashInflow - $cashOutflow;
        
        $getSet = Setting::all()->keyBy('the_key');
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('accounting.reports.pdf.cash-flow', [
            'title' => 'Laporan Arus Kas (Cash Flow Statement)',
            'cashInflow' => $cashInflow,
            'cashOutflow' => $cashOutflow,
            'netCashFlow' => $netCashFlow,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('Laporan Arus Kas (Cash Flow Statement) - ' . ($request->get('start_date') ?? 'awal') . 'hingga '. ($request->get('end_date') ?? now()) .'.pdf');
    }

    public function generalLedger(Request $request)
    {
        $accounts = JurnalEntry::with('account')
                    ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
                    ->orderBy('date')->get()->groupBy('account.no_code');

        return view('accounting.reports.general-ledger', compact('accounts'));
    }
    public function generalLedgerPrint(Request $request)
    {
        $accounts = JurnalEntry::with('account')
                    ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
                    ->orderBy('date')->get()->groupBy('account.no_code');

        return view('accounting.reports.print.general-ledger', compact('accounts'));
    }
    public function generalLedgerDownload(Request $request)
    {
        $accounts = JurnalEntry::with('account')
                    ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
                    ->orderBy('date')->get()->groupBy('account.no_code');

        $getSet = Setting::all()->keyBy('the_key');
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('accounting.reports.pdf.general-ledger', [
            'title' => 'Laporan Buku Besar (General Ledger)',
            'accounts' => $accounts,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('Laporan Buku Besar (General Ledger) - ' . ($request->get('start_date') ?? 'awal') . 'hingga '. ($request->get('end_date') ?? now()) .'.pdf');
    }

    public function changesInEquity(Request $request)
    {
        // Akun terkait ekuitas: Laba Ditahan, Modal Pemilik, Dividen, dan Penyesuaian Saldo Awal
        $equityAccounts = COA::where('no_code', 'LIKE', '30.100%')->orWhere('no_code', 'LIKE', '30.200%')->orWhere('no_code', 'LIKE', '30.300%')->orWhere('no_code', 'LIKE', '31.100%')->orderBy('no_code')->get();
        $equityChanges = [];

        foreach ($equityAccounts as $account) {
            // Mengambil jurnal terkait akun ekuitas dalam rentang tanggal
            $jurnalEntries = JurnalEntry::where('chart_of_account_id', $account->id)
                ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
                ->get();

            // Hitung total debit dan kredit untuk akun ini
            $debit = $jurnalEntries->sum('debit');
            $credit = $jurnalEntries->sum('credit');

            // Hitung perubahan ekuitas untuk akun ini
            $equityChanges[] = [
                'account_name' => $account->account_name,
                'account_code' => $account->no_code,
                'debit' => $debit,
                'credit' => $credit,
                'net_change' => $credit - $debit,
            ];
        }
        //dd($equityChanges);

        // Hitung total perubahan ekuitas
        $totalEquityChange = array_reduce($equityChanges, function ($carry, $item) {
            return $carry + $item['net_change'];
        }, 0);

        // Kembalikan data perubahan ekuitas
        return view('accounting.reports.changes-in-equity', compact(
            'equityChanges',
            'totalEquityChange',
        ));
    }
    public function changesInEquityPrint(Request $request)
    {
        // Akun terkait ekuitas: Laba Ditahan, Modal Pemilik, Dividen, dan Penyesuaian Saldo Awal
        $equityAccounts = COA::where('no_code', 'LIKE', '30.100%')->orWhere('no_code', 'LIKE', '30.200%')->orWhere('no_code', 'LIKE', '30.300%')->orWhere('no_code', 'LIKE', '31.100%')->orderBy('no_code')->get();
        $equityChanges = [];

        foreach ($equityAccounts as $account) {
            // Mengambil jurnal terkait akun ekuitas dalam rentang tanggal
            $jurnalEntries = JurnalEntry::where('chart_of_account_id', $account->id)
                ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
                ->get();

            // Hitung total debit dan kredit untuk akun ini
            $debit = $jurnalEntries->sum('debit');
            $credit = $jurnalEntries->sum('credit');

            // Hitung perubahan ekuitas untuk akun ini
            $equityChanges[] = [
                'account_name' => $account->account_name,
                'account_code' => $account->no_code,
                'debit' => $debit,
                'credit' => $credit,
                'net_change' => $credit - $debit,
            ];
        }
        //dd($equityChanges);

        // Hitung total perubahan ekuitas
        $totalEquityChange = array_reduce($equityChanges, function ($carry, $item) {
            return $carry + $item['net_change'];
        }, 0);

        // Kembalikan data perubahan ekuitas
        return view('accounting.reports.print.changes-in-equity', compact(
            'equityChanges',
            'totalEquityChange',
        ));
    }

    public function changesInEquityDownload(Request $request)
    {
        // Akun terkait ekuitas: Laba Ditahan, Modal Pemilik, Dividen, dan Penyesuaian Saldo Awal
        $equityAccounts = COA::where('no_code', 'LIKE', '30.100%')->orWhere('no_code', 'LIKE', '30.200%')->orWhere('no_code', 'LIKE', '30.300%')->orWhere('no_code', 'LIKE', '31.100%')->orderBy('no_code')->get();
        $equityChanges = [];

        foreach ($equityAccounts as $account) {
            // Mengambil jurnal terkait akun ekuitas dalam rentang tanggal
            $jurnalEntries = JurnalEntry::where('chart_of_account_id', $account->id)
                ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
                ->get();

            // Hitung total debit dan kredit untuk akun ini
            $debit = $jurnalEntries->sum('debit');
            $credit = $jurnalEntries->sum('credit');

            // Hitung perubahan ekuitas untuk akun ini
            $equityChanges[] = [
                'account_name' => $account->account_name,
                'account_code' => $account->no_code,
                'debit' => $debit,
                'credit' => $credit,
                'net_change' => $credit - $debit,
            ];
        }
        //dd($equityChanges);

        // Hitung total perubahan ekuitas
        $totalEquityChange = array_reduce($equityChanges, function ($carry, $item) {
            return $carry + $item['net_change'];
        }, 0);

        
        $getSet = Setting::all()->keyBy('the_key');
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('accounting.reports.pdf.changes-in-equity', [
            'title' => 'Laporan Perubahan Ekuitas (Statement of Changes in Equity)',
            'equityChanges' => $equityChanges,
            'totalEquityChange' => $totalEquityChange,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('Laporan Perubahan Ekuitas (Statement of Changes in Equity) - ' . ($request->get('start_date') ?? 'awal') . 'hingga '. ($request->get('end_date') ?? now()) .'.pdf');
    }

    public function accountsReceivableAndPayable(Request $request)
    {
        // Piutang
        $receivables = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '11%'); // Piutang
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->orderBy('date')->get();

        // Hutang
        $payables = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '21%'); // Hutang
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->orderBy('date')->get();

        return view('accounting.reports.accounts-receivable-payable', compact('receivables', 'payables'));
    }

    public function accountsReceivableAndPayablePrint(Request $request)
    {
        // Piutang
        $receivables = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '11%'); // Piutang
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->orderBy('date')->get();

        // Hutang
        $payables = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '21%'); // Hutang
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->orderBy('date')->get();

        return view('accounting.reports.print.accounts-receivable-payable', compact('receivables', 'payables'));
    }

    public function accountsReceivableAndPayableDownload(Request $request)
    {
        // Piutang
        $receivables = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '11%'); // Piutang
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->orderBy('date')->get();

        // Hutang
        $payables = JurnalEntry::whereHas('account', function ($query) {
            $query->where('no_code', 'like', '21%'); // Hutang
        })
        ->whereBetween('date', [$request->start_date ?? '2000-01-01', $request->end_date ?? now()])
        ->orderBy('date')->get();

        $getSet = Setting::all()->keyBy('the_key');
        $kop_image = env('SSO_URL').'/storage/'.$getSet->get('a4_cover')->the_value;

        // Render PDF
        $pdf = Pdf::setOptions([
            'defaultFont' => 'serif',
            'isRemoteEnabled'=> true,
        ])->loadView('accounting.reports.pdf.accounts-receivable-payable', [
            'title' => 'Laporan Hutang Piutang',
            'receivables' => $receivables,
            'payables' => $payables,
            'kop_image' => $kop_image,
        ]);

        return $pdf->download('Laporan Hutang Piutang - ' . ($request->get('start_date') ?? 'awal') . 'hingga '. ($request->get('end_date') ?? now()) .'.pdf');
    }

    private function getCategoryBalance($type, $start_date = null, $end_date = null)
    {
        $entries = JurnalEntry::whereHas('account.accountType', function ($query) use ($type) {
            $query->where('type', $type);
        })
        ->whereBetween('date', [$start_date ?? '2000-01-01', $end_date ?? now()])
        ->orderBy('date')->get();

        $totalDebit = $entries->sum('debit');
        $totalCredit = $entries->sum('credit');
        $balance = $totalDebit - $totalCredit;

        return [
            'entries' => $entries,
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
            'balance' => $balance,
        ];
    }
}
