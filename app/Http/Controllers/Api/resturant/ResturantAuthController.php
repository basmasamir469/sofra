<?php

namespace App\Http\Controllers\Api\resturant;

use App\Models\Token;
use App\Models\Client;
use App\Models\Resturant;
use App\traits\ImageTrait;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResturantAuthController extends Controller
{
    //
    use ImageTrait;

    public function register(Request $request){
     $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|unique:clients',
        'password'=>'required|confirmed',
        'phone'=>'required',
        'district_id'=>'required',
        'delivery_cost'=>'required',
        'minimum_order'=>'required',
        'image'=>'required',
        'contact_phone'=>'required',
        'status'=>'required'
     ]);
     if($validator->fails()){
        return responseJson(0,$validator->errors()->first(),$validator->errors());
          }
          $resturant=Resturant::create(
        [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'phone'=>$request->phone,
            'district_id'=>$request->district_id,
            'delivery_cost'=>$request->delivery_cost,
            'minimum_order'=>$request->minimum_order,
            'image'=>$this->saveImage($request->image,'images/resturants'),
            'contact_phone'=>$request->contact_phone,
            'status'=>$request->status
    
        ]
     );
     if($resturant){
     return responseJson(1,' resturant stored successfully',
     [
        'resturant'=>$resturant,
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
        $resturant=Resturant::where('email',$request->email)->first();
        if($resturant){
            if(Hash::check($request->password, $resturant->password)){
                return responseJson(1,' login successfully',
                [
                   'resturant'=>$resturant,
                   'token' => $resturant->createToken("API TOKEN")->plainTextToken
           
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
        $resturant=Resturant::where('email',$request->email)->first();
        if($resturant){
        $resturant->pin_code=rand(1111,9999);
        if($resturant->save()){
            Mail::to($resturant->email)
            ->bcc('basmaelazony@gmail.com')
            ->send(new ResetPassword($resturant));
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
        $resturant=Resturant::where('pin_code',$request->pin_code)->first();
        if($resturant){
            $resturant->password=bcrypt($request->password);
            $resturant->pin_code=null;
            if($resturant->save()){
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
    public function updateResturant(Request $request){
        $resturant=auth('api-resturants')->user();

       if($request->isMethod('get')){
          return responseJson(1,'your resturant',$resturant);    
       }
      else if($request->isMethod('post')){
      $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|unique:resturants,email,'.$request->user()->id,
        'password'=>'required|confirmed',
        'phone'=>'required',
        'district_id'=>'required',
        'delivery_cost'=>'required',
        'minimum_order'=>'required',
        'image'=>'required',
        'contact_phone'=>'required',
        'status'=>'required'
       ]);
       if($validator->fails()){
          return responseJson(0,$validator->errors()->first(),$validator->errors());
       }
       $resturant->update(
        [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'phone'=>$request->phone,
            'district_id'=>$request->district_id,
            'delivery_cost'=>$request->delivery_cost,
            'minimum_order'=>$request->minimum_order,
            'image'=>$this->saveImage($request->image,'images/resturants'),
            'contact_phone'=>$request->contact_phone,
            'status'=>$request->status

        ]
       );
       if($resturant){
       return responseJson(1,' updated successfully',$resturant);
  }
  else{
      return responseJson(0,'faild to update');
  }
  
  

  }
}
public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return responseJson(1,'you logged out successfully');
}


public function registerToken(Request $request){
    $validator=validator()->make($request->all(),[
        'token'=>'required',
        'type'=>'required|in:ios,android'
   ]);
   if($validator->fails()){
       return responseJson(0,$validator->errors()->first(),$validator->errors());
   }
   Token::where('token',$request->token)->delete();
   $request->user()->tokenss()->create($request->all());
   return responseJson(1,'registered successfully',$request->user()->tokens);


}


}
