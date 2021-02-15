<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Notifications\UserRegister;
use App\PasswordReset as AppPasswordReset;
use App\Role;
use App\User;
use App\UserDetail;
use App\userDetails;
use Carbon\Carbon;
use Validator;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserApiController extends Controller
{
    public $successStatus = 200;
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $ud=User::findOrFail($user->id)->userDetails;
            $cartItem=User::findOrFail($user->id)->cartData;
            $uObj=new CartApiController;
            $cartd=$uObj->show($user->id);
            $obj=new OrderApiController;
            $ph=$obj->show($user->id);
            return response()->json(['user_address' => isset($ud)?$ud:"",
            "total_items_in_cart"=>count($cartItem),
            'cart_data'=>$cartd,
            "purchase_history"=>$ph,
            'token'=> $success['token']
            ,'user'=>$user,
            'profile_pic_url'=>isset($user->profile_pic)?url('').'/'.$user->profile_pic:""
        ], $this->successStatus);
        }else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            $er=[];$i=0;
             foreach($validator->errors() as $err){
                $er[$i++]=$err[0]; 
                return $err;
             }
            return response()->json(["error"=>implode("",$validator->errors()->all()),"status"=>false],403);
        }
        $us=User::where("email",$request->email)->first();
        if(isset($us))
        {
            return ["error"=>"This userid already exist"];
        }else{
            $input = $request->toArray();
            $pass=$input['password'];
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
           // $m=self::sendMessageToUser($user,$pass);
           // Mail::to($user->email)->send(new Signupmail($m));
         return response()->json(['success'=>$success,'status'=>true,'msg'=>""], $this->successStatus);
        }

    }

    function sendMessageToUser(User $user,$pass){
      try{
         $st=Setting::first();
         $sign=['{name}'=>$user->name,
         '{email}'=>$user->email,
         '{password}'=>$pass,
         '{site_url}'=>$st->site_url,
         '{business_name}'=>$st->business_name];
          $msgData=MessageSetting::where('status',trim('signup'))->first();
          $replMsg=MessageSetting::where('status',trim('signup'))->pluck('message')->first();
          foreach($sign as $key => $value){
           $replMsg= str_replace($key,$value,$replMsg);
           }
          return ['fromemail'=>$msgData->from_email,"replyemail"=>$msgData->reply_email,'msg'=>$replMsg,'subject'=>$msgData->subject,'name'=>$msgData->name];
        }catch(Exception $e){

      }
    }
/**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function userDetails(Request $r)
    {
        if(isset($r))
        {
           $user= UserDetail::updateOrCreate(['id'=>$r->id],[
                'address'=>$r->address,
                'address2'=>$r->address2,
                'address_type'=>$r->address_type,
                'state'=>$r->state,
                'city'=>$r->city,
                'country'=>$r->country,
                'zip_code'=>$r->zip_code,
                'landmark'=>$r->landmark,
                'user_id'=>$r->user_id,
            ]);
         return response()->json(["user_detail"=>$user,
                                    'success'=>[
                                    'status'=>true,
                                    'msg'=>"Address saved successfully"]],200);
        }
    }

   public function removeUserDetail($id)
    {
      $ud= UserDetail::findOrFail($id);
      $ud->delete();
      return response()->json("Address Removed",200);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout Successfully',
            'status'  => 1
        ]);
    }

    // Password reset or forget
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message'   => "We can't find a user with that e-mail address.",
                'status'    => false
            ], 404);
        $passwordReset = AppPasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60)
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );

        return response()->json([
            'message' => 'We have e-mailed your password reset link!',
            'url' => 'find/'.$passwordReset->token
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = AppPasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid. expire'
            ], 404);
        }
        $d['passwordReset']=$passwordReset;
        return view("front.reset-password",$d);
       // return response()->json($passwordReset);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function passwordReset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
            'cpassword' => 'required|string|same:password',
            'token' => 'required|string'
        ]);
         if ($validator->fails()) {
             //return $validator->errors()->all();
             session()->flash('error',implode("",$validator->errors()->all()));
             return back();
        }
        $passwordReset = AppPasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
             return back()->with("msg","This password reset token is invalid.");
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
             return back()->with("msg","We can't find a user with that e-mail address.");
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return back()->with("msg","Your password changed successfully");
    }



    // generate OTP 
    public function generateOTP(){
        $otp = mt_rand(1000,9999);
        return $otp;
    }

    // verifyOtp
    public function verifyOtp(Request $request) {
        //
        $otp = trim($request->otp);
        $user_id = $request->user_id;
        
        /* DB::table('user_otp')
            ->where('user_id', '=', $user_id)
            ->where('otp', '=', $otp)
            ->first(); */

        $user = User::where('id', $user_id)
                    ->where('otp',$otp)
                    ->first();

        if (!$user) {
            return response()->json([
                'message'   =>  'This activation token is invalid.',
                'status'    => false,
            ], 404);
        }
        //return $user;

        $user->isVerified = true;
        $user->otp = null;
        $user->save();

        return response()->json([
            'message'   =>  'Your Otp is verified.',
            'status'    => true,
        ], 200);

        return $user;
    }
    public function changeAccount(Request $r)
    {
       $user=User::findOrFail($r->id);
       $user->name=$r->name;
       $user->phone=$r->phone;
        if($r->password!="" && $r->new_password!="")
        {
           // $checkPass=User::where('id',trim($r->id))->where('password',bcrypt(trim($r->password)))->get();
           // return $checkPass;
            if (!Hash::check($r['password'], $user->password)) {
                return response()->json('Sorry your current password does not match our record',404);
           }else{
                $user->password=bcrypt($r->new_password);
           }
        }
        $user->update();
        return response()->json(['success'=>["status"=>true,"msg"=>"Account detail changed successfully"],"user"=>$user], 200);
    }
    public function getUserDetail($id)
    {
        $ud=User::findOrFail($id)->userDetails;
        return response()->json(['user'=>$ud]);
    }
    public function newsletter(Request $r)
    {

      $chmp=Chimp::where("status",1)->first();
      config(['newsletter.apiKey'=>$chmp->mailchimp_api,
      'newsletter.lists.subscribers.id'=>$chmp->audience_id
      ]);

      if(!Newsletter::isSubscribed($r->email)){
          Newsletter::subscribePending($r->email);
          return response()->json(['success'=>['status'=>true,'msg'=>"Thank's for subscribe"]]);
      }else{
          return response()->json(['error'=>['status'=>false,'msg'=>"You have already subscribed"]]);
      }

    }
    
    public function getAccountDetail($id)
    {
        $ud=User::findOrFail($id);
        return response()->json(['user'=>$ud]);
    }
public function uploadProfilePicture(Request $r)
    {
       $validator = Validator::make($r->all(), [
           'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
       ]);

       if ($validator->fails()) {
           return response()->json([$validator->errors(), 'error'], 500);
       }
      $us=User::findOrFail($r->id);
      if($r->has('image')){
       $us->profile_pic=$r->file('image')->move('user/profile',$r->file('image')->getClientOriginalName());
       $us->update();
       if(Storage::exists(url('').'/'.$us->profile_pic)){
           Storage::delete(url('').'/'.$us->profile_pic);
       }
       return response()->json(['success'
              =>['msg'=>"Image uploaded",'status'=>true],
              'pic'=>url('').'/'.$us->profile_pic],200);
      }else{
          return response()->json(['error'=>"Something wrong","status"=>true],400);
      }
    }
  
}
