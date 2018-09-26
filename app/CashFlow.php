<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashFlow extends Model
{

    protected $table = 'CashFlows';
    public $timestamps = false;
    static public $STATUS_WAITING = 'waiting';
    static public $STATUS_APPROVED = 'approved';

    public static function createNewCashFlow($sender, $receiver, $amount, $datetime)
    {
        //Создание новой проводки
        $cashFlow = new CashFlow;
        $cashFlow->id_sender = $sender;
        $cashFlow->id_receiver = $receiver;
        $cashFlow->status = CashFlow::$STATUS_WAITING;
        $cashFlow->amount = $amount;
        $cashFlow->create = Carbon::now();
        $cashFlow->changed = null;
        $cashFlow->approved = $datetime;
        $cashFlow->save();
        return $cashFlow;
    }

    public static function approveWaiting($datetime)
    {
        $cashFlows = CashFlow::where('status', 'waiting')
            ->where('approved', '<', $datetime)
            ->get();
        foreach ($cashFlows as $cashFlow) {
            $cashFlow->status = CashFlow::$STATUS_APPROVED;
            $cashFlow->changed = Carbon::now();
            $cashFlow->save();
        }
    }

    public static function getCustomerCashFlow($id)
    {
        return $cashFlows = CashFlow::where('id_sender', $id)
            ->orWhere('id_receiver', $id)
            ->get();
    }
}
