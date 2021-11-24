<?php

use App\Http\Controllers\Api\SMSController;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
   


Route::middleware('auth:sanctum')->get('/nibir', function (Request $request) {
    return response()->json([
        'data' => 'Nibir'
    ]);
});

















Route::post('recharge/sms',function(Request $request){

    $validator = Validator::make($request->all(),[
        'amount' => 'required'
    ]);

    if( $validator->fails() ){

        return response()->json([
            'status' => "Failed Validation"
        ],400);

    }else{
        
        $data = $validator->validated();

        $option = Option::where('slug','remaining_sms');

        $previous = $option->first()->value;
        $now = $previous + $data['amount'];

        $result = $option->update([
            'value' => $now
        ]);

        return response()->json([
            'status' => $result
        ]);
    }

})->middleware('auth:sanctum');

    
    
    
    
    



