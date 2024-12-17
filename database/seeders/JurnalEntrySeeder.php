<?php

namespace Database\Seeders;

use App\Models\COA;
use App\Models\JurnalEntry;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JurnalEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataTransaksi = 
        [
            // Proyek A - Januari
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-01-15',
                'description' => 'Penjualan barang untuk Proyek A',
                'debit' => 15000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-01-15',
                'description' => 'Pendapatan dari Proyek A',
                'debit' => 0,
                'credit' => 15000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-01-15',
                'description' => 'Beban pokok penjualan untuk Proyek A',
                'debit' => 12000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-01-15',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek A',
                'debit' => 0,
                'credit' => 12000000,
            ],
            [
                'no_code' => '50.200.001', // Beban Logistik: PT Logistic 1
                'date' => '2023-01-15',
                'description' => 'Biaya logistik untuk Proyek A',
                'debit' => 1000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Kas/Bank BCA
                'date' => '2023-01-15',
                'description' => 'Pembayaran logistik untuk Proyek A',
                'debit' => 0,
                'credit' => 1000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-01-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek A',
                'debit' => 12000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-01-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek A',
                'debit' => 0,
                'credit' => 12000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-01-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek A',
                'debit' => 15000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-01-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek A',
                'debit' => 0,
                'credit' => 15000000,
            ],

            // Proyek B - Februari
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-02-10',
                'description' => 'Penjualan barang untuk Proyek B',
                'debit' => 20000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-02-10',
                'description' => 'Pendapatan dari Proyek B',
                'debit' => 0,
                'credit' => 20000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-02-10',
                'description' => 'Beban pokok penjualan untuk Proyek B',
                'debit' => 18000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-02-10',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek B',
                'debit' => 0,
                'credit' => 18000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-02-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek B',
                'debit' => 18000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-02-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek B',
                'debit' => 0,
                'credit' => 18000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-02-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek B',
                'debit' => 20000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-02-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek B',
                'debit' => 0,
                'credit' => 20000000,
            ],

            // Proyek C - Maret
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-03-05',
                'description' => 'Penjualan barang untuk Proyek C',
                'debit' => 25000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-03-05',
                'description' => 'Pendapatan dari Proyek C',
                'debit' => 0,
                'credit' => 25000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-03-05',
                'description' => 'Beban pokok penjualan untuk Proyek C',
                'debit' => 21000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-03-05',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek C',
                'debit' => 0,
                'credit' => 21000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-03-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek C',
                'debit' => 21000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-03-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek C',
                'debit' => 0,
                'credit' => 21000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-03-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek C',
                'debit' => 25000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-03-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek C',
                'debit' => 0,
                'credit' => 25000000,
            ],

            // Proyek D - April
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-04-12',
                'description' => 'Penjualan barang untuk Proyek D',
                'debit' => 18000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-04-12',
                'description' => 'Pendapatan dari Proyek D',
                'debit' => 0,
                'credit' => 18000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-04-12',
                'description' => 'Beban pokok penjualan untuk Proyek D',
                'debit' => 15000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-04-12',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek D',
                'debit' => 0,
                'credit' => 15000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-04-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek D',
                'debit' => 15000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-04-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek D',
                'debit' => 0,
                'credit' => 15000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-04-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek D',
                'debit' => 18000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-04-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek D',
                'debit' => 0,
                'credit' => 18000000,
            ],
            // Proyek E - Mei
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-05-15',
                'description' => 'Penjualan barang untuk Proyek E',
                'debit' => 22000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-05-15',
                'description' => 'Pendapatan dari Proyek E',
                'debit' => 0,
                'credit' => 22000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-05-15',
                'description' => 'Beban pokok penjualan untuk Proyek E',
                'debit' => 19000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-05-15',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek E',
                'debit' => 0,
                'credit' => 19000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-05-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek E',
                'debit' => 19000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-05-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek E',
                'debit' => 0,
                'credit' => 19000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-05-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek E',
                'debit' => 22000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-05-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek E',
                'debit' => 0,
                'credit' => 22000000,
            ],

            // Proyek F - Juni
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-06-10',
                'description' => 'Penjualan barang untuk Proyek F',
                'debit' => 24000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-06-10',
                'description' => 'Pendapatan dari Proyek F',
                'debit' => 0,
                'credit' => 24000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-06-10',
                'description' => 'Beban pokok penjualan untuk Proyek F',
                'debit' => 20000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-06-10',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek F',
                'debit' => 0,
                'credit' => 20000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-06-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek F',
                'debit' => 20000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-06-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek F',
                'debit' => 0,
                'credit' => 20000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-06-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek F',
                'debit' => 24000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-06-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek F',
                'debit' => 0,
                'credit' => 24000000,
            ],

            // Proyek G - Juli
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-07-10',
                'description' => 'Penjualan barang untuk Proyek G',
                'debit' => 46000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-07-10',
                'description' => 'Pendapatan dari Proyek G',
                'debit' => 0,
                'credit' => 46000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-07-10',
                'description' => 'Beban pokok penjualan untuk Proyek G',
                'debit' => 32000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-07-10',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek G',
                'debit' => 0,
                'credit' => 32000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-07-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek G',
                'debit' => 32000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-07-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek G',
                'debit' => 0,
                'credit' => 32000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-07-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek G',
                'debit' => 46000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-07-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek G',
                'debit' => 0,
                'credit' => 46000000,
            ],

            // Proyek H - Agustus
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-08-05',
                'description' => 'Penjualan barang untuk Proyek H',
                'debit' => 25000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-08-05',
                'description' => 'Pendapatan dari Proyek H',
                'debit' => 0,
                'credit' => 25000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-08-05',
                'description' => 'Beban pokok penjualan untuk Proyek H',
                'debit' => 21000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-08-05',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek H',
                'debit' => 0,
                'credit' => 21000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-08-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek H',
                'debit' => 21000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-08-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek H',
                'debit' => 0,
                'credit' => 21000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-08-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek H',
                'debit' => 25000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-08-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek H',
                'debit' => 0,
                'credit' => 25000000,
            ],

            // Proyek I - September
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-09-12',
                'description' => 'Penjualan barang untuk Proyek I',
                'debit' => 18000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-09-12',
                'description' => 'Pendapatan dari Proyek I',
                'debit' => 0,
                'credit' => 18000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-09-12',
                'description' => 'Beban pokok penjualan untuk Proyek I',
                'debit' => 15000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-09-12',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek I',
                'debit' => 0,
                'credit' => 15000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-09-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek I',
                'debit' => 15000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-09-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek I',
                'debit' => 0,
                'credit' => 15000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-09-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek I',
                'debit' => 18000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-09-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek I',
                'debit' => 0,
                'credit' => 18000000,
            ],

            // Proyek J - Oktober
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-10-15',
                'description' => 'Penjualan barang untuk Proyek J',
                'debit' => 22000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-10-15',
                'description' => 'Pendapatan dari Proyek J',
                'debit' => 0,
                'credit' => 22000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-10-15',
                'description' => 'Beban pokok penjualan untuk Proyek J',
                'debit' => 19000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-10-15',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek J',
                'debit' => 0,
                'credit' => 19000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-10-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek J',
                'debit' => 19000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-10-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek J',
                'debit' => 0,
                'credit' => 19000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-10-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek J',
                'debit' => 22000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-10-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek J',
                'debit' => 0,
                'credit' => 22000000,
            ],

            // Proyek K - November
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-11-10',
                'description' => 'Penjualan barang untuk Proyek K',
                'debit' => 24000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-11-10',
                'description' => 'Pendapatan dari Proyek K',
                'debit' => 0,
                'credit' => 24000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-11-10',
                'description' => 'Beban pokok penjualan untuk Proyek K',
                'debit' => 20000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-11-10',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek K',
                'debit' => 0,
                'credit' => 20000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-11-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek K',
                'debit' => 20000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-11-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek K',
                'debit' => 0,
                'credit' => 20000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-11-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek K',
                'debit' => 24000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-11-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek K',
                'debit' => 0,
                'credit' => 24000000,
            ],

            // Proyek L - Desember
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-12-30',
                'description' => 'Penjualan barang untuk Proyek L',
                'debit' => 46000000,
                'credit' => 0,
            ],
            [
                'no_code' => '40.100.001', // Pendapatan Penjualan: PT Client 1
                'date' => '2023-12-30',
                'description' => 'Pendapatan dari Proyek L',
                'debit' => 0,
                'credit' => 46000000,
            ],
            [
                'no_code' => '50.100.001', // Beban Pokok Penjualan: PT Principle 1
                'date' => '2023-12-30',
                'description' => 'Beban pokok penjualan untuk Proyek L',
                'debit' => 32000000,
                'credit' => 0,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-12-30',
                'description' => 'Hutang ke PT Principle 1 untuk Proyek L',
                'debit' => 0,
                'credit' => 32000000,
            ],
            [
                'no_code' => '21.100.001', // Hutang Usaha: PT Principle 1
                'date' => '2023-12-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek L',
                'debit' => 32000000,
                'credit' => 0,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-12-20',
                'description' => 'Pembayaran hutang ke PT Principle 1 untuk Proyek L',
                'debit' => 0,
                'credit' => 32000000,
            ],
            [
                'no_code' => '12.200.001', // Bank BCA
                'date' => '2023-12-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek L',
                'debit' => 46000000,
                'credit' => 0,
            ],
            [
                'no_code' => '11.100.001', // Piutang: PT Client 1
                'date' => '2023-12-25',
                'description' => 'Penerimaan pembayaran dari PT Client 1 untuk Proyek L',
                'debit' => 0,
                'credit' => 46000000,
            ],

            //-------------
            // Akumulasi Penyusutan untuk Peralatan
            [
                'no_code' => '13.100.001', // Akumulasi Penyusutan: Peralatan
                'date' => '2023-12-01',
                'description' => 'Penyusutan Peralatan Kantor',
                'debit' => 0,
                'credit' => 5000000,
            ],

            // Akumulasi Penyusutan untuk Kendaraan
            [
                'no_code' => '13.100.002', // Akumulasi Penyusutan: Kendaraan
                'date' => '2023-12-01',
                'description' => 'Penyusutan Kendaraan',
                'debit' => 0,
                'credit' => 3000000,
            ],

            // Penyesuaian Saldo Awal
            [
                'no_code' => '31.100.001', // Penyesuaian Saldo Awal
                'date' => '2023-12-01',
                'description' => 'Penyesuaian saldo awal',
                'debit' => 1000000,
                'credit' => 0,
            ],

            // ---------------
            // Beban Gaji (Employee Expense)
            [
                'no_code' => '50.300.001', // Beban Gaji
                'date' => '2023-12-10',
                'description' => 'Beban gaji',
                'debit' => 8000000,
                'credit' => 0,
            ],

            // Beban Sewa (Rent Expense)
            [
                'no_code' => '50.300.002', // Beban Sewa
                'date' => '2023-12-12',
                'description' => 'Beban sewa kantor',
                'debit' => 4000000,
                'credit' => 0,
            ],

            // Beban Utilitas (Utilities Expense)
            [
                'no_code' => '50.300.003', // Beban Utilitas
                'date' => '2023-12-15',
                'description' => 'Beban listrik dan air',
                'debit' => 1200000,
                'credit' => 0,
            ],

            // --------------
            // Beban Penyusutan untuk Peralatan
            [
                'no_code' => '51.100.001', // Beban Penyusutan: Peralatan
                'date' => '2023-12-01',
                'description' => 'Penyusutan Peralatan Kantor',
                'debit' => 2000000,
                'credit' => 0,
            ],

            // Beban Penyusutan untuk Kendaraan
            [
                'no_code' => '51.100.002', // Beban Penyusutan: Kendaraan
                'date' => '2023-12-01',
                'description' => 'Penyusutan Kendaraan',
                'debit' => 1500000,
                'credit' => 0,
            ],


        ];


        $now = Carbon::now();
        foreach ($dataTransaksi as $trx) {
            JurnalEntry::create([
                'chart_of_account_id' => COA::where('no_code', $trx['no_code'])->first()->id,
                'date' => $trx['date'],
                'description' => $trx['description'],
                'name' => $trx['description'],
                'debit' => $trx['debit'],
                'credit' => $trx['credit'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

    }
}
