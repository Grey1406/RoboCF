<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CashFlow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function show()
    {
        $customers = Customer::GetAllCustomers();

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
            'amount' => "required|numeric|min:1|max:".Customer::GetCustomerBalance($request->sender),
            'datetime' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput($request->input())
                ->withErrors($validator);
        }

        $planedDate=Carbon::createFromFormat('Y-m-d\Th:i',$request->datetime);
        CashFlow::CreateNewCashFlow($request->sender,$request->receiver,$request->amount,$planedDate);

        return redirect('/');
    }
}