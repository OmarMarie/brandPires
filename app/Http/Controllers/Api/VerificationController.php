<?php

namespace App\Http\Controllers\Api;


use App\Providers\RouteServiceProvider;
use App\Traits\ApiResponser;
use App\Traits\MessageLanguage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails,ApiResponser, MessageLanguage;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {

         $this->checkLang($request);
        if ($request->user()->hasVerifiedEmail()) {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Already verified';
                    break;
                case 'ar':
                    $message = 'تم التحقق بالفعل';
                    break;
                default:
                    $message = 'Already verified';
                    break;
            }
            return $this->apiResponse(null,$message , 201, 1);
        }

        $request->user()->sendEmailVerificationNotification();

        if ($request->wantsJson()) {
            switch ($request->header('lang')) {
                case 'en':
                    $message = "We've sent a confirmation to your e-mail for verification.";
                    break;
                case 'ar':
                    $message = "لقد أرسلنا تأكيدًا إلى بريدك الإلكتروني للتحقق.";
                    break;
                default:
                    $message = "We've sent a confirmation to your e-mail for verification.";
                    break;
            }
            return $this->apiResponse(null,$message , 201, 1);
        }

        return back()->with('resent', true);
    }


    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
         auth('player')->loginUsingId($request->route('id'));

        if ($request->route('id') != auth('player')->user()->getKey()) {
            throw new AuthorizationException;
        }

        if (auth('player')->user()->hasVerifiedEmail()) {

            //return response(['message'=>'Already verified']);
            // return redirect($this->redirectPath());
            return view('email.alreadyVerified');
        }

        if (auth('player')->user()->markEmailAsVerified()) {
            event(new Verified(auth('player')->user()));
        }

       //return response(['message'=>'Successfully verified']);
        return view('email.successfullyVerified');

    }
}
