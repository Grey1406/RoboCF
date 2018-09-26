<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Customer extends Model
{
    protected $table = 'Customers';
    public $timestamps = false;

    static public function CreateNewCustomer($name, $balance = 0)
    {
        //Создание нового кастомера
        $Customer = new Customer;
        $Customer->name = $name;
        $Customer->balance = $balance;
        $Customer->create = Carbon::now();
        $Customer->save();
        return $Customer;
    }

//* * * * * php /home/sergey/RoboCf make laravel-approve >> /dev/null 2>&1

    static public function GetAllCustomers()
    {
//        CashFlow::ApproveWaiting(Carbon::now());

        $Customer = DB::select("select
                              cus.id,
                              cus.name,
                              cus.balance - IFNULL(
                                                      (
                                                      SELECT SUM(cf.amount)
                                                        FROM CashFlows AS cf
                                                        WHERE cf.id_sender = cus.id
                                                        AND cf.status='waiting'
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

    static public function GetCustomerBalance($id)
    {
        $balance = $Customer = Customer::where('id', $id)
            ->first()->balance;
        $cashFlows = CashFlow::GetCustomerCashFlow($id);
        foreach ($cashFlows as $cashFlow) {
            if ($cashFlow->status == CashFlow::$STATUS_WAITING) {
                $balance -= $cashFlow->amount;
            }
        }
        return $balance;
    }

    static public function ChangeBalance($id, $amount)
    {
        $Customer = Customer::where('id', $id)
            ->first();
        $Customer->balance = $Customer->balance + $amount;
        $Customer->save();
    }
}
