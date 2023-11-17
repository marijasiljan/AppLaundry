<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function returnData($status, $message, $values=null, $meta=null,$errors=null,$error=200){
        return response()->json(array(
            'status'    =>$status,
            'message'   =>$message,
            'values'    =>$values,
            'errors'    =>$errors,
            'error'     =>$error,
            'meta'      =>$meta
        ));
    }

    public function ResponseSuccess($data = null, $meta = null, $message = 'Action performed', $code = JsonResponse::HTTP_OK){
        return response()->json([
            'status'=>true,
            'data'=>$data,
            'message'=>$message,
            'meta'=>$meta
        ], $code);
    }

    public function ResponseError($errors=null, $message='Can not perform action', $code = JsonResponse::HTTP_BAD_REQUEST){
        return response()->json([
            'status'=>false,
            'message'=>$message,
            'errors'=>$errors
        ], $code);
    }

    use AuthorizesRequests, ValidatesRequests;
}
