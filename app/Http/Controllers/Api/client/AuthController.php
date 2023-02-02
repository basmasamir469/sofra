<?php

namespace App\Http\Controllers\Api\client;

use App\Models\Token;
use App\Models\Client;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request){
     $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|unique:clients',
        'password'=>'required|confirmed',
        'phone'=>'required',
        'district_id'=>'required'
     ]);
     if($validator->fails()){
        return responseJson(0,$validator->errors()->first(),$validator->errors());
     }
     $request['password']=bcrypt($request->password);
     $client=Client::create($request->all());
     if($client){
     return responseJson(1,' registered successfully',
     [
        'client'=>$client,
        'token' => $client->createToken("API TOKEN")->plainTextToken

    ]);
}
else{
    return responseJson(0,'faild to register');
}

    }

    public function login(Request $request){
        $validator=validator()->make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
         return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $client=Client::where('email',$request->email)->first();
        if($client){
            if(Hash::check($request->password, $client->password)){
                return responseJson(1,' login successfully',
                [
                   'client'=>$client,
                   'token' => $client->createToken("API TOKEN")->plainTextToken
           
               ]);        
            }
            else{
                return responseJson(0,'faild to login password does not match');
            }
        }
        else{
            return responseJson(0,'faild to login email does not match');
        }

    }
    public function resetPassword(Request $request){
        $validator=validator()->make($request->all(),[
            'email'=>'required|email'
        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $client=Client::where('email',$request->email)->first();
        if($client){
        $client->pin_code=rand(1111,9999);
        if($client->save()){
            Mail::to($client->email)
            ->bcc('basmaelazony@gmail.com')
            ->send(new ResetPassword($client));
            return responseJson(1,'check your email');
        }
        else{
            return responseJson(0,'something error is happened please try again');
        }

        
        }
        else{
            return responseJson(0,'error! email not found ');
        }

    }
    public function newPassword(Request $request){
        $validator=validator()->make($request->all(),[
            'pin_code'=>'required',
            'password'=>'required|confirmed|min:8'
        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $client=Client::where('pin_code',$request->pin_code)->first();
        if($client){
            $client->password=bcrypt($request->password);
            $client->pin_code=null;
            if($client->save()){
                return responseJson(1,'password updated successfully');

            }
            else{
                return responseJson(0,'error faild to update password please try again');

            }

        }
        else{
            return responseJson(0,' error! pin code is invalid');

        }


    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return responseJson(1,'you logged out successfully');
    }
    public function updateProfile(Request $request){
          $client=auth('api-clients')->user();

         if($request->isMethod('get')){
            return responseJson(1,'your profile',$client);    
         }
        else if($request->isMethod('post')){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:clients,email,'.$request->user()->id,
            'password'=>'required|confirmed',
            'phone'=>'required',
            'district_id'=>'required'
         ]);
         if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
         }
         $request['password']=bcrypt($request->password);
         $client->update($request->all());
         if($client){
         return responseJson(1,' updated successfully',$client);
    }
    else{
        return responseJson(0,'faild to update');
    }
    
    

    }
}
}
