<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;

class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**Reset data table accounts */
    public function resetAccount()
    {
        $this->accountService->reset();
        return redirect('/balance');

    }

    /**Get data account return view */
    public function getBalance(Request $request)
    {
        $result = $this->accountService->getBalance($request->account_id);
        if($result) {
            return view('welcome')->with('result',$result);
        } else {
            return redirect('/balance');
        }
    }

    /**Tạo account, nộp tiền, rút tiền, chuyển tiền */
    public function createAccountBalance(StoreAccountRequest  $request)
    {
        $this->accountService->createAccountBalance($request);
        return redirect('/balance');
    }

}
