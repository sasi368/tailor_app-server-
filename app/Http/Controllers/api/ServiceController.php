<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Models\Service;
use App\Http\Resources\Service as ServiceResource;
use Validator;

class ServiceController extends Controller
{
    //add services(image uploads)
  public function add_services(Request $request)
    { 
         
       if ($request->has('service_img')) {
            $image = $request->file('service_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/service_images');
            $image->move($destinationPath, $name);

            //save data
            $image=new Service;
            $image->service_name=$request->service_name;
            //new var price
            $image->service_price=$request->service_price;
            $image->service_img=$name;
            $image->save();
            
            return response()->json([
                "result" => 'service_images/'.$name,
                "message" => 'Success',
                "status" => 1
            ]);
            
        }
            else{
                return response()->json([
                    "message" => 'Sorry something went wrong...',
                    "status" => 0
                ]);
            }
        }




//show images

    public function show_services() 
    {
        //get retrive all product records

        $services_list = Service::all(); 
         
        if($services_list){
            return response()->json([
                "result" => $services_list,
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
