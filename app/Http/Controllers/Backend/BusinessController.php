<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Validator;

class BusinessController extends BaseController
{
    public function index(){

        $business = Business::whereStatus(1)->get();

        return $this->ResponseSuccess(BusinessResource::collection($business)->response()->getData(true));
    }

    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'image' => 'nullable',
            'balance' => 'required',
            'address' => 'required',
            'discount_percentage' => 'required',
            'allow_negative' => 'required',
            'status' => '',
        ]);

        if ($validator->fails()) {
            return $this->ResponseError($validator->errors(),'Invalid data.', 422);
        }

        $qrCodeContent = [
            "Business Info: " . $request->input('name'),
            ];
        $qrCodeFilename = uniqid('qr_code_') . '.svg';
        $qrCodePath = 'public/qrcodes/' . $qrCodeFilename;
        //$qrCodePath = 'public/qrcodes/' . uniqid('qr_code_') . '.svg';

        $code = QrCode::size(300)->generate($qrCodeContent);

        Storage::disk('local')->put($qrCodePath, $code);

        if($request->input('id')){
            $business = Business::find($request->input('id'));
        }else{
            $business = new Business();
        }

        $business->name = $request->input('name');
        $business->user_id = $request->input('user_id');
        $business->qr_code = $qrCodeFilename;
        $business->address = $request->input('address');
        $business->image = $request->input('image');
        $business->balance = $request->input('balance');
        $business->discount_percentage = $request->input('discount_percentage');
        $business->allow_negative = $request->input('allow_negative');
        $business->status = $request->input('status');

        $business->save();

        return $this->ResponseSuccess(new BusinessResource($business), '', 'Business added successfully!');
    }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();

        return $this->ResponseSuccess(new BusinessResource($business), '', 'Business deleted successfully!');
    }

    public function restore($id){
        $business = Business::withTrashed()->findOrFail($id);
        $business->restore();

        return $this->ResponseSuccess(new BusinessResource($business), '', 'Business restored successfully!');
    }

    public function show()
    {
//        return QrCode::generate(
//            'Hello, World!',
//        );

        return response()->streamDownload(
            function () {
                echo QrCode::size(200)
                    ->generate('https://harrk.dev');
            },
            'qr-code.svg',
            [
                'Content-Type' => 'image/svg',
            ]
        );
    }
}
