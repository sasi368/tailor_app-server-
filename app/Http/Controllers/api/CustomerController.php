<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\AddCustomer;
use App\Http\Resources\Customer as AddCustomerResource;

use Validator;

class CustomerController extends Controller
{
    public function add_customer(Request $request) 
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'customer_name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'branch' => 'required',
            'contact_no' => 'required|numeric|digits_between:9,20|unique:add_customers,contact_no',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        
        $input['customer_code'] = rand(1000,9999);
        $input['status'] = 1;
        $add_customer = AddCustomer::create($input);
        
        if($add_customer){
            return response()->json([
                "result" => $add_customer,
                "message" => 'Customer Created Successfully',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }


    ///show customers


     public function show_customers() 
    {
        //get retrive all product records

        $customers = AddCustomer::all(); 
        
        if($customers){
            return response()->json([
                "result" => $customers,
                "count" => count($customers),
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }
    }

///show customer detail by id 

    public function show_customer_details(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'customer_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $result = AddCustomer::select('id', 'customer_name', 'gender','email', 'contact_no','address','customer_code','branch')->where('id',$input['customer_id'])->first();
        
        if (is_object($result)) {
         
            return response()->json([
                "result" => $result,
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

//show all Customers by branch name

    public function show_customers_by_branch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'branch' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = AddCustomer::where('branch', $request->branch)->get();

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

//show all Customer by code

    public function show_customers_by_code(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'customer_code' => 'required',       
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

       $result = AddCustomer::where('customer_code', $request->customer_code)->get();

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



 
    //error handlings

     public function sendError($message) {
        $message = $message->all();
        $response['error'] = "validation_error";
        $response['message'] = implode('',$message);
        $response['status'] = "0";
        return response()->json($response, 200);
    } 
}
