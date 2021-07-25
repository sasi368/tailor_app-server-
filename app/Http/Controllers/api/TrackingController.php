<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Tracking;
use App\Http\Resources\Tracking as TrackingResource;

use Validator;

class TrackingController extends Controller
{
    //add tracking
      public function add_tracking(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [ 
            'order_id' => 'required',
            'customer_name' => 'required',
            'service_name' => 'required',
            'employee_name' => 'required', 
            'position' => 'required',      
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['status'] = 1;
        $details = Tracking::create($input);
        
        if($details){
            return response()->json([
                "result" => $details,
                "message" => 'Tracking Added',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }


//show tracking status by customer_name, service_name,employee_name
  public function show_tracking_position(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'customer_name' => 'required',
            'service_name' => 'required',
            'employee_name' => 'required',    
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Tracking::where('customer_name', $request->customer_name)->where('service_name', $request->service_name)->where('employee_name', $request->employee_name)->get();
      
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


    //show all tracking 
    public function show_all_status() 
    {
        //get retrive all product records

        $sales = Tracking::all(); 
          $result = Tracking::where('position', '=', 5)->get();
         
        if($sales){
            return response()->json([
                "result" => $sales,
                "count" =>count($result),
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }
    }


    public function update_tracking_position(Request $request)
    { 
        $input = $request->all();
    
        $validator = Validator::make($input, [ 
            'position' => 'required',
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['status'] = 1;

        $data = Tracking::find($request->order_id);
        $data->position = $request->position;
        $data->save();

        if($data){
            return response()->json([
                "result" => $data,
                "message" => 'Tracking Added',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }


    //show tracking status by customer_name, service_name,employee_name
   public function show_order_status(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'order_id' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = Tracking::select('customer_name','service_name','employee_name','position')->where('order_id', $request->order_id)->get();
       
        if ($result) {
            return response()->json([
                "result" => $result[0],
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

    //error handling
    
    public function sendError($message) {
        $message = $message->all();
        $response['error'] = "validation_error";
        $response['message'] = implode('',$message);
        $response['status'] = "0";
        return response()->json($response, 200);
    } 
}
