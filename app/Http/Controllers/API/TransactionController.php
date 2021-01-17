<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MidtransController;
use App\Helpers\Api; 
use App\Models\Transaction;
use Exception;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filteredBy = [];
        $limit = $request->input('limit', 5);

        $foodId = $request->input('food_id');
        $status = $request->input('status');

        $transaction = Transaction::with(['user', 'food'])
            ->where('user_id', $request->user()->id);

        if($foodId) {
            $transaction->where('food_id', $foodId);
            $filteredBy['food_id'] = $foodId;
        }
        if($status) {
            $transaction->where('status', $status);
            $filteredBy['status'] = $status;
        }


        return Api::response(200, 'transaction loaded', [
            "transactions" => $transaction->paginate($limit),
            "filtered_by" => $filteredBy,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required',
            'total' => 'required',
        ]);

        if($user->id != $request->user_id){
            return Api::response(401, 'you\'re not allowed to create transaction using this user');
        }

        try {
            DB::beginTransaction();
            
            $transaction = Transaction::create([
                'food_id' => $request->food_id,
                'user_id' => $user->id,
                'quantity' => $request->quantity,
                'total' => $request->total,
                'payment_url' => ''
            ]);
    
            $midtransService = new MidtransController();
            $midtransService->setTransactionPayload($transaction, $user);
            
            $paymentUrl = $midtransService->createSnapTransaction();

            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            DB::commit();
        } catch (Exception $th) {
            DB::rollBack();
            return Api::response(500, 'transaction failed: '.$th->getMessage()); 
        }

        return Api::response(200, 'transaction created', $transaction); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'food'])
            ->where('id', $id)    
            ->first();

        if(empty($transaction)){
            return Api::response(404, 'transaction with id '.$id.' can\'t be found');
        }
        if(Auth::user()->id != $transaction->user_id){
            return Api::response(401, 'you\'re not allowed to load this transaction');
        }
        
        return Api::response(200, 'transaction loaded', $transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $allowedStatus = [
            Transaction::STATUS_PENDING, 
            Transaction::STATUS_ON_DELIVERY, 
            Transaction::STATUS_DELIVERED,
            Transaction::STATUS_CANCELLED 
        ];

        $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', $allowedStatus)]
        ]);
        
        $transaction = Transaction::with(['user', 'food'])->where('id', $id)->first();
        if(empty($transaction)){
            return Api::response(404, 'transaction with id '.$id.' can\'t be found');
        }
        if(Auth::user()->id != $transaction->user_id){
            return Api::response(401, 'you\'re not allowed to load this transaction');
        }

        $transaction->status = $request->status;
        $transaction->save();

        return Api::response(200, 'transaction status updated', $transaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
