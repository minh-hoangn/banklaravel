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

    public function resetAccount()
    {
        $this->accountService->reset();
        return redirect('/balance');

    }
    public function getBalance(Request $request)
    {
        $result = $this->accountService->getBalance($request->account_id);
        if($result) {
            return view('welcome')->with('result',$result);
        } else {
            return redirect('/balance');
        }
    }

    public function createAccountBalance(StoreAccountRequest  $request)
    {
        $result = $this->accountService->createAccountBalance($request);

            return redirect('/balance');

    }

}
