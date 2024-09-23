<?php

namespace App\Console\Commands;

use App\Models\ActiveLogin;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanUpActiveLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:active_login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus active login yang lebih dari 7 hari';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ActiveLogin::where('created_at', '<', Carbon::now()->subDays(7))->delete();
        $this->info('Old active logins deleted successfully.');
    }
}
