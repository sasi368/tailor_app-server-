<?php

namespace App\Http\Controllers\api;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests; 
use App\Models\Measurement;
use App\Http\Resources\Measurement as MeasurementResources;

use Validator; 

class MeasurementController extends Controller
{
   //add measurements
    public function add_measurements(Request $request)
    { 
        $input = $request->all();
        $mytime = Carbon::parse($request->date)->format('Y-m-s');
        $validator = Validator::make($input, [ 
            'customer_code' => 'required',
            'customer_name' => 'required',
            'service_name' => 'required',
            'service_price' => 'required',
          /*  'shirt_length' => 'required', 
            'arm_length' => 'required', 
            'shoulder' => 'required',
            'front_neck' => 'required',
            'back_neck' => 'required', 
            'chest' => 'required',
            'arm_hole' => 'required',
            'cuff' => 'required', 
            'hip' => 'required',
            'pant' => 'required', 
            'seat' => 'required',
            'paincha' => 'required',*/
            'branch' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['status'] = 1;
        $input['taken_on'] = Carbon::now();
        $details = Measurement::create($input);
        
        if($details){
            return response()->json([
                "result" => $details,
                "taken_on"=>$mytime,
                "message" => 'Measurements Added',
                "status" => 1
            ]);
        } else {
            return response()->json([ 
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }


    //show measurements


  /*  public function show_measurements() 
    {

        $measurement_list = Measurement::all(); 
        $result = Measurement::where('customer_id', $request->customer_id)->get();

        if($measurement_list){
            return response()->json([
                "result" => $measurement_list,
                "count" => count($measurement_list),
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }
    }
*/
    //show all measurements by customer id

    public function show_measurement_details(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'customer_code' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Measurement::where('customer_code', $request->customer_code)->get();

        if ($result) {
            return response()->json([
                "result" => $result,
                "count" => count($result),
                "message" => 'Success',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong...',
                "status" => 0
            ]);
        }
    }
    
    public function show_measurement_details_by_branch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'branch' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Measurement::where('branch', $request->branch)->get();

        if ($result) {
            return response()->json([
                "result" => $result,
                "count" => count($result),
                "message" => 'Success',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong...',
                "status" => 0
            ]);
        }
    }

//show measurement details by id

//show all measurements by customer id

    public function show_measurement_details_by_id(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Measurement::where('id', $request->id)->get();

        if ($result) {
            return response()->json([
                "result" => $result,
                "count" => count($result),
                "message" => 'Success',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong...',
                "status" => 0
            ]);
        }
    }

    //show by date and branch


      public function show_measurements_by_date(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'taken_on' => 'required', 
            'branch' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Measurement::where('taken_on', $request->taken_on)->where('branch', $request->branch)->get();

        if ($result) {
            return response()->json([
                "result" => $result,
                "count" => count($result),
                "message" => 'Success',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong...',
                "status" => 0
            ]);
        }
    }


    //show by date dummy for select todays date an branch

       public function show_today_by_date(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'taken_on' => 'required',  
            'branch' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Measurement::where('taken_on', $request->taken_on)->where('branch', $request->branch)->get();

        if ($result) {
            return response()->json([
                "result" => $result,
                "count" => count($result),
                "message" => 'Success',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong...',
                "status" => 0
            ]);
        }
    }


      public function show_all_measurements() 
    {
        //get retrive all product records

        $list = Measurement::all(); 
         
        if($list){
            return response()->json([
                "result" => $list,
                "count" => count($list),
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }
    }

//for updating a position


    public function update_measurement_position(Request $request)
    { 
        $input = $request->all();
    
        $validator = Validator::make($input, [ 
            'position' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['status'] = 1;

        $data = Measurement::find($request->id);
        $data->position = $request->position;
        $data->save();

        if($data){
            return response()->json([
                "result" => $data,
                "message" => 'Measurements Added',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }


    //error handling
    
    public function sendError($message) {
        $message = $message->all();
        $response['error'] = "validation_error";
        $response['message'] = implode('',$message);
        $response['status'] = "0";
        return response()->json($response, 200);
    } 
}
