<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProductsController extends BaseController
{
    public function index(){
        $products = Products::whereStatus(1)->get();

        return $this->ResponseSuccess(ProductResource::collection($products)->response()->getData(true));
    }

    public function store(Request $request){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'price' => 'required',
            'exchange_price' => 'required',
            'unit' => ['required', 'in:piece,kg'],
            'related_product_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        if($request->input('id')){
            $product = Products::find($request->input('id'));
        }else{
            $product = new Products();
        }

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->exchange_price = $request->input('exchange_price');
        $product->unit = $request->input('unit');
        $product->related_product_id = $request->input('related_product_id');
        $product->status = $request->input('status');

        $product->save();

        return $this->ResponseSuccess(new ProductResource($product), '', 'Product added successfully!');
    }

    public function destroy($id){

        $product = Products::findOrFail($id);
        $product->delete();

        return $this->ResponseSuccess(new ProductResource($product), '', 'Product deleted successfully!');
    }

    public function restore($id){
        $product = ProductResource::withTrashed()->findOrFail($id);
        $product->restore();

        return $this->ResponseSuccess(new ProductResource($product), '', 'Product restored successfully!');
    }
}
