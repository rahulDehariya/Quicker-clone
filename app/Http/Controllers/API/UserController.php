<?php

namespace App\Http\Controllers\API;
use App\Helpers\Ip;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\FrontController;
//Registration

use App\Rules\BetweenRule;
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;
use App\Rules\EmailRule;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Events\UserWasLogged;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
use Validator;
//Models
use App\Models\Gender;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserType;
use App\Models\Message;
use App\Models\Post;
use App\Models\Payment;
use App\Models\SavedPost;
use App\Models\SavedSearch;

use App\Notifications\UserActivated;
use App\Notifications\UserNotification;
use App\Helpers\Auth\Traits\RegistersUsers;
use App\Helpers\Auth\Traits\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Torann\LaravelMetaTags\Facades\MetaTag;
// ForgotPassword 
use App\Http\Controllers\Auth\Traits\SendsPasswordResetSmsTrait;
use App\Http\Requests\ForgotPasswordRequest;
use App\Helpers\Auth\Traits\SendsPasswordResetEmails;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;
use App\Notifications\PostArchived;
use App\Notifications\PostRepublished;
class UserController extends FrontController 
{
	private $perPage = 12;

	use AuthenticatesUsers,  RegistersUsers, VerificationTrait {
   	 	AuthenticatesUsers::redirectPath insteadof RegistersUsers;
    	AuthenticatesUsers::guard insteadof RegistersUsers;
	}

	
	protected $maxAttempts = 5;

	/**
	 * Register a new user account.
	 *
	 * @param UserRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function __construct()
	{
		parent::__construct();
		
	}
	
	/**
	 * New User Registration
	 */
	
	public function register(Request $request){

		// Conditions to Verify User's Email or Phone

		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email');
		$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone');

		//Validating Data
		$country_code = config('country.code');

		$validator = Validator::make($request->all(), [
                'name'=>['required'],
                'phone'        => ['required','numeric','unique:users,phone'],

				'email'        => ['max:100','email','unique:users,email'],
                'password'     => [
									'required',
									'min:' . config('larapen.core.passwordLength.min', 6),
									'max:' . config('larapen.core.passwordLength.max', 60),
									'dumbpwd',
									'confirmed'
								    ],
				'password_confirmation'=>['required','same:password'],
			    'term'         => ['accepted'],
              ]);

		//If validation fails

        if ($validator->fails())
        { 
            $message = $validator->errors()->all();
            // send validation errors
            return response()->json(['status'=>404,'message'=>'An error occurred while validating the data','error'=>$validator->errors()]);            
        }

        
        $user = new User();
		$input = $request->only($user->getFillable());
		foreach ($input as $key => $value) {
			$user->{$key} = $value;
		}

		//Cheaking Email & phone
		$email=$request->input('email');

		$phone=$request->input('phone');

		$check_email=User::where('email',$email)->first();

		$check_phone=User::where('phone', $phone)->first();
	
		if($check_email){
		 return response()->json(['status'=>'404','message'=>'The email address has already been taken']);
		}
		elseif ($check_phone) {
			 return response()->json(['status'=>'404','message'=>'The Phone No has already been taken']);
		}
		
			//Fetching fields fields
			
			$user->country_code = config('country.code');
			$user->language_code = config('app.locale');
			$user->password = Hash::make($request->input('password'));
			$user->phone_hidden = $request->input('phone_hidden');

			$user->os_type = $request->input('os_type');
			$user->device_id = $request->input('device_id');
			$user->device_name = $request->input('device_name');
			$user->fcm_token = $request->input('fcm_token');
			$user->device_model = $request->input('device_model');

			$user->ip_addr = Ip::get();
			$user->verified_email = 1;
			$user->verified_phone = 1;
			
			// Email verification key generation
			if ($emailVerificationRequired) {
				$user->email_token = md5(microtime() . mt_rand());
				$user->verified_email = 0;
			}
			
			// Mobile activation key generation
			if ($phoneVerificationRequired) {
				$user->phone_token = mt_rand(100000, 999999);
				$user->verified_phone = 0;
			}
			
			// Save
			$user->save();

			// Get Inserted Id
			$user->id;

			//User Profile image
			if($user->photo){
			   $user->profile=imgUrl(auth()->user()->photo, 'user');
			}
			else{
				 $user->profile='https://i1.wp.com/siyalu.lk/images/user.jpg?ssl=1';
			}
			//AccessToken

			$token = $user->createToken('authToken')->accessToken;

			// Message Notification & Response

			if ($emailVerificationRequired || $phoneVerificationRequired) {
				
				
				// Email
				if ($emailVerificationRequired) {
					// Send Verification Link by Email
					$this->sendVerificationEmail($user);
					
					// Show the Re-send link
					$this->showReSendVerificationEmailLink($user, 'user');
				}
				
				// Phone
				if ($phoneVerificationRequired) {
					// Send Verification Code by SMS
					$this->sendVerificationSms($user);
					
					// Show the Re-send link
					$this->showReSendVerificationSmsLink($user, 'user');
					
					// Go to Phone Number verification
					$nextUrl = config('app.locale') . '/verify/user/phone/';
				}
				
				// Send Confirmation Email or SMS,
				// When User clicks on the Verification Link or enters the Verification Code.
				// Done in the "app/Observers/UserObserver.php" file.
				
			}
            // Send response
			
			return response()->json(['status'=>'200','message'=>'your account has been created','record'=>$user,'token'=>$token]);
		
	}

	
	/**
	 * @param LoginRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request)
	{
		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.

		// Get the right login field
		$loginField = getLoginField($request->input('login'));

		//Aplly validation on field

		$validator = Validator::make($request->all(), [
                'login'        => ['required'],
                'password'        => ['required']
              ]);
		

		//If validation fails

        if ($validator->fails())
        { 
            $message = $validator->errors()->all();
            // Send validation errors
            return response()->json(['status'=>404,'message'=>'An error occurred while validating the data','error'=>$validator->errors()]);            
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);
			
			return $this->sendLockoutResponse($request);
		}
		
		// Get the right login field
		$user=User::where($loginField,$request->input('login') )->first();

		if($user){
            // Check DB password with input password
		 if(Hash::check($request->input('password'), $user->password)){
		
			// Get credentials values
			$credentials = [
				$loginField => $request->input('login'),
				'password'  => $request->input('password'),
				'blocked'   => 0,
			];

			if (in_array($loginField, ['email', 'phone'])) {
				$credentials['verified_' . $loginField] = 1;
			} else {
				$credentials['verified_email'] = 1;
				$credentials['verified_phone'] = 1;
			}
			
			// Auth the User
			if (auth()->attempt($credentials)) {
				$user = User::find(auth()->user()->getAuthIdentifier());

				//Update data
				$user->os_type = $request->input('os_type');
				$user->device_id = $request->input('device_id');
				$user->device_name = $request->input('device_name');
				$user->fcm_token = $request->input('fcm_token');
				$user->device_model = $request->input('device_model');

				$user->save();
				
				// Update last user logged Date
				Event::dispatch(new UserWasLogged($user));

				//User Profile
				if($user->photo){
				  $user->profile=imgUrl(auth()->user()->photo, 'user');
				}
				else{
					 $user->profile='https://i1.wp.com/siyalu.lk/images/user.jpg?ssl=1';
				}

				// Send admin users Response
				if (auth()->check()) {
					if ($user->hasAllPermissions(Permission::getStaffPermissions())) {

						$token = $user->createToken('authToken')->accessToken;

	                    return response()->json(['status'=>'200','msg'=>'Logged in successfully','record'=>$user,'token'=>$token]);
					}

					
				}
				// Send  normal users response
					 $token = $user->createToken('authToken')->accessToken;
	               return response()->json(['status'=>'200','message'=>'Logged in successfully','record'=>$user,'token'=>$token]);
			
		}
		
		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		// $this->incrementLoginAttempts($request);
		  $this->incrementLoginAttempts($request);
		// Check and retrieve previous URL to show the login error on it.

		}
		else{
            // Send credentials do not match response
			return response()->json(['status'=>'404','message'=>'These credentials do not match our records']);
			}
		}
		else{
			return response()->json(['status'=>'404','message'=>'These credentials do not match our records']);
		}
		
	}
	   /**
     * Send a reset link to the given user.
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        // Get login field
    	$field = getLoginField($request->input('login'));
        $request->merge([$field => $request->input('login')]);
        if ($field != 'email') {
            $request->merge(['email' => $request->input('login')]);
        }
        
        // Send the Token by SMS
        if ($field == 'phone') {
            return $this->sendResetTokenSms($request);
        }
        
        // Go to the core process
        $this->traitSendResetLinkEmail($request);
        return  $res=response()->json(['status'=>'200','message'=>'please check your email']);
       

    }
    /**
     * Update  User Profile 
     *
     */

     public function updateDetails(Request $request){

         
         //Apply validation on fields
         $userId=auth()->user()->id;
        $validator = Validator::make($request->all(), [
                'name'=>['required'],
                'gender_id'=>['required'],
                'phone'        => ['required','numeric'],
				'email'        => ['max:100','email', "unique:users,email,".$userId.",id"]
              ]);

		//If validation fails

        if ($validator->fails())
        { 
            $message = $validator->errors()->all();
            // send validation errors
            return response()->json(['status'=>404,'message'=>'An error occurred while validating the data','error'=>$validator->errors()]);            
        }

      
        // Check if these fields has changed
		$emailChanged = $request->filled('email') && $request->input('email') != auth()->user()->email;
		$phoneChanged = $request->filled('phone') && $request->input('phone') != auth()->user()->phone;
		$usernameChanged = $request->filled('username') && $request->input('username') != auth()->user()->username;

       
		
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $emailChanged;
		$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $phoneChanged;


		
		// Get User
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);

        // Update User
		$input = $request->only($user->getFillable());
		foreach ($input as $key => $value) {
			if (in_array($key, ['email', 'phone', 'username']) && empty($value)) {
				continue;
			}
			$user->{$key} = $value;
		}
		
		 $user->phone_hidden = $request->input('phone_hidden');

        // Email verification key generation
		if ($emailVerificationRequired) {
           
			$user->email_token = md5(microtime() . mt_rand());
			$user->verified_email = 0;
		}
		
		// Phone verification key generation
		if ($phoneVerificationRequired) {
          
			$user->phone_token = mt_rand(100000, 999999);
			$user->verified_phone = 0;
		}
        $user->save();
        $token = $user->createToken('authToken')->accessToken;

        // Send Email Verification message
		if ($emailVerificationRequired) {
			$this->sendVerificationEmail($user);
			$this->showReSendVerificationEmailLink($user, 'user');
		}
		
		// Send Phone Verification message
		if ($phoneVerificationRequired) {
			// Save the Next URL before verification
			session(['itemNextUrl' => $nextUrl]);
			
			$this->sendVerificationSms($user);
			$this->showReSendVerificationSmsLink($user, 'user');
			
			// Go to Phone Number verification
			$nextUrl = config('app.locale') . '/verify/user/phone/';
		}

        return response()->json(['status'=>'200','message'=>'Account details has  updated successfully','record'=>$user,'token'=>$token]);
     }
     /**
	 * Store the User's photo.
	 *
	 * @param $userId
	 *
	 */
	public function updatePhoto(Request $request)
	{
	

        //Apply validation on fields
        $validator = Validator::make($request->all(), [
                'photo'=>['required','mimes:jpeg,png,jpg'],
         ]);

		//If validation fails

        if ($validator->fails())
        { 
            $message = $validator->errors()->all();
            // send validation errors
            return response()->json(['status'=>404,'message'=>'An error occurred while validating the data','error'=>$validator->errors()]);            
        }
       
        $userId = auth()->user()->id;
        $user = User::find($userId); 
        
        // Save all pictures
		$file = $request->file('photo');
        
		if (!empty($file)) {
			// Post Picture in database
			$user->photo = $file;
			$user->save();
            //Create full link for image
           $user->picture=imgUrl($user->photo);
           return response()->json(['status'=>200,'message'=>'Your photo or avatar have been updated','record'=>$user]); 
		}
		
	}
    /**
	 * Delete the User's photo
	 *
     ** @param $userId
	 */
	public function deletePhoto(Request $request)
	{
        // Get User
		$user = null;
       
        $userId = auth()->user()->id;
        $user = User::find($userId);
        

        if (!isset($user) || empty($user)) {
			  return response()->json(['status'=>404,'message'=>'User not found']);
		}
        // Remove all the current user's photos, by removing his photo directory.
		$destinationPath = substr($user->photo, 0, strrpos($user->photo, '/'));
		if ($this->disk->exists($destinationPath)) {
			$this->disk->deleteDirectory($destinationPath);
		}
		
		// Delete the photo path from DB
		$user->photo = null;
		$user->save();

        //Send Response
		 return response()->json(['status'=>200,'message'=>'Your photo or avatar has been deleted']);

    }

  

    /**
	 * Update User Setting
     *
	 */

    public function updateSettings(Request $request){

        //Apply validation on fields
        $validator = Validator::make($request->all(), [
                'password'     => [
									'required',
									'min:' . config('larapen.core.passwordLength.min', 6),
									'max:' . config('larapen.core.passwordLength.max', 60),
									'dumbpwd',
									'confirmed'
								    ],
				'password_confirmation'=>['required','same:password']
			    
              ]);

		//If validation fails
        if ($validator->fails())
        { 
            $message = $validator->errors()->all();
            // send validation errors
            return response()->json(['status'=>404,'message'=>'An error occurred while validating the data','error'=>$validator->errors()]);            
        }

        // Get User
		$user = User::find(auth()->user()->id);
		
		// Update

		if ($request->filled('password')) {
			$user->password = Hash::make($request->input('password'));
		}
		$user->save();
        //Send Response
         return response()->json(['status'=>200,'message'=>'Account settings has updated successfully']);
    }

     /**
     *  User Profile 
     *
     */
        public function Profile(Request $request){
             //Get authorised user
             if(!isset(auth()->user()->id)){
                  return  $res=response()->json(['status'=>'404','message'=>'Please login first']);
             }

             $user_id=auth()->user()->id;

             //Get User and all the count values 

            $user= DB::table('users')
                ->select('users.*',DB::raw("(SELECT count(posts.id) from posts where posts.user_id=$user_id and posts.archived=1)as archived"))
                   ->where('id',$user_id)  
                   ->first();

                   $user->photo=imgUrl($user->photo);
                   $user->myads=$this->Myposts('count');
                   $user->saved_post=$this->SavedAds('count');
                   $user->saved_search=$this->SavedSearch('count');
                   $user->pending_approval=$this->PendingApproval('count');  
                   $user->archived=$this->archivedAds('count');
                   $user->conversations=$this->Conversations('count');
                   
                   $user->Transactions=Payment::whereHas('post', function ($query) {
                        $query->currentCountry()->whereHas('user', function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        });
                    })
                    ->orderByDesc('id')->get()->count();

            //Send Response
            return  $res=response()->json(['status'=>'200','message'=>'','record'=>$user]);
                
        }
    /**
     *  User ads.
     *
     
     */
     
        public function Myposts($type=""){
           
            //Get authorised user
              $user_id=auth()->user()->id;

              $posts=DB::table('posts')
                   ->select('posts.*',DB::raw("(SELECT filename FROM pictures WHERE pictures.post_id = posts.id limit 1) as filename"))
                   ->where('user_id',$user_id)
                   ->where('reviewed',1)
                   ->paginate($this->perPage);
              if($type=='count'){
                  return $posts->count();
              }

                if(count($posts)<=0){
             return response()->json(['status'=>'404','message'=>'No data found','record'=>$posts]); 
            }
             
             foreach($posts as $post){
                 
                // creating full link for  ads posts image
               
               if ($post->filename) {
                     $postImg = imgUrl($post->filename, 'medium');
                    } else {
               // send default image if no image in posts
                     $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                   }
               
                $post->filename=$postImg;
                $data[]=$post;   
             }

            $final_res =$data;
            $final_res['currentPage']  = $posts->currentPage();
            $final_res['last_page']    = $posts->lastPage();
            $final_res['total_record'] = $posts->total();
            $final_res['per_page']     = $posts->perPage();

            //Send Response
            
            return  $res=response()->json(['status'=>'200','message'=>'','record'=>$final_res]);

        }

     /**
     *  favourite ads.
     *
     
     */
      public function SavedAds($type=''){
            //Get authorised user
              $user_id=auth()->user()->id;

              $posts=DB::table('posts')
               ->select('posts.*','saved_posts.user_id',DB::raw("(SELECT pictures.filename FROM pictures
                         WHERE pictures.post_id = posts.id limit 1) as filename") )
               ->Join('saved_posts', 'posts.id', '=', 'saved_posts.post_id')
               ->where('saved_posts.user_id',$user_id)->paginate($this->perPage);
              $data=[];

              if($type=='count'){
                  return $posts->count();
              }

                //Check Data is not empty
                if (count($posts)<=0) {
                    return response()->json(['status'=>'404','message'=>'No record found','posts'=>$data]);
                }

                 foreach($posts as $post){
                    
                    //creating  full link for ads post image 
                    if ($post->filename) {
                            $postImg = imgUrl($post->filename, 'medium');
                            } else {
                                $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                            }
                    $post->filename=$postImg;
                    $data[]=$post;

                 }
                 $final_res =$data;
                $final_res['currentPage']  = $posts->currentPage();
                $final_res['last_page']    = $posts->lastPage();
                $final_res['total_record'] = $posts->total();
                $final_res['per_page']     = $posts->perPage();
                
                 //Send Response
                    return  $res=response()->json(['status'=>'200','message'=>'','record'=>$final_res]);

        }

    /**
     * Remove favourite ads.
     *
     */

     public function Remove_favourite(Request $request,$id=""){

        if (empty($id)) {
		 return response()->json(['status'=>'404','message'=>'Post not found']);
		}
        $ids=explode(',',$id);
        
        //check save post
			$savedPosts = SavedPost::where('user_id', auth()->user()->id)->whereIn('post_id', $ids);
			if ($savedPosts->count() > 0) {
				
			 $savedPosts->delete();
             //Send Response
             return  $res=response()->json(['status'=>'200','message'=>' Ad has been deleted successfully.']);
                      
		 }
         else{
              return  $res=response()->json(['status'=>'404','message'=>'Post Not Found.']);
         }
     }

    /**
     *Delete User ads Post .
     *
     *
     */  
     public function RemovePost(Request $request,$postId=""){
        //Check post id
        if (empty($postId)) {
		 return response()->json(['status'=>'404','message'=>'Post not found']);
		}
        $ids=explode(',',$postId);

  
        //Get Post
        $post = Post::where('user_id', auth()->user()->id)->whereIn('id', $ids);
        if(!$post){
            return  $res=response()->json(['status'=>'404','message'=>'Post nto found']);
        }
        // Delete Entry
		 $nb = $post->delete();

         return  $res=response()->json(['status'=>'200','message'=>'Post has been deleted successfully']);

     }

    /**
	 * Remove Pending Approval Post
     *
	 */

    public function RemovePendingApproval(Request $request,$postId=""){
        if (empty($postId)) {
		 return response()->json(['status'=>'404','message'=>'Post not found']);
		}
        $ids=explode(',',$postId);
        //Get Post
        $post = Post::where('user_id', auth()->user()->id)->where('reviewed',1)->whereIn('id', $ids);
        if(!$post){
            return  $res=response()->json(['status'=>'404','message'=>'Post nto found']);
        }
        // Delete Entry
		 $nb = $post->delete();

         return  $res=response()->json(['status'=>'200','message'=>'Post has been deleted successfully']);

    }
     /**
     *Remove Archeived User ads Post .
     *
     *
     */ 
    public function RemoveArchivedPost(Request $request,$postId=""){

         if (empty($postId)) {
		 return response()->json(['status'=>'404','message'=>'Post not found']);
		}
        $ids=explode(',',$postId);
        //Get Post
        $post = Post::where('user_id', auth()->user()->id)->where('archived',1)->whereIn('id', $ids);
        if(!$post){
            return  $res=response()->json(['status'=>'404','message'=>'Post nto found']);
        }
        // Delete Entry
		 $nb = $post->delete();

         return  $res=response()->json(['status'=>'200','message'=>'Post has been deleted successfully']);

    }
      /**
	 * Delete Conversation
	 *
	 * @param null $conversationId
	 * 
	 */

      public function RemoveConversation($conversationId=""){

          if (empty($conversationId)) {
	    	 return response()->json(['status'=>'404','message'=>'No messages found']);
	    }
          // Get Entries ID
		  $ids = [];
          $ids=explode(',',$conversationId);
  
         // Delete
            $nb = 0;
            foreach ($ids as $item) {
                // Get the conversation
                $message = Message::where('id', $item)
                         ->byUserId(auth()->user()->id)
                         ->first();

                if (!empty($message)) {
                    if (empty($message->deleted_by)) {
                        // Delete the Entry for current user
                        $message->deleted_by = auth()->user()->id;
                        $message->save();
                        $nb = 1;
                    } else {
                        // If the 2nd user delete the Entry,
                        // Delete the Entry (definitely)
                        if ($message->deleted_by!= auth()->user()->id) {
                            $nb = $message->delete();
                        }
                    }
                }
                else{
                    return response()->json(['status'=>'404','message'=>'Messages not found']);
                }
            }
            return response()->json(['status'=>'200','message'=>'Messages has been deleted successfully']);

     }

      /**
	 * Delete Saved searches
	 *
	 * @param null $postId
	 * 
	 */

     public function RemoveSavedSearch($searchId=null){

          if (empty($searchId)) {
	    	 return response()->json(['status'=>'404','message'=>'No Saved search found']);
	    }
        $ids = [];
        $ids=explode(',',$searchId);

         $SavedSearch=SavedSearch::where('user_id',auth()->user()->id)->whereIn('id',$ids);
         if($SavedSearch){
             $SavedSearch->delete();
             return response()->json(['status'=>'200','message'=>'Remove successfully']);
         }
         return response()->json(['status'=>'404','message'=>'No post found']);
         // Delete

     }

     /**
     *Archeived User ads Post .
     *
     *
     */ 

     public function getArchivedPosts(Request $request,$postId=""){

         //Check Post Id 
         if (is_numeric($postId) && $postId > 0) {
             $post = Post::where('user_id', auth()->user()->id)->where('id', $postId)->first();
				if (empty($post)) {
				   return  $res=response()->json(['status'=>'404','message'=>'Post not found']);
				}
       
            if ($post->archived != 1) {

                $post->archived = 1;
				$post->archived_at = Date::now();
				$post->archived_manually = 1;
				$post->save();

                $archivedPostsExpiration = config('settings.listing.manually_archived_posts_expiration', 180);
						
				$message = t('offline_putting_message', [
							'postId'  => $postId,
							'dateDel' => $post->archived_at
								->addDays($archivedPostsExpiration)
								->formatLocalized(config('settings.app.default_date_format')),
						]);

                // Send Confirmation Email or SMS  
                    if (config('settings.mail.confirmation') == 1) {
                        try {
                            $post->notify(new PostArchived($post, $archivedPostsExpiration));
                        } catch (\Exception $e) {
                            flash($e->getMessage())->error();
                        }
                    }

                     return  $res=response()->json(['status'=>'200','message'=>$message,'record'=>$post]);

            }
            else{
                 return  $res=response()->json(['status'=>'404','message'=>'The ad is already offline']);
            }
            

         }
         return  $res=response()->json(['status'=>'404','message'=>'Post not found']);
  
     }

   
     /**
     *.Un-Archived Posts 
     *
     
     */

     public function getUnArchivedPosts(Request $request,$postId=""){
         //Check Post Id 
         if (is_numeric($postId) && $postId > 0) {
             $post = Post::where('user_id', auth()->user()->id)->where('id', $postId)->first();
				if (empty($post)) {
				   return  $res=response()->json(['status'=>'404','message'=>'Post not found']);
			}
            if ($post->archived != 0) {
                $post->archived = 0;
                $post->archived_at = null;
                $post->deletion_mail_sent_at = null;

                if ($post->archived_manually != 1) {
                    $post->created_at = Date::now();
                    $post->archived_manually = 0;
                }
				$post->save();

                if ($post->archived == 0) {
						
						
						// Send Confirmation Email or SMS
						if (config('settings.mail.confirmation') == 1) {
							try {
								$post->notify(new PostRepublished($post));
							} catch (\Exception $e) {
								flash($e->getMessage())->error();
							}
						}
                         return  response()->json(['status'=>'200','message'=>'The repost has done successfully','record'=>$post]);
					} else {
					return  response()->json(['status'=>'404','message'=>'The repost has failed']);
				}

          }
          else {
			   return response()->json(['status'=>'404','message'=>'The ad is already online']);
			}
         }
         else {
				return  response()->json(['status'=>'404','message'=>'Post not found']);
			}


     }

    /**
     * Saved search user.
     *
     
     */
        public function SavedSearch($type=""){
             //Get authorised user
              $user_id=auth()->user()->id;
            
             //get Save search
             $data=SavedSearch::where('user_id',$user_id)->paginate($this->perPage);

             if($type=='count'){
                 return $data->count();
             }

             if(count($data)<=0){
                  return  $res=response()->json(['status'=>'404','message'=>'You have no saved search','record'=>$data]);
             }

             foreach($data as $saved){
                 $response[]=$saved;
             }

              $final_res =$response;
              $final_res['currentPage']  = $data->currentPage();
              $final_res['last_page']    = $data->lastPage();
              $final_res['total_record'] = $data->total();
              $final_res['per_page']     = $data->perPage();

              //Send Response
                 return  $res=response()->json(['status'=>'200','message'=>'','record'=>$final_res]);
        }

     /**
     * Pending Approval of posts .
     *
     
     */
        public function PendingApproval($type=""){
             //Get authorised user
              $user_id=auth()->user()->id;
             // Get pending approval data
              $posts=DB::table('posts')
               ->select('posts.*',DB::raw("(SELECT pictures.filename FROM pictures
                         WHERE pictures.post_id = posts.id limit 1) as filename"))
               ->where('posts.user_id',$user_id)
               ->where('posts.reviewed',0)->paginate($this->perPage);
             
            
             if($type=='count'){
                 return $posts->count();
             }

              if(count($posts)<=0){
                  return  $res=response()->json(['status'=>'404','message'=>'You have no Pending Approval','record'=>$posts]);
             }

             foreach($posts as $post){
                // creating full link for  ads posts image
               if ($post->filename) {
					 $postImg = imgUrl($post->filename, 'medium');
					} else {
               // send default image if no image in posts
					 $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
					}
              
                $post->filename=$postImg;
                $data[]=$post;   
             }

            $final_res=$data;
            $final_res['currentPage']  = $posts->currentPage();
            $final_res['last_page']    = $posts->lastPage();
            $final_res['total_record'] = $posts->total();
            $final_res['per_page']     = $posts->perPage();

             

              //Send Response
                 return  $res=response()->json(['status'=>'200','message'=>'','record'=>$final_res]);
        }
    /**
     * user Archived Ads.
     *
     
     */

        public function archivedAds($type=""){
            //Get authorised user
              $user_id=auth()->user()->id;
             // Get pending approval data
              $posts=DB::table('posts')
               ->select('posts.*',DB::raw("(SELECT pictures.filename FROM pictures
                         WHERE pictures.post_id = posts.id limit 1) as filename"))
               ->where('posts.user_id',$user_id)
               ->where('posts.archived',1)->paginate($this->perPage);
             
            if($type=='count'){
                return $posts->count();
            }

              if(count($posts)<=0){
                  return  $res=response()->json(['status'=>'404','message'=>'No Data Found','record'=>$posts]);
             }

             foreach($posts as $post){
                // creating full link for  ads posts image
               if ($post->filename) {
					 $postImg = imgUrl($post->filename, 'medium');
					} else {
               // send default image if no image in posts
					 $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
					}
              
                $post->filename=$postImg;
                $data[]=$post;   
             }
             

              //Send Response
                 return  $res=response()->json(['status'=>'200','message'=>'','record'=>$posts]);
        }

    /**
     * User Conversations list.
     *
     
     */
     

        public function Conversations($type=""){

            // Conversations
		    $conversations = Message::with('latestReply')
			->whereHas('post', function ($query) {
				$query->currentCountry();
			})
			->byUserId(auth()->user()->id)
			->where('parent_id', 0)
			->orderByDesc('id')->get();

            if($type=='count'){
                return $conversations->count();
            }
            if(count($conversations)<=0){
                 return  $res=response()->json(['status'=>'404','message'=>'No Data Found','record'=>$conversations]);
            }
            //Send Response
                return  $res=response()->json(['status'=>'200','message'=>'','record'=>$conversations]);
        }

    /**
    * User payments list.
    *
    
    */

        public function Transactions(Request $request){
            // Payments
            $transactions = Payment::whereHas('post', function ($query) {
                $query->currentCountry()->whereHas('user', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
            })
            ->with(['post', 'paymentMethod', 'package' => function ($builder) { $builder->with(['currency']); }])
            ->orderByDesc('id')->get();

             if(count($transactions)<=0){
                 return  $res=response()->json(['status'=>'404','message'=>'No Data Found','record'=>$transactions]);
            }
            //Send Response
            
            return  $res=response()->json(['status'=>'200','message'=>'','record'=>$transactions]);
        }



    /**
     * Close  user Account
     *
     
     */

     public function CloseAccount(Request $request){
         
         if (request()->input('close_account_confirmation') == 1) {
             
             // Get User
			$user = User::findOrFail(auth()->user()->id);

            // Don't delete admin users
			if ($user->can(Permission::getStaffPermissions())) {
				
			  return  $res=response()->json(['status'=>'404','message'=>'admin_users_cannot_be_deleted']);
			}
            // Delete User
		     $user->delete();
              return  $res=response()->json(['status'=>'200','message'=>'Your account has been deleted. We regret you. Re-register if that is a mistake']);
         }

         
     }

     /**
     * Logout user.
     *
     
     */
     
    public function logout(){
        
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['status'=>'200','message'=>'You have been logged out. See you soon.']);
    }


}