<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function resetAccount()
    {
        $reset =  $this->accountService->reset();

        if($reset){
            $message = "OK";
            return response($message, 200);
        } else {
            $message = 0;
            return response($message, 404);
        }
    }

    public function getBalance(Request $request)
    {
        $result = $this->accountService->getBalance((int)$request->account_id);
        if($result) {
            $message = $result->balance;
            return response($message, 200);
        } else {
            $message = 0;
            return response($message, 404);
        }
    }

    public function createAccountBalance(Request $request)
    {


        $result = $this->accountService->createAccountBalance($request);
        if($result) {
            $account = $result['data'] ?? [];
            $type = $result['type'] ?? '';
            $accountTransferOrigin = $result[0] ?? [];
            $accountTransferDestination = $result[1] ?? [];


            if( $type == 'destination'){
                $message = [
                    'destination' => [
                        'id'=>$account->id,
                        'balance'=>$account->balance
                        ]
                    ];
                return response($message, 201);
                //201 {"destination": {"id":"100", "balance":10}}
            } elseif( $type == 'origin'){
                $message = [
                    'origin' => [
                        'id'=>$account->id,
                        'balance'=>$account->balance
                        ]
                    ];
                return response($message, 201);
                //201 {"origin": {"id":"100", "balance":15}}
            } elseif( $request->type == 'transfer'){
                $message = [
                    'origin' => [
                        'id'=>$accountTransferOrigin['data']->id,
                        'balance'=>$accountTransferOrigin['data']->balance,
                    ],
                    'destination' => [
                        'id'=> $accountTransferDestination['data']->id,
                        'balance'=> $accountTransferDestination['data']->balance,
                    ]
                ];
                return response($message, 201);
                //201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}
            }
            else {
                return response(0, 404);
            }
        } else {
            return response(0, 404);
        }
    }

}
