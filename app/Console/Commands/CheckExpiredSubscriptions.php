<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek dan mengubah status subscription tenant yang sudah melewati batas waktu menjadi expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCompanies = Company::where('subscription_status', 'active')
            ->where('subscription_expired_at', '<=', now())
            ->get();

        $count = 0;
        foreach ($expiredCompanies as $company) {
            $company->update(['subscription_status' => 'expired']);
            $count++;
            $this->info("Perusahaan [{$company->company_code}] {$company->company_name} diatur menjadi expired.");
        }

        $this->info("Pengecekan selesai. Total {$count} perusahaan di-expired-kan.");
    }
}
