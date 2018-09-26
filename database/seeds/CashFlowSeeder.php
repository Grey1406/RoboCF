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
        CashFlow::createNewCashFlow(2,1,200,\Carbon\Carbon::now());
        CashFlow::approveWaiting(\Carbon\Carbon::now()->addHour());
        CashFlow::createNewCashFlow(5,1,2000,\Carbon\Carbon::now()->addMinutes(2));
    }
}
