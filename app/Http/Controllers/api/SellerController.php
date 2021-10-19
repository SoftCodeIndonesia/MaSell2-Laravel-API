<?php
namespace App\Http\Controllers\api;
date_default_timezone_set("Asia/Jakarta");


use Carbon\Carbon;
use App\Helpers\Email;
use App\Helpers\MailType;
use App\Models\Seller;
use App\Mail\EmailVerify;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class SellerController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:seller',
            'password' => 'required|string|min:6',
        ]);

        
        if($validator->fails()){
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first(),
            ], 400);
        }else{


            $locationInfo = AppHelper::getLocationInfoByIp();
            
            $current_date_time = time();
            $deviceId = $request->header("user-agent");
           
            $verifyCode = rand(10000,99999);

            

            $seller = new Seller;



            $seller->set([
                'sellerId' => generateId(),
                'username' => uniqid(),
                'email' => $request->get('email'),
                'emailVerify' => 0,
                'emailVerifyId' => $verifyCode,
                'emailVerifyIdExpired' => $current_date_time + 60,
                'countryCode' => $locationInfo['countryCode'],
                'country' => $locationInfo['countryName'],
                'registerAt' => $current_date_time,
                'deviceId' => $deviceId,
                'isActived' => 0,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'password' => Hash::make($request->get('password'))
            ]);

            $affected = $seller->save();


            if(!$affected) return badResponse('Failed registed!');

            $email = new Email([
                'to' => $request->get('email'),
                'mailType' => Email::verification
            ]);

            $email->send();
            
            return response_ok($seller);
        }
    }

    public function verification(Request $request){
        $code = $request->get('code');
        $sellerId = $request->get("sellerId");

        $seller = DB::table('seller')->where('sellerId', $sellerId)->get()->first();

        if($seller){

            if(time() > $seller->emailVerifyIdExpired){

                return response()->json([
                    "status" => false,
                    "message" => 'Expired code!'
                ], 400);

            }else{

                if($seller->emailVerifyId == $code){

                    $sellerUpdate['emailVerify'] = 1;
                    $sellerUpdate['emailIsVerifyAt'] = time();
                    $sellerUpdate['emailVerifyId'] = '';
                    $sellerUpdate['emailVerifyIdExpired'] = 0;
                    $sellerUpdate['isActived'] = 1;
                    $sellerUpdate['updated_at'] = Carbon::now()->toDateTimeString();

                    $affected = DB::table('seller')->where('sellerId', $sellerId)->update($sellerUpdate);

                    if($affected){

                        return response()->json([
                            "status" => true,
                            "message" => 'Successfully verified!',
                        ], 200);

                    }

                }else{
                    return response()->json([
                        "status" => false,
                        "message" => 'Invalid code!'
                    ], 400);
                }
            }

        }else{
            return response()->json([
                "status" => false,
                "message" => 'Unautorization seller'
            ], 400);
        }

    }

    public function resendCode(Request $request){

        $sellerId = $request->get('sellerId');
        $email = $request->get('email');

        $validator = Validator::make($request->all(), [
            'sellerId' => 'required',
            'email' => 'required',
        ]);


        if($validator->fails()){
            $sellerIdError = $validator->errors()->messages()['sellerId'][0];
            $emailError = $validator->errors()->messages()['email'][0];
            return response()->json([
                "status" => false,
                "message" => !empty($sellerIdError) ? $sellerIdError : $emailError
            ], 400);
        }



        $verifyCode = rand(10000,99999);

        $dataSeller['emailVerifyId'] = $verifyCode;
        $dataSeller['emailVerifyIdExpired'] = time() + 300;
        $dataSeller['updated_at'] = Carbon::now()->toDateTimeString();



        $affected = DB::table('seller')->where('sellerId', $sellerId)->update($dataSeller);

        if($affected){

            $email = new Email([
                'to' => $email,
                'mailType' => Email::verification
            ]);

            $email->send();

            return response()->json([
                "status" => true,
                "message" => 'Resend Code Successfully!',
            ], 200);

        }else{

            return response()->json([
                "status" => true,
                "message" => 'Resend Code Failed!',
            ], 400);
        }

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $email = $request->get('email');
        $password = $request->get('password');



        try {
            if (! $token = auth('seller-api')->attempt(['email' => $email, 'password' => $password, 'isActived' => 1])) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $status = true;
        $message = 'Is LoggedIn!';
        $data = [
            "token" => $token,
            "seller" => auth('seller-api')->user()->only(['sellerId', 'username', 'avatarUrl', 'email', 'country'])
        ];

        return response()->json(compact('status', 'message', 'data'));
    }

    public function refreshToken()
    {
        $token = auth('seller-api')->refresh();

        $status = true;
        $message = 'Is LoggedIn!';
        $data = [
            "token" => $token,
            "seller" => auth('seller-api')->user()->only(['sellerId', 'username', 'avatarUrl', 'email', 'country'])
        ];

        return response()->json(compact('status', 'message', 'data'));
        
    }
}