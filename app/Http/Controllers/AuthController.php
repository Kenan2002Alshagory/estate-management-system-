<?php

namespace App\Http\Controllers;


use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Resources\EstateResource;
use App\Models\Estate;
use App\Models\ForgetPasswordCode;
use App\Models\News;
use App\Models\Order;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Traits\AddPhotoTrait;
use App\Traits\OtplessTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use AddPhotoTrait , OtplessTrait;

    public function signup(SignupRequest $request){
        $data = $request->except('password_confirmation');
        $token = $data['token'];
        unset($data['token']);
        if($this->Otpless($token) != 200){
            return response()->json([
                'message' => 'otpless error'
            ],400);
        }
        $user = User::where('number',$data['number'])->first();
        if($user && $user->verifyAccount == true){
                return response()->json([
                    'message'=>'There are account with this number',
                ],400);
        }else{
            $data['password']=Hash::make($data['password']);

            if($data['type']== 'office'){
                $data['verifyOffice'] = false;
            }
            $user = User::updateOrCreate(['number' => $data['number']],$data);
            $user->verifyAccount = true;
            $user->save();
            $token = $user->createToken('Token')->plainTextToken;
            return response()->json([
                'message'=>'sign up success',
                'token' => $token
            ]);
        }
    }

    public function signin(SigninRequest $request){
        $data = $request->all();
        $user = User::where('number',$data['number'])->first();
        if($user){
            if(Hash::check($data['password'],$user->password)){
                if($user->verifyAccount == true){
                    if($user->block){
                        return response()->json([
                            'message'=>'you are blocked'
                        ],400);
                    }
                    $token = $user->createToken('Token')->plainTextToken;
                    $user->fcm_token= $data['fcm_token'];
                    $user->save();
                    return response()->json([
                        'message'=>'sign in success',
                        'token'=>$token,
                    ]);
                }else{
                    return response()->json([
                        'message'=>'You should verify you account'
                    ],400);
                }
            }else{
                return response()->json([
                    'message' => 'Invalid Credential'
                ],400);
            }
        }else{
            return response()->json([
                'message' => 'Invalid Credential'
            ],400);
        }
    }

    public function verifyAcount(){
        $user = Auth::user();
        $user->verifyAccount = true;
        $user->save();
        return response()->json([
            'message'=>'your account verified'
        ]);
    }

    public function forgetPassword(Request $request){
        $data = $request->all();
        $user = User::where('number',$data['number'])->first();
        if(!$user){
            return response()->json([
                'message' => 'phone number not found'
            ],400);
        }
        return response()->json([
            'message' => 'number is true'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request){
        $data = $request->except('password_confirmation');
        $token = $data['token'];
        unset($data['token']);
        if($this->Otpless($token) != 200){
            return response()->json([
                'message' => 'otpless error'
            ],400);
        }
        $user = User::where('number',$data['number'])->update([
            'password'=>Hash::make($data['password']),
            'fcm_token' => $data['fcm_token']
        ]);
        $user = User::where('number',$data['number'])->first();
        $token = $user->createToken('Token')->plainTextToken;
        return response()->json([
            'messsage'=>'your password updated',
            'token' => $token
        ]);
    }

    public function userInfo(){
        $user_id = Auth::user()->id;
        $rent = Estate::where('user_id',$user_id)
        ->where('type','rent')->count();
        $rented = Estate::where('user_id',$user_id)
        ->where('type','rented')->count();
        $sale = Estate::where('user_id',$user_id)
        ->where('type','sale')->count();
        $sold = Estate::where('user_id',$user_id)
        ->where('type','sold')->count();
        return response()->json([
            'user'=> User::where('id',Auth::user()->id)
            ->select('id','name','number','photo','whats_number','email','location','type','qr_code')
            ->get(),
            'rent' => $rent,
            'rented' => $rented,
            'sale' => $sale,
            'sold' => $sold,
        ]);
    }

    public function updateInfo(UpdateInfoRequest $request){
        $user = $request->user();
        $data = $request->all();

        if (isset($data['photo'])) {
            $data['photo'] = $this->addPhoto($data['photo'],'imagesUser/');
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'data'=>$user,
            'message'=>'your info updated'
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>"logout sucsses"
        ]);
    }

    public function allUser(Request $request){
        $data = $request->all();
        $user_id = Auth::user()->id;
        if (empty($data['name'])) {
            $users = User::where('type',$data['type'])
            ->where('id','!=',$user_id )
            ->select('id','name','number','photo','whats_number','email','location','type','qr_code')
            ->get();
            return response()->json(['users'=>$users]);
        }
        $users = User::where('type',$data['type'])
        ->where('name','like',"%{$data['name']}%")
        ->where('id','!=',$user_id )
        ->where('block',false)
        ->select('id','name','number','photo','whats_number','email','location','type','qr_code')
        ->get();
        return response()->json(['users'=>$users]);
    }

    public function deleteUser($id){
        User::findOrFail($id)->delete();
        return response()->json([
            'message'=>'user deleted'
        ]);
    }

    public function blockUser($id){
        $user  = User::findOrFail($id);
        $block = $user->block;
        $user->block = !$block;
        $user->save();
        return response()->json([
            'message' => 'change state done'
        ]);
    }


    public function getHome(){
        $estate = EstateResource::collection(Estate::whereIn('type',['rent','sale'])
        ->inRandomOrder()->take(10)->get());
        $news = News::inRandomOrder()->take(10)->with('departments')->get();
        $office = User::where('type','office')
        ->where('id','!=',Auth::user()->id)
        ->select('id','name','number','photo','whats_number','email','location','type','qr_code')
        ->inRandomOrder()->take(10)->get();
        return response()->json([
            'estate'=>$estate,
            'news'=>$news,
            'office'=>$office
        ]);
    }

    public function appInfo(){
            $filePath = storage_path('app_info.json');
            $minPrice = DB::table('estates')->min('price');
            $maxPrice = DB::table('estates')->max('price');
            if (File::exists($filePath)) {
                $fileContents = File::get($filePath);
                return response()->json([
                    'app_info' => json_decode($fileContents),
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice,
                ], 200);
            }
            return response()->json(['error' => 'File not found.'], 400);
    }

}
