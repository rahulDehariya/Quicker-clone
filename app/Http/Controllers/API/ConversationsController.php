<?php

namespace App\Http\Controllers\API;
use App\Events\PostWasVisited;
use App\Helpers\ArrayHelper;
use App\Helpers\UrlGen;
use App\Http\Requests\ReplyMessageRequest;
use App\Http\Requests\SendMessageRequest;
use App\Models\User;
use App\Models\Post;
use App\Models\Message;
use App\Notifications\ReplySent;
use App\Notifications\SellerContacted;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Http\Controllers\FrontController;

class ConversationsController extends FrontController
{
     /**
	 * ConversationsController constructor.
	 */
    public function __construct()
	{
		parent::__construct();
	}

    /**
	 * Contact the Post's Author
	 *
	 * @param $postId
	 * @param SendMessageRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function sendMessage(SendMessageRequest $request,$conversationId="")
	{
    
        // Get the Post
        $postId=$request->input('post_id');
		$post = Post::unarchived()->find($postId);


        if(empty($post))
        {
           // send  errors
            return response()->json(['status'=>'404','message'=>'No post found']);
        }
        $parent_id=0;

        if(!empty($conversationId)){
            // Get Conversation
            $conversation = Message::find($conversationId);

            if(empty($conversation))
            {
                return response()->json(['status'=>'404','message'=>'No messages found']);
            }

            // Get Recipient Data
            if ($conversation->from_user_id != auth()->user()->id) {
                $toUserId = $conversation->from_user_id;
                $toName   = $conversation->from_name;
                $toEmail  = $conversation->from_email;
                $toPhone  = $conversation->from_phone;
            } else {
                $toUserId = $conversation->to_user_id;
                $toName   = $conversation->to_name;
                $toEmail  = $conversation->to_email;
                $toPhone  = $conversation->to_phone;
            }

            // Don't reply to deleted (or non exiting) users
	    	if (config('settings.single.guests_can_post_ads') != 1 && config('settings.single.guests_can_contact_ads_authors') != 1) {
			    if (User::where('id', $toUserId)->count() <= 0) {    
				    return response()->json(['status'=>'404','message'=>'This user no longer exists.Maybe the users account has been disabled or deleted.']);
			    }
		    }
           
            $parent_id    = $conversation->id;
            

        }
        
        // New Message
		$message=new Message();
        $input=$request->only($message->getFillable());

        foreach($input as $key=>$value){
            $message->{$key}=$value;
        }

        $message->post_id      = $post->id;
        $message->parent_id    = $parent_id;
		$message->from_user_id = auth()->check() ? auth()->user()->id : 0;
		$message->to_user_id   = $post->user_id;
		$message->to_name      = $post->contact_name;
		$message->to_email     = $post->email;
		$message->to_phone     = $post->phone;
		$message->subject      = $post->title;
        $message->message = $request->input('message');

        // Save
		$message->save();

        // Save and Send user's resume
		if ($request->hasFile('filename')) {
			$message->filename = $request->file('filename');
			$message->save();
		}

        // Send a message to publisher
        try{
            if(!isDemo()){
                $post->notify(new SellerContacted($post, $message));

                //Send Response
                return response()->json(['status'=>'200','message'=>'Your message has been sent. Thank you!']);
            }
        }
        catch(\Exception $e){
            // $resMessage=$e->getMessage())->error();
            // return response()->json(['status'='404','message'=>$resMessage]);
        }


    }

}