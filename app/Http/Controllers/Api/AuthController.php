<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Chatting;
use App\Models\Friend;
use App\Models\GiftAction;
use App\Models\Levels;
use App\Models\Player;
use App\Models\PlayerBubbles;
use App\Models\PlayerTankAction;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Validator;
use function Sodium\compare;

class AuthController extends Controller
{
    use ApiResponser;

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
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:players',
            'email' => 'required|string|email|unique:players',
            'phone_number' => 'required|unique:players',
            'birth_day' => 'required',
            'password' => 'required|string|confirmed|min:8|max:20'
        ]);
        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $player = new Player([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birth_day' => $request->birth_day,
            'img' => 'default.jpg',
            'password' => bcrypt($request->password),
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

        return $this->apiResponse(null, 'Successfully created player!', 201, 1);
        /*return response()->json([
            'message' => 'Successfully created player!'
        ], 201);*/
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
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

        $credentials = request(['email', 'password']);
        if (!Auth::guard('player')->attempt($credentials))
            return $this->apiResponse(null, 'Email or Password incorrect', 401, 0);

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
        \auth()->guard('player')->user()->token()->revoke();
        return $this->apiResponse(null, 'Successfully logged out', 200, 1);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response [json] user object
     */
    public function user(Request $request)
    {
        $playerId = auth()->guard('player')->user()->id;
        $gifts = GiftAction::where('player_id', $playerId)->where('status', 0)->count();
        $friendsRequest = Friend::where('player_id', $playerId)->where('status', 0)->count();
        $chatting = Chatting::where('receiver_id', $playerId)->where('status', 0)->count();
        $levelPts = Player::find($playerId)->level;
        $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $playerId)->first();

        $extraTank = 0;
        $levelDetails = Levels::where('id', auth()->guard('player')->user()->level_id)->first(['extra', 'duration']);
        $extraLiveTime = $levelDetails->duration;

        if (auth()->guard('player')->user()->level_updated_at != null) {
            $expired_at = date('Y-m-d H:i:s', strtotime('+' . $extraLiveTime . ' hours', strtotime(auth()->guard('player')->user()->level_updated_at)));
            if (now() < $expired_at) {
                $extraTank = ($tankDetails['tanks']->size * ($levelDetails->extra / 100));
            }
        }

        $numberOfTankBubbles = PlayerBubbles::where('player_id', $request->user()->id)->where('status', 1)->count();

        $request->user()->img = env('APP_URL').'/'.$request->user()->img;
        $response = [
            'player' => $request->user(),
            'is_online' => auth('player')->user()->isOnline(),
            'gifts' => $gifts == 0 ? null : $gifts,
            'friends_response' => $friendsRequest == 0 ? null : $friendsRequest,
            'chatting' => $chatting == 0 ? null : $chatting,
            'level_points' => $levelPts->to_pts,
            'level_icon' => $levelPts->level_icon,
            'tank_details' => [
                'player_tank_pts' => $numberOfTankBubbles,
                'tank_id' => $tankDetails->tank_id,
                'size' => $tankDetails['tanks']['size'],
                'extra_tank_pts' => $extraTank,
                'img' => $tankDetails['tanks']['img'] == null ? null : env('APP_URL').'/tank/'.$tankDetails['tanks']['img']
            ]
        ];
        return $this->apiResponse($response, null, 200, 1);
    }

    public function contacts(Request $request)
    {
        $contacts_number = $request->contacts;
        $contacts_found = Player::whereIn('phone_number', $contacts_number)->pluck('phone_number')->toArray();

        $allContacts = [];
        foreach ($contacts_number as $key => $value) {
            if (in_array($value, $contacts_found)) {
                $allContacts[$key]['phone_number'] = $value;
                $allContacts[$key]['status'] = true;
            } else {
                $allContacts[$key]['phone_number'] = $value;
                $allContacts[$key]['status'] = false;
            }

        }
        return $this->apiResponse($allContacts, null, 200, 1);
    }

    /*public function generateVerificationCode($id)
    {
        try
        {
            $player = Player::findOrFail($id);
        }

        catch(ModelNotFoundException $e)
        {
            return response()->json([
                'message' => 'Player not found'
            ]);
        }

        $player->verify_code = 1234;
        $player->save;
        return $player;

        return response()->json([
           'message' => 'Congratulations, Your account has been verified'
        ]);
    }*/

    /*public function verify(Request $request){

        $player_id = $request->id;
        $player_code = $request->code;

        if ($player_code == $plyer_verification_code){
            //update
        }
        // if code same as the code in db make is_verify = 1
    }*/
}
