<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    protected $table = 'Customers';
    public $timestamps = false;

    public static function createNewCustomer($name, $balance = 0)
    {
        //Создание нового кастомера
        $Customer = new Customer;
        $Customer->name = $name;
        $Customer->balance = $balance;
        $Customer->create = Carbon::now();
        $Customer->save();
        return $Customer;
    }


    public static function getAllCustomers()
    {

        $Customer = DB::select("select
                              cus.id,
                              cus.name,
                              cus.balance 
                              - IFNULL(
                                  (
                                  SELECT SUM(cf.amount)
                                    FROM CashFlows AS cf
                                    WHERE cf.id_sender = cus.id
                                  ),
                              0)
                              + IFNULL(
                                  (
                                  SELECT SUM(cf.amount)
                                    FROM CashFlows AS cf
                                    WHERE cf.id_receiver = cus.id
                                    AND cf.status='approved'
                                  ),
                              0)
                              AS `balance`,
                              (
                                SELECT CONCAT(
                                    'Отправитель ', cf.id_sender,
                                    ' получатель ', cf.id_receiver,
                                    ' статус ', cf.status,
                                    ' сумма ', cf.amount,
                                    ' создано ', cf.create,
                                    ' изменено ', IFNULL(cf.changed,'null'),
                                    ' запланировано ', cf.approved
                                )
                                FROM CashFlows AS cf
                                WHERE cf.id_sender = cus.id
                                ORDER BY cf.id DESC
                                LIMIT 1
                              ) AS LastTransaction
                              from Customers AS cus");


        return $Customer;
    }

    public static function getCustomerBalance($id)
    {
        $balance = $Customer = Customer::where('id', $id)
            ->first()->balance;
        $cashFlows = CashFlow::getCustomerCashFlow($id);
        foreach ($cashFlows as $cashFlow) {
            if ($cashFlow->id_sender == $id) {
                $balance -= $cashFlow->amount;
            } elseif ($cashFlow->status == CashFlow::$STATUS_APPROVED) {
                $balance += $cashFlow->amount;
            }
        }
        return $balance;
    }

    public static function changeBalance($id, $amount)
    {
        $Customer = Customer::where('id', $id)
            ->first();
        $Customer->balance = $Customer->balance + $amount;
        $Customer->save();
    }
}
