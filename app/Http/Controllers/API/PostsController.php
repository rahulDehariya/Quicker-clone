<?php

namespace App\Http\Controllers\API;

use App\Helpers\Ip;
use App\Helpers\UrlGen;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Post\CreateOrEdit\Traits\AutoRegistrationTrait;
use App\Http\Controllers\Post\CreateOrEdit\Traits\PricingTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostPhotoRequest;
use App\Http\Requests\PhotoRequest;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Package;
use App\Models\City;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Models\Picture;
use Validator;
use App\Http\Controllers\FrontController;
use App\Models\Scopes\ReviewedScope;
use App\Notifications\PostActivated;
use App\Notifications\PostNotification;
use App\Notifications\PostReviewed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Http\Controllers\Post\CreateOrEdit\MultiSteps\Traits\EditTrait;

class PostsController extends FrontController
{

    use EditTrait, VerificationTrait, PricingTrait, CustomFieldTrait, AutoRegistrationTrait;

    public $package = null;

    /**
	 * CreateController constructor.
	 */

    public function __construct()
	{
		parent::__construct();
		
	}

    /**
	 * Store a new Post.
	 *
	 * @param PostRequest $request
	 * @param null $tmpToken
	 *
	 */

    public function CreatePost(CreatePostRequest $request, $tmpToken = null){
        // Check possible Update
		if (!empty($tmpToken)) {
			return $this->UpdatePostForm($tmpToken, $request);
		}

        
        // Get the Post's City
		$city = City::find($request->input('city_id', 0));
		if (empty($city)) {
            return response()->json(['status'=>'404','message'=>'posting ads is disabled']);
			
		}
        

        // New Post
		$post = new Post();
		$input = $request->only($post->getFillable());
		foreach ($input as $key => $value) {
			$post->{$key} = $value;
		}
        //Get Post field
        $post->country_code = config('country.code');
		$post->user_id = (auth()->check()) ? auth()->user()->id : 0;
		$post->negotiable = $request->input('negotiable');
		$post->phone_hidden = $request->input('phone_hidden');
		$post->lat = $city->latitude;
		$post->lon = $city->longitude;
		$post->ip_addr = Ip::get();
		$post->tmp_token = md5(microtime() . mt_rand(100000, 999999));
		$post->verified_email = 1;
		$post->verified_phone = 1;
		$post->reviewed = 0;

		// Save
		$post->save();
        // Custom Fields
		$this->createPostFieldsValues($post, $request);
        // Get Inserted Id
		$post->id;

        // Send Response

        return response()->json(['status'=>'200','message'=>'Your ad has been created','record'=>$post]);
    
    }
    /**
	 * Store a new ad post photo.
	 *
	 * @param $postIdOrToken
	 * @param PhotoRequest $request
	 * 
	 */

    public function AddPostPhoto(PhotoRequest $request,$tmp_token=""){

        
        //get post_id   
        $post_id=$request->input('post_id');

        if(!empty($tmp_token)){
         
        //Get post through token
            $post = Post::currentCountry()->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				   ->where('id', $post_id)
				   ->where('tmp_token', $tmp_token)->first(); 
        }
        else{
            $user_id=0;
            if (Auth::guard('api')->check()) {
                $user_id=Auth::guard('api')->user()->id;
            }
            
            //Get post through User and post id
            $post = Post::currentCountry()->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				  ->where('user_id', $user_id)
				  ->where('id', $post_id)
				  ->first();
        }

        if (empty($post)) {
             return response()->json(['status'=>'404','message'=>'Post not found']); 
		}

        // Get pictures limit
		$countExistingPictures = Picture::where('post_id', $post->id)->count();

		$picturesLimit = (int)config('settings.single.pictures_limit', 5) - $countExistingPictures;
		
		// Get pictures initial position
		$latestPosition = Picture::where('post_id', $post->id)->orderBy('position', 'DESC')->first();
		$initialPosition = (!empty($latestPosition) && (int)$latestPosition->position > 0) ? (int)$latestPosition->position : 0;
		$initialPosition = ($countExistingPictures >= $initialPosition) ? $countExistingPictures : $initialPosition;

        // Save all pictures
		$pictures = [];
        $files = $request->file('pictures');
        $data=[];

        //Check count of files
        if ($files) {
			foreach ($files as $key => $file) {
				if (empty($file)) {
					continue;
				}
				
				// Delete old file if new file has uploaded
				// Check if current Post have a pictures
				$picturePosition = $initialPosition + (int)$key + 1;
				$picture = Picture::where('post_id', $post->id)->where('id', $key)->first();
				if (!empty($picture)) {
					$picturePosition = $picture->position;
					$picture->delete();
				}
				
				// Post Picture in database
				$picture = new Picture([
					'post_id'  => $post->id,
					'filename' => $file,
					'position' => $picturePosition,
				]);
				if (isset($picture->filename) && !empty($picture->filename)) {
					$picture->save();
				}
				
				$pictures[] = $picture;
				
				// Check the pictures limit
				if ($key >= ($picturesLimit - 1)) {
					break;
				}
                $data['filename'][] = imgUrl($picture->filename, 'medium');
                $data['id'][]=$picture->id;
			}
            return response()->json(['status'=>'200','message'=>'Uploaded file  successfully','record'=>$data]); 
		}

        //Send response
         return response()->json(['status'=>'404','message'=>'Please select file for upload']);
      

    }

    /**
	 * Confirmation
	 *
	 * @param $tmpToken $post_id
	 *
	 */

    public function finish(Request $request,$tmp_token=""){
        //check tep_token
        if($tmp_token){
            $post_id=$request->input('post_id');
            
            //Get the Post
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
			    	->where('id', $post_id)
				    ->where('tmp_token', $tmp_token)
			    	->first();
            if (empty($post)) {
				return response()->json(['status'=>'404','message'=>'Post not found']);
			}
            // Apply finish actions
			$post->tmp_token = null;
			$post->save();

            //Send response 
              return response()->json(['status'=>'200','message'=>'Your ad has been created successfully','record'=>$post]);
        }
        
           return response()->json(['status'=>'404','message'=>'Post not found']);
    }
    /**
	 * Update the Post Through API
	 *
	 * @param $postId
	 * @param PostRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */

    public function EditPost(CreatePostRequest $request, $postId = null){
        //check postId
        if(!empty($postId)){
             return $this->UpdatePost($postId, $request);
        }
       
    }
    	/**
	 * Delete picture
	 *
	 * @param $postIdOrToken
	 * @param $pictureId
	 * @param Request $request
	 * 
	 */

    public function DeletePostPhoto($postId="",$pictureId=""){
        
        //Check postId and pictureId
        if(empty($postId) && empty($pictureId)){
             return response()->json(['status'=>'404','message'=>'Post not found']);
        }
         $user_id=0;
            if (Auth::guard('api')->check()) {
                $user_id=Auth::guard('api')->user()->id;
            }

        //Get post
        $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
               ->where('user_id', $user_id)
               ->where('id', $postId)->first();

        if (empty($post)) {
			return response()->json(['status'=>'404','message'=>'Post not found']);
		}

        //Get Picture
        $picture = Picture::withoutGlobalScopes([ActiveScope::class])->find($pictureId);
		if (!empty($picture)) {
			$nb = $picture->delete();
		}
        //Send Response 
        return response()->json(['status'=>'200','message'=>'The picture has been deleted']);
    }
         

}