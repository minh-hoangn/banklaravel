<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\SearchRequest;
class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**Reset data table accounts */
    /**
     * @return Illuminate\Support\Facades\Response
     */
    public function resetAccount()
    {
        $this->accountService->reset();
        return redirect()->back();
    }

    /**Get data account return view */
    /**
     * @param Request $request
     *
     * @return Illuminate\Support\Facades\View
     */
    public function getBalance(SearchRequest $request)
    {
        $result = $this->accountService->getBalance($request->value, $request->filter);
        if($result) {
            return view('welcome')->with('result',$result);
        }
        return view('welcome');
    }

    /**Tạo account, nộp tiền, rút tiền, chuyển tiền */
    /**
     * @param StoreAccountRequest $request
     *
     * @return Illuminate\Support\Facades\Response
     */
    public function createAccountBalance(StoreAccountRequest $request)
    {
        $result = $this->accountService->createAccountBalance($request);
        if($result['status'] == 'OK') {
            return redirect()->back()->with(['dataSuccess' => $result['message']]);
        }
        return redirect()->back()->withErrors(['message' => $result['message']]);
    }
}
