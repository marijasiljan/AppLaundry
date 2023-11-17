<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\OrdersResource;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class OrdersController extends BaseController
{
    public function index(){
        $orders = Orders::whereStatus(1)->get();

        return $this->ResponseSuccess(OrdersResource::collection($orders)->response()->getData(true));
    }

    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'date' => 'required|date',
            'total' => 'required',
            'confirmed' => 'required',
            'exchange' => 'required',
            'type' => ['required', 'in:delivery,pickup,self_delivery,self_pickup'],
            'business_id' => 'required',
            'user_id' => 'required',
            'status' => '',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        if($request->input('id')){
            $order = Orders::find($request->input('id'));
        }else{
            $order = new Orders();
        }

        $order->date = $request->input('date');
        $order->total = $request->input('total');
        $order->confirmed = $request->input('confirmed');
        $order->exchange = $request->input('exchange');
        $order->type = $request->input('type');
        $order->business_id = $request->input('business_id');
        $order->user_id = $request->input('user_id');
        $order->status = $request->input('status');



        $order->save();

        return $this->ResponseSuccess(new OrdersResource($order), '', 'Order created successfully!');
    }

    public function destroy($id){
        $order = Orders::findOrFail($id);
        $order->delete();

        return $this->ResponseSuccess(new OrdersResource($order), 'Order deleted successfully', 200);
    }

    public function restore($id){
        $order = Orders::withTrashed()->findOrFail($id);
        $order->restore();

        return $this->ResponseSuccess(new OrdersResource($order), '', 'Order restored successfully!');
    }
}
