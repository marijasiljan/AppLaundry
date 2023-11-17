<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\TransactionResource;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Validator;

class TransactionsController extends BaseController
{
    public function index(){
        $transactions = Transactions::whereStatus(1)->get();

        return $this->ResponseSuccess(TransactionResource::collection($transactions)->response()->getData(true));
    }

    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'amount' => 'required',
            'type' => ['required', 'in:cash,invoice'],
            'business_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        if($request->input('id')){
            $transactions = Transactions::find($request->input('id'));
        }else{
            $transactions = new Transactions();
        }

        $transactions->amount = $request->input('amount');
        $transactions->type = $request->input('type');
        $transactions->business_id = $request->input('business_id');
        $transactions->user_id = $request->input('user_id');
        $transactions->status = $request->input('status');


        $transactions->save();

        return $this->ResponseSuccess(new TransactionResource($transactions), '', 'Transaction added successfully!');
    }

    public function destroy($id){
        $transaction = Transactions::findorFail($id);
        $transaction->delete();

        return $this->ResponseSuccess(new TransactionResource($transaction), 'Transaction deleted successfully.', 200);
    }

    public function restore($id){
        $transaction = Transactions::withTrashed()->findOrFail($id);
        $transaction->restore();

        return $this->ResponseSuccess(new TransactionResource($transaction), '', 'Transaction restored successfully!');
    }
}
