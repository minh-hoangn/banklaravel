<?php

namespace App\Http\Services;
use App\Models\Account;

class AccountService
{
    /**Reset data table accounts */
    public function reset()
    {
        return Account::truncate();
    }

    /**Lấy thông tin account và số dư */
    public function getBalance($accountId)
    {
        return Account::when(!empty($accountId), function($sql) use ($accountId) {
            return $sql->where('id', $accountId);
        })->paginate(5);
    }
    /**Tạo account với số dư, nộp tiền, rút tiền, chuyển tiền */
    public function createAccountBalance($request)
    {
        if($request->type == "deposit") {
            $account = $this->depositTransaction($request);
            return $account;
        }
        if($request->type == "withdraw") {
            $account = $this->withdrawTransaction($request);
            return $account;
        }
        if($request->type == "transfer") {
            $account = $this->transferTransaction($request);
            return $account;
        }
    }

    /**Tạo account và số dư nếu chưa tồn tại hoặc nộp thêm số dư nếu tồn tại account*/
    private function depositTransaction($request) {
        if($request->destination) {
            $accountDestination = Account::find($request->destination);
            $accountDestination->balance += $request->amount;
            $accountDestination->save();
            return [
                'type'=>'destination',
                'data'=>$accountDestination
            ];
        } else {
            $accountDestination = new Account;
            $accountDestination->id = $request->destination;
            $accountDestination->balance = $request->amount;
            $accountDestination->save();
            return [
            'type'=>'destination',
            'data'=>$accountDestination
            ];
        }
    }

    /**Rút tiền*/
    private function withdrawTransaction($request) {
        $accountOrigin = Account::find($request->origin);
        if($request->amount && $accountOrigin->balance >= $request->amount) {
            $accountOrigin->balance -= $request->amount;
            $accountOrigin->save();
            return [
                'type'=>'origin',
                'data'=>$accountOrigin
            ];
        } else {
            return null;
        }
    }

    /**Chuyển tiền*/
    private function transferTransaction($request) {
        $accountDestination = Account::find($request->destination);
        $accountOrigin = Account::find($request->origin);
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
            ];
        } else {
            return null;
        }
    }
}
