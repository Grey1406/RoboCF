<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;

class CashFlowTest extends TestCase
{
//    use DatabaseTransactions;

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
        Customer::CreateNewCustomer('test1',1000);
        $this->seeInDatabase('Customers', ['name' => 'test1']);
    }
    public function testGetCustomerBalance()
    {
        $cus=Customer::CreateNewCustomer('test1',1000);
        $this->assertEquals($cus->balance,1000);
    }
}
