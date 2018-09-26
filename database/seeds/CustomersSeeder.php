<?php

use Illuminate\Database\Seeder;
use App\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayName=['Sam','Nik','Joe','Serg','Bred'];
        $arrayBalance=[0,1000,2000,5000,4000];
        for ($i=0; $i<5; $i++) {
            Customer::createNewCustomer($arrayName[$i], $arrayBalance[$i]);
        }
    }
}
