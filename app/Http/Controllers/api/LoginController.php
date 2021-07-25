<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Models\Login;
use App\Http\Resources\Login as LoginResource;
use Validator; 

class LoginController extends Controller
{

    //register
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_name' => 'required',
            /*'gender' => 'required',
            'contact_no' => 'required|numeric|digits_between:9,20|unique:logins,contact_no',*/
            'branch' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['status'] = 1;
        $options = [
            'cost' => 12,
        ];
        $input['password'] = password_hash($input["password"], PASSWORD_DEFAULT, $options);
        $emp = Login::create($input);
        
        if($emp){
            return response()->json([
                "result" => $emp,
                "message" => 'Employee Added Successfully',
                "status" => 1
            ]);
        } else {
            return response()->json([
                "message" => 'Sorry, something went wrong !',
                "status" => 0
            ]);
        }

    }
    //login

  /*   public function login(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
            'user_name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $credentials = request(['user_name', 'password']);
        $check_user = Login::where('user_name',$credentials['user_name'])->first();
        $check_password = Login::where('password',$credentials['password'])->first();

        if (!($check_user && $check_password)) {
            return response()->json([
                "message" => 'Invalid user name or password',
                "status" => 0
            ]);
        }
        
        else{
             return response()->json([
                "result" => $check_user,
                "message" => 'Login Successfully',
                "status" => 1
            ]);  
        }
    }*/
    
      public function login(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
            'user_name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $credentials = request(['user_name', 'password']);
        $check_user = Login::where('user_name',$credentials['user_name'])->first();
       // $check_password = Login::where('password',$credentials['password'])->first();
         if (!($check_user)) {
            return response()->json([
                "message" => 'Invalid username or password',
                "status" => 0
            ]);
        }

        if(Hash::check($credentials['password'], $check_user->password)){
            return response()->json([
                "result" => $check_user,
                "message" => 'Login Successfully',
                "status" => 1
            ]);  
        }
        else{
            return response()->json([
                 "message" => 'Invalid password',
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
