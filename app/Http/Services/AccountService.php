<?php

namespace App\Http\Services;
use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\DB;

class AccountService
{
    /**Reset data table accounts */
    /**
     * @return object
     */
    public function reset()
    {
        return Account::truncate();
    }

    /**Lấy thông tin account và số dư */
    /**
     * @param int $accountId
     *
     * @return object
     */
    public function getBalance($accountId)
    {
        return Account::when(!empty($accountId), function($sql) use ($accountId) {
            return $sql->where('id', $accountId);
        })
        ->simplePaginate(5);
    }
    /**Tạo account với số dư, nộp tiền, rút tiền, chuyển tiền */
    /**
     * @param StoreAccountRequest $request
     *
     * @return array $account
     */
    public function createAccountBalance($request)
    {
        if($request->type == "deposit") {
            $account = $this->depositTransaction($request);
        }
        if($request->type == "withdraw") {
            $account = $this->withdrawTransaction($request);
        }
        if($request->type == "transfer") {
            $account = $this->transferTransaction($request);
        }
        return $account;
    }

    /**Tạo account và số dư nếu chưa tồn tại hoặc nộp thêm số dư nếu tồn tại account*/
    /**
     * @param StoreAccountRequest $request
     *
     * @return array message
     */
    private function depositTransaction($request)
    {
        if(empty($request->destination)) {
            $account = $this->createAccount($request);
            if ($account) {
                $status = 'OK';
                $message = 'Tạo tài khoản thành công';
            } else {
                $status = 'OK';
                $message = 'Tạo tài khoản thành công';
            }
        } else {
            $accountDestination = Account::find($request->destination);
            if($accountDestination){
                $this->depositAccount($request, $accountDestination);
                $status = 'OK';
                $message = 'Nộp tiền thành công';
            } else {
                $status = 'FAIL';
                $message = 'Destination chưa tồn tại';
            }
        }
        return [
            'status' => $status,
            'message'=> $message
        ];
    }

    /**Rút tiền*/
    /**
     * @param StoreAccountRequest $request
     *
     * @return array $message
     */
    private function withdrawTransaction($request) {
        $accountOrigin = Account::find($request->origin);
        if($accountOrigin) {
            if($request->amount && $accountOrigin->balance >= $request->amount) {
                $this->withdrawAccount($request, $accountOrigin);
                $status = 'OK';
                $message = 'Rút tiền tiền thành công';
            } else {
                $status = 'FAIL';
                $message = 'Số tiền phải lớn hơn 0 và nhỏ hơn số dư hiện tại!';
            }
        } else {
            $status = 'FAIL';
            $message = 'Origin không tồn tại';
        }
        return [
            'status' => $status,
            'message'=> $message
        ];
    }

    /**Chuyển tiền*/
    /**
     * @param StoreAccountRequest $request
     *
     * @return array $message
     */
    private function transferTransaction($request) {
        $accountOrigin = Account::find($request->origin);
        $accountDestination = Account::find($request->destination);
        if(($accountDestination && $accountOrigin) && $accountOrigin->balance >= $request->amount) {
            $isSuccess = $this->transferAccount($request, $accountOrigin, $accountDestination);
            if($isSuccess) {
                $status = 'OK';
                $message = 'Transaction chuyển tiền OK';
            } else {
                $status = 'FAIL';
                $message = 'Transaction chuyển tiền FAIL';
            }
        } else {
            $status = 'FAIL';
            $message = 'Chuyển tiền thất bại';
        }
        return [
            'status' => $status,
            'message'=> $message
        ];
    }

    /**Tạo mới account và số dư
     * @param StoreAccountRequest $request
     *
     * @return void
     */
    private function createAccount($request)  {
        return  Account::create([
            'balance' => $request->amount ?? 0
        ]);
    }
    /**Nộp tiền cho account
     * @param StoreAccountRequest $request
     * @param Object $accountDestination
     *
     * @return void
     */
    private function depositAccount($request, $accountDestination)  {
        return $accountDestination->update([
            'balance' => $accountDestination->balance + ($request->amount ?? 0)
        ]);
    }
    /**Rút tiền cho account
     * @param StoreAccountRequest $request
     * @param Object $accountOrigin
     *
     * @return void
     */
    private function withdrawAccount($request, $accountOrigin)  {
        $accountOrigin->balance -= $request->amount;
        $accountOrigin->save();
    }
    /**Chuyển tiền từ accountOrigin cho accountDestination
     * @param StoreAccountRequest $request
     * @param Object $accountOrigin
     * @param Object $accountDestination
     *
     * @return boolean
     */
    private function transferAccount($request, $accountOrigin, $accountDestination)  {
        DB::beginTransaction();
        try {
            $accountOrigin->balance -= $request->amount;
            $accountOrigin->save();
            $accountDestination->balance += $request->amount;
            $accountDestination->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
