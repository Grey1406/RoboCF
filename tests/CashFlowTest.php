<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use App\CashFlow;
use Carbon\Carbon;

class CashFlowTest extends TestCase
{
    use DatabaseTransactions;

    public function testTest()
    {
        $this->assertTrue(true);
    }

    public function testWelcomeRoute()
    {
        $this->visit('/welcome')
            ->see('Laravel');
    }

    public function testCreateNewCustomer()
    {
        Customer::createNewCustomer('test1', 1000);
        $this->seeInDatabase('Customers', ['name' => 'test1']);
    }

    public function testGetCustomerBalance()
    {
        $cus = Customer::createNewCustomer('test1', 1000);
        $this->assertEquals($cus->balance, 1000);
    }

    public function testChangeCustomerBalance()
    {
        $cus = Customer::createNewCustomer('test1', 1000);
        Customer::changeBalance($cus->id, 1277);
        $this->seeInDatabase('Customers', ['id' => $cus->id, 'balance' => 2277]);
    }
    public function testCreateNewCashFlow()
    {
        $cus1 = Customer::createNewCustomer('test1', 1000);
        $cus2 = Customer::createNewCustomer('test2', 1000);
        $cashFlow=CashFlow::createNewCashFlow($cus1->id,$cus2->id,100,Carbon::now());
        $this->seeInDatabase('CashFlows', ['id' => $cashFlow->id,'status'=>'waiting']);
    }
    public function testApproveWaiting()
    {
        $cus1 = Customer::createNewCustomer('test1', 1000);
        $cus2 = Customer::createNewCustomer('test2', 1000);
        $cashFlow=CashFlow::createNewCashFlow($cus1->id,$cus2->id,100,Carbon::now());
        CashFlow::approveWaiting(Carbon::now()->addDay());
        $this->seeInDatabase('CashFlows', ['id' => $cashFlow->id,'status'=>'approved']);
    }

}
