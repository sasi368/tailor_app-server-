<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Models\AddBranch;
use App\Http\Resources\Branch as BranchResource;
use Validator;

class BranchController extends Controller
{
      public function add_branches(Request $request) 
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'branch_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['status'] = 1;
        $add_branch = AddBranch::create($input);
        
        if($add_branch){
            return response()->json([
                "result" => $add_branch,
                "message" => 'Branch Created Successfully',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }

//show images

    public function show_branches() 
    {
        //get retrive all product records

        $branch_list = AddBranch::all(); 
         
        if($branch_list){
            return response()->json([
                "result" => $branch_list,
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }
    }

    public function sendError($message) {
        $message = $message->all();
        $response['error'] = "validation_error";
        $response['message'] = implode('',$message);
        $response['status'] = "0";
        return response()->json($response, 200);
    } 
}
