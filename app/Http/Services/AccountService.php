<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class AccountService
{
    public function reset()
    {
        return Account::truncate();
    }

    public function getBalance($accountId)
    {
        // $rs = DB::table('accounts')->Simplepaginate(2);
        // dd($rs);

        // $accounts = Account::get();
        // dd($accounts);
        return Account::when(!empty($accountId), function($sql) use ($accountId) {
            return $sql->where('id', $accountId);
        })->paginate(4);



        // // dd($accounts->getCollection());
        // if($accountId) {

        //     $accounts ->where('id', $accountId);
        //     return $accounts;
        // } else {
        //     return $accounts;
        // }
    }

    public function createAccountBalance($request)
    {
        $accountDestination = Account::find($request->destination);
        $accountOrigin = Account::find($request->origin);
        if($accountDestination || $accountOrigin) {
            if($request->type == "deposit") {
                if($request->amount) {
                    $accountDestination->balance += $request->amount;
                    $accountDestination->save();
                    return [
                        'type'=>'destination',
                        'data'=>$accountDestination
                    ];
                }
            } elseif ($request->type == "withdraw") {
                if($request->amount && $accountOrigin->balance >= $request->amount) {
                    $accountOrigin->balance -= $request->amount;
                    $accountOrigin->save();
                    return [
                        'type'=>'origin',
                        'data'=>$accountOrigin
                    ];
                }
            } elseif ($request->type == "transfer") {
                if(($accountDestination && $accountOrigin) && $accountOrigin->balance >= $request->amount) {
                    $accountOrigin->balance -= $request->amount;
                    $accountDestination->balance += $request->amount;
                    $accountOrigin->save();
                    $accountDestination->save();
                    return [
                        [
                            'type'=>'origin',
                            'data'=>$accountOrigin
                        ],[
                            'type'=>'destination',
                            'data'=>$accountDestination
                        ]
                    ];//{"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}
                }
             }
        } else {
            if($request->type == "deposit") {
               $accountDestination = new Account;
               $accountDestination->id = $request->destination;
               $accountDestination->balance = $request->amount;
               $accountDestination->save();
               return [
                'type'=>'destination',
                'data'=>$accountDestination
                ];
            } elseif ($request->type == "withdraw") {
                return null;
            } elseif ($request->type == "transfer") {
                return response(0, 404);
            }
        }



    }
}
