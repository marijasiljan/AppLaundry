<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\BusinessStockResource;
use App\Models\BusinessStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class BusinessStockController extends BaseController
{
    public function index(){
        $businessStock = BusinessStock::whereStatus(1)->get();

        return $this->ResponseSuccess(BusinessStockResource::collection($businessStock)->response()->getData(true));
    }

    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'stock' => 'required',
            'business_id' => 'required',
            'product_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        if($request->input('id')){
            $businessStock = BusinessStock::find($request->input('id'));
        }else{
            $businessStock = new BusinessStock();
        }

        $businessStock->stock = $request->input('stock');
        $businessStock->business_id = $request->input('business_id');
        $businessStock->product_id = $request->input('product_id');
        $businessStock->status = $request->input('status');

        $businessStock->save();

        return $this->ResponseSuccess(new BusinessStockResource($businessStock), '', 'Business Stock added successfully!');
    }

    public function destroy($id){
        $businessStock = BusinessStock::findOrFail($id);
        $businessStock->delete();

        return $this->ResponseSuccess(new BusinessStockResource($businessStock), 'Business Stock deleted successfully', 200);
    }

    public function restore($id){
        $businessStock = BusinessStock::withTrashed()->findOrFail($id);
        $businessStock->restore();

        return $this->ResponseSuccess(new BusinessStockResource($businessStock), '', 'Business Stock restored successfully!');
    }
}
