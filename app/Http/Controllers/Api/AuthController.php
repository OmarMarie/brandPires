<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Chatting;
use App\Models\City;
use App\Models\Country;
use App\Models\Friend;
use App\Models\GiftAction;
use App\Models\Levels;
use App\Models\Player;
use App\Models\PlayerBubbles;
use App\Models\PlayerTankAction;
use App\Traits\ApiResponser;
use App\Traits\MessageLanguage;
use App\Traits\SendCodeSMS;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Countries\Package\Countries;
use function Sodium\compare;

class AuthController extends Controller
{
    use ApiResponser, MessageLanguage, SendCodeSMS;


    /**
     * Create user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response [string] message
     * @internal param $ [string] name
     * @internal param $ [string] email
     * @internal param $ [string] password
     * @internal param $ [string] password_confirmation
     */
    public function signUp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }
        $this->checkLang($request);
        $player = Player::Where('phone_number', $request->phone_number)->Where('is_verified', 1)->first();

        if ($player != null) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'username' => 'required|string|unique:players',
                'email' => 'required|string|email|unique:players',
                'birth_day' => 'required',
                'gender' => 'required|integer|in:1,2',
                'password' => 'required|string|confirmed|min:8|max:20'
            ]);

            if ($validator->fails()) {
                $errors = collect([]);
                foreach ($validator->messages()->all() as $item) {
                    $errors->push($item);
                }
                return $this->apiResponse(null, $errors, 422, 0);
            }
            $player->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'birth_day' => $request->birth_day,
                'img' => 'default.jpg',
                'password' => Hash::make($request->password),
                'level_id' => 1,
            ]);
            $player->save();
            PlayerTankAction::create([
                'tank_id' => 1,
                'player_id' => $player->id,
                'action' => 0,
                'status' => 1,
                'tank_pts' => 0
            ]);
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Registered successfully';
                    break;
                case 'ar':
                    $message = 'تم تسجيل بنجاح';
                    break;
                default:
                    $message = 'Registered successfully';
                    break;
            }
        } else {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Inactive phone number';
                    break;
                case 'ar':
                    $message = '  رقم الهاتف  غير فعال ';
                    break;
                default:
                    $message = 'Inactive phone number';
                    break;
            }
        }


        return $this->apiResponse(null, $message, 201, 1);
    }

    /**
     * Login user and create token
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response [string] access_token
     * @internal param $ [string] email
     * @internal param $ [string] password
     * @internal param $ [boolean] remember_me
     */
    public function login(Request $request)
    {
        $this->checkLang($request);
        $message = null;
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $input = $request->email;
        $password = $request->password;

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            //user sent their email
            $credentials = ['email' => $input, 'password' => $password, 'status' => 1];
        } elseif (is_numeric($input)) {

            $credentials = ['phone_number' => $input, 'password' => $password, 'status' => 1];
        } else {
            //they sent their username instead
            $credentials = ['username' => $input, 'password' => $password, 'status' => 1];
        }


        if (!auth('player')->attempt($credentials)) {
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                switch ($request->header('lang')) {
                    case 'en':
                        $message = 'Email or Password Incorrect';
                        break;
                    case 'ar':
                        $message = 'البريد الالكتروني او كلمة المرور غير صحيحة';
                        break;
                    default:
                        $message = 'Email or Password Incorrect';
                        break;
                }
            } elseif (is_numeric($input)) {
                switch ($request->header('lang')) {
                    case 'en':
                        $message = 'Phone or Password Incorrect';
                        break;
                    case 'ar':
                        $message = 'رقم الهاتف او كلمة المرور غير صحيحة';
                        break;
                    default:
                        $message = 'Phone or Password Incorrect';
                        break;
                }
            } else {
                switch ($request->header('lang')) {
                    case 'en':
                        $message = 'Username or Password Incorrect';
                        break;
                    case 'ar':
                        $message = 'اسم المستخدم او كلمة المرور غير صحيحة';
                        break;
                    default:
                        $message = 'Username or Password Incorrect';
                        break;
                }
            }

            return $this->apiResponse(null, $message, 401, 0);
        }

        $user = auth()->guard('player')->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];

        return $this->apiResponse($response, null, 200, 1);

    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response [string] message
     */
    public function logout(Request $request)
    {

        $this->checkLang($request);
        \auth()->user()->token()->revoke();
        switch ($request->header('lang')) {
            case 'en':
                $message = 'Successfully logged out';
                break;
            case 'ar':
                $message = "تم تسجيل الخروج بنجاح";
                break;
            default:
                $message = 'Successfully logged out';
                break;
        }
        return $this->apiResponse(null, $message, 200, 1);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response [json] user object
     */
    public function user(Request $request)
    {
        $this->checkLang($request);
        $playerId = $request->user()->id;
        $gifts = GiftAction::where('player_id', $playerId)->where('status', 0)->count();
        $friendsRequest = Friend::where('player_id', $playerId)->where('status', 0)->count();
        $chatting = Chatting::where('receiver_id', $playerId)->where('status', 0)->count();
        $levelPts = Player::find($playerId)->level;
        $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $playerId)->first();

        $extraTank = 0;
        $levelDetails = Levels::where('id', auth()->guard()->user()->level_id)->first(['extra', 'duration']);
        $extraLiveTime = $levelDetails->duration;

        if (auth()->guard()->user()->level_updated_at != null) {
            $expired_at = date('Y-m-d H:i:s', strtotime('+' . $extraLiveTime . ' hours', strtotime(auth()->guard()->user()->level_updated_at)));
            if (now() < $expired_at) {
                $extraTank = ($tankDetails['tanks']->size * ($levelDetails->extra / 100));
            }
        }

        $numberOfTankBubbles = PlayerBubbles::where('player_id', $request->user()->id)->where('status', 1)->count();

        $request->user()->img = env('APP_URL') . '/' . $request->user()->img;
        $response = [
            'player' => $request->user(),
            'is_online' => auth()->user()->isOnline(),
            'gifts' => $gifts == 0 ? null : $gifts,
            'friends_response' => $friendsRequest == 0 ? null : $friendsRequest,
            'chatting' => $chatting == 0 ? null : $chatting,
            'level_points' => $levelPts->to_pts,
            'level_icon' => null ? null : env('APP_URL') . '/level/' . $levelPts->level_icon,
            'tank_details' => [
                'player_tank_pts' => $numberOfTankBubbles,
                'tank_id' => $tankDetails->tank_id,
                'size' => $tankDetails['tanks']['size'],
                'extra_tank_pts' => $extraTank,
                'img' => $tankDetails['tanks']['img'] == null ? null : env('APP_URL') . '/tank/' . $tankDetails['tanks']['img']
            ]
        ];
        return $this->apiResponse($response, null, 200, 1);
    }

    public function contacts(Request $request)
    {
        $this->checkLang($request);
        $contacts_number = $request->contacts;
        $contacts_found = Player::whereIn('phone_number', $contacts_number)->pluck('phone_number')->toArray();
        $allContacts = [];
        foreach ($contacts_number as $key => $value) {

            if (in_array($value, $contacts_found)) {
                $player = Player::where('phone_number', $value)->first();
                $allContacts[$key]['phone_number'] = $value;
                $allContacts[$key]['name'] = $player->first_name . ' ' . $player->last_name;
                $allContacts[$key]['image'] = env('APP_URL') . '/' . $player->img;
                $allContacts[$key]['status'] = true;
            } else {
                $allContacts[$key]['phone_number'] = $value;
                $allContacts[$key]['status'] = false;
            }

        }

        return $this->apiResponse($allContacts, null, 200, 1);
    }

    public function validatePhone(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric|unique:players',

        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        return $this->apiResponse(null, 'Phone Number is available', 201, 1);

    }

    public function validateEmail(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:players',

        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        return $this->apiResponse(null, 'Email is available', 201, 1);

    }

    public function validateUsername(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:players',

        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        return $this->apiResponse(null, 'Username is available', 201, 1);

    }

    public function requestVerificationCode(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $player = Player::where('phone_number', $request->phone)->first();
        if ($player) {

            $verificationCode = rand(1000, 9999);
            $request->phone = '962' . ltrim($request->phone, 0);
            $this->sms('The Verification code is ' . $verificationCode, $request->phone);

            $player->update([
                'verification_code' => $verificationCode
            ]);

            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Verification code send successfully';
                    break;
                case 'ar':
                    $message = 'تم إرسال رمز التحقق بنجاح';
                    break;
                default:
                    $message = 'Verification code send successfully';
                    break;
            }
        } else {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Please verify the phone number';
                    break;
                case 'ar':
                    $message = 'الرجاء التأكد من رقم الهاتف ';
                    break;
                default:
                    $message = 'Please verify the phone number';
                    break;
            }
        }
        return $this->apiResponse(null, $message, 200, 1);
    }

    public function requestVerificationCodeSignUp(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric|min:10|max:12',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $playerValidate = Player::where('phone_number', $request->phone_number)->first();

        if ($playerValidate != null) {
            if ($playerValidate->email == null) {
                $verificationCode = rand(1000, 9999);
                $request->phone_number = '962' . ltrim($request->phone_number, 0);

                $this->sms('The Verification code is ' . $verificationCode, $request->phone_number);

                $playerValidate->update([
                    'verification_code' => $verificationCode
                ]);

                switch ($request->header('lang')) {
                    case 'en':
                        $message = 'Verification code send successfully';
                        break;
                    case 'ar':
                        $message = 'تم إرسال رمز التحقق بنجاح';
                        break;
                    default:
                        $message = 'Verification code send successfully';
                        break;
                }

            } else {
                switch ($request->header('lang')) {
                    case 'en':
                        $message = 'User is already registered';
                        break;
                    case 'ar':
                        $message = 'المستخدم مسجل مسبقا';
                        break;
                    default:
                        $message = 'User is already registered';
                        break;
                }
            }

        }
        else {
            $player = new Player([
                'phone_number' => $request->phone_number,
            ]);
            $player->save();

            $verificationCode = rand(1000, 9999);
            $request->phone_number = '962' . ltrim($request->phone_number, 0);

            $this->sms('The Verification code is ' . $verificationCode, $request->phone_number);

            $player->update([
                'verification_code' => $verificationCode
            ]);

            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Verification code send successfully';
                    break;
                case 'ar':
                    $message = 'تم إرسال رمز التحقق بنجاح';
                    break;
                default:
                    $message = 'Verification code send successfully';
                    break;
            }
        }


        return $this->apiResponse(null, $message, 200, 1);
    }

    public function reset(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6|max:20|confirmed',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }
        $player = Player::where('phone_number', $request->phone)->where('verification_code', $request->code)->first();

        if ($player) {
            $player->update([
                'password' => Hash::make($request->password)
            ]);
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Password has been changed successfully';
                    break;
                case 'ar':
                    $message = 'تم تغيير كلمة المرور بنجاح';
                    break;
                default:
                    $message = 'Password has been changed successfully';
                    break;
            }
            return $this->apiResponse(null, $message, 200, 1);
        } else {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'The verification code is incorrect';
                    break;
                case 'ar':
                    $message = 'رمز التحقق غير صحيح';
                    break;
                default:
                    $message = 'The verification code is incorrect';
                    break;
            }
            return $this->apiResponse(null, $message, 422);
        }
    }

    public function verify(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $player = Player::where('phone_number', $request->phone)->where('verification_code', $request->code)->first();

        if ($player) {
            if ($request->code == $player->verification_code) {
                $player->update([
                    'is_verified' => 1
                ]);
                switch ($request->header('lang')) {
                    case 'en':
                        $massage = 'User verified successfully';
                        break;
                    case 'ar':
                        $massage = 'تم التحقق من المستخدم بنجاح';
                        break;
                    default:
                        $massage = 'User verified successfully';
                        break;
                }
                return $this->apiResponse(null, $massage, 200, 1);
            }
        }
        switch ($request->header('lang')) {
            case 'en':
                $massage = 'The verification code incorrect!';
                break;
            case 'ar':
                $massage = 'رمز التحقق غير صحيح!';
                break;
            default:
                $massage = 'The verification code incorrect!';
                break;
        }
        return $this->apiResponse(null, $massage, 422, 0);
    }

    public function getCountries(Request $request)
    {
        $data = Country::where('status', '1')->get();
        foreach ($data as $datum) {
            $datum['flag'] = env('APP_URL') . '/flags/' . $datum['flag'];
        }
        return $this->apiResponse($data, null, 200, 1);
    }

    public function getCities(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|integer',

        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }
        $data = City::where('country_id', $request->country_id)->get(['id', 'name']);
        return $this->apiResponse($data, null, 200, 1);
    }

    public function online(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'type' => 'required|numeric|min:0|max:1',
        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $playerId = $request->user()->id;
        $player = Player::where('id', $playerId)->first();

        $player->update([
            'is_online' => $request->type
        ]);
        return $this->apiResponse(null, 'Done', 201, 1);
    }


}
