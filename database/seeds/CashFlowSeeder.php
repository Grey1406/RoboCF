<?php

use Illuminate\Database\Seeder;
use App\CashFlow;

class CashFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashFlow::CreateNewCashFlow(2,1,200,\Carbon\Carbon::now());
        CashFlow::ApproveWaiting(\Carbon\Carbon::now()->addHour());
        CashFlow::CreateNewCashFlow(5,1,2000,\Carbon\Carbon::now()->addMinutes(2));
    }
}
