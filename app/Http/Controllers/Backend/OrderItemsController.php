<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\OrderItemsResource;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Validator;

class OrderItemsController extends BaseController
{
    public function index(){
        $orderItems = OrderItems::whereStatus(1)->get();

        return $this->ResponseSuccess(OrderItemsResource::collection($orderItems)->response()->getData(true));
    }

    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'price' => 'required',
            'unit' => ['required', 'in:piece,kg'],
            'order_id' => 'required',
            'product_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        if($request->input('id')){
            $orderItem = OrderItems::find($request->input('id'));
        }else{
            $orderItem = new OrderItems();
        }

        $orderItem->price = $request->input('price');
        $orderItem->unit = $request->input('unit');
        $orderItem->order_id = $request->input('order_id');
        $orderItem->product_id = $request->input('product_id');
        $orderItem->status = $request->input('status');

        $orderItem->save();

        return $this->ResponseSuccess(new OrderItemsResource($orderItem), '', 'Order Item added successfully!');
    }

    public function destroy($id){
        $orderItem = OrderItems::findorFail($id);
        $orderItem->delete();

        return $this->ResponseSuccess(new OrderItemsResource($orderItem), 'Order Item deleted successfully.', 200);
    }

    public function restore($id){
        $orderItem = OrderItems::withTrashed()->findOrFail($id);
        $orderItem->restore();

        return $this->ResponseSuccess(new OrderItemsResource($orderItem), '', 'Order Item restored successfully!');
    }
}
