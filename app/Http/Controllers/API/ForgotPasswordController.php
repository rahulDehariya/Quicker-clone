<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Auth\Traits\SendsPasswordResetSmsTrait;
use App\Http\Requests\ForgotPasswordRequest;
use App\Helpers\Auth\Traits\SendsPasswordResetEmails;
use App\Notifications\PasswordResetRequest;
use App\Http\Controllers\FrontController;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;

use Illuminate\Notifications\Messages\MailMessage;

class ForgotPasswordController extends FrontController
{
    use SendsPasswordResetEmails {
        sendResetLinkEmail as public traitSendResetLinkEmail;
    }
    use SendsPasswordResetSmsTrait;
    
    protected $redirectTo = '/account';
    
    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('guest');
    }
    
    
    /**
     * Send a reset link to the given user.
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        // Get the right login field

        //create token
        $token=Str::random(64);
 
        $field = getLoginField($request->input('login'));

        $request->merge([$field => $request->input('login')]);

        //Cheaking field in users

        $user=User::where($field,$request->input('login') )->get();

            if(count($user)>0){
                if ($field != 'email') {
                $request->merge(['email' => $request->input('login')]);
            }
            
            
            // Send the Token by SMS
            if ($field == 'phone') {

                $this->sendResetTokenSms($request);
                return $res=response()->json(['status'=>'200','message'=>'Enter the code you received by SMS']);
            }

            // Go to the core process
            $res= $this->traitSendResetLinkEmail($request);
            

             return $res=response()->json(['status'=>'200','message'=>'please check your email','record'=>$res]);
           
            }
            else{
               return $res=response()->json(['status'=>'404','message'=>'We can not find a user with that '.$field.'  address']);
            }
       
    }
}
