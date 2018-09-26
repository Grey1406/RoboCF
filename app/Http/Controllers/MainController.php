<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CashFlow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class MainController extends Controller
{

    public function show()
    {
        $customers = Customer::getAllCustomers();

        return view('Customers', [
            'customers' => $customers,
            'date' => \Carbon\Carbon::now()->addMinutes(5)->format('Y-m-d\Th:i')
        ]);
    }

    public function cash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender' => 'required|different:receiver',
            'receiver' => 'required',
            'amount' => "required|numeric|min:1|max:" . Customer::getCustomerBalance($request->sender),
            'datetime' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput($request->input())
                ->withErrors($validator);
        }

        if(!Customer::find($request->sender)){
            Session::flash('message-fail', 'пользователя с id '.$request->sender.' не существует');
            return redirect('/');
        }
        if(!Customer::find($request->receiver)){
            Session::flash('message-fail', 'пользователя с id '.$request->receiver.' не существует');
            return redirect('/');
        }
        
        $errorArray=[];
        try {
            $planedDate = Carbon::createFromFormat('Y-m-d\Th:i', $request->datetime);
            $errorArray[]=$request->sender;
            $errorArray[]=$request->receiver;
            $errorArray[]=$request->amount;
            $errorArray[]=$planedDate;
            CashFlow::createNewCashFlow($request->sender, $request->receiver, $request->amount, $planedDate);
            Session::flash('message-success', 'Success');
            return redirect('/');
        } catch (\Exception $e) {
//          storage/logs
            Log::warning('Произошла ошибка при сохранении проводки :'.json_encode($errorArray));
            Session::flash('message-fail', 'something go wrong :' . $e);
            return redirect('/');
        }
    }
}
