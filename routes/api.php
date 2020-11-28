<?php

// use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



	//Api  Registration Routes...
	// Route::get('/register', 'Api\UserController@register');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

 
// Auth


Route::post('/login', 'API\UserController@login');
// Registration Routes...
Route::post('/register', 'API\UserController@register');
// Password Reset Routes...
Route::post('/forgotPassword', 'API\ForgotPasswordController@sendResetLinkEmail');

    
//Create Post Step-1
Route::post('/create/{tmpToken?}', 'API\PostsController@CreatePost');

//Create Post Step-2
Route::post('/photo/{tmpToken?}', 'API\PostsController@AddPostPhoto');


//Finish add Post finish
Route::post('/finish/{tmp_token?}', 'API\PostsController@finish');



//Full posts data 
 Route::get('/ads/{post_id?}', 'API\HomeController@ads');
 Route::get('/ads2/{post_id?}', 'API\HomeController@ads2');
 //Posts search Routs...
Route::post('/posts', 'API\HomeController@Posts');

Route::post('/posts2', 'API\HomeController@Posts2');

//Get categories dynamic fields
Route::post('/customFields', 'API\HomeController@CustomFields');


 Route::get('/search', 'API\HomeController@search');

//App dat
 Route::get('/appData', 'API\HomeController@appData');
 // HOMEPAGE
 Route::get('/Home', 'API\HomeController@Home');

 Route::get('/location', 'API\HomeController@getLocations');
 Route::get('/categories', 'API\HomeController@getCategories');
 // Latest post 
 Route::get('/latestposts', 'API\HomeController@getLatestPosts');
 
 // Authentication Routes...

Route::group(['middleware' => 'auth:api'], function(){


 // category through parent category
 Route::get('/category/{cat_id?}', 'API\HomeController@category');
 //Posts search Routs...

 //User profile Route
 Route::get('/profile', 'API\UserController@Profile');

 //User ads 
 Route::get('/myposts', 'API\UserController@Myposts');

//Saved posts
 Route::get('/favourite', 'API\UserController@SavedAds');

 //Edit Post 
Route::post('/edit/{postId?}', 'API\PostsController@EditPost');

//Delete Post Picture
Route::get('/deletePhoto/{postId?}/{pictureId?}', 'API\PostsController@DeletePostPhoto');
//Saved search
 Route::get('/savedSearch', 'API\UserController@SavedSearch');
  
 //pending approval posts
 Route::get('/pendingApproval', 'API\UserController@PendingApproval');

 //archived ads
  Route::get('/archived', 'API\UserController@archivedAds');
  
  //Conversations
 Route::get('/conversations', 'API\UserController@Conversations');
// Route::get('/search', 'API\HomeController@search');

//transactions Route
Route::get('/transactions', 'API\UserController@Transactions');
 // Save posts
 Route::post('/save_post', 'API\HomeController@save_post');

 //Update user Data

Route::post('/update', 'API\UserController@updateDetails');
//Upload avtar
Route::post('/upload', 'API\UserController@updatePhoto');
//Remove Avtar
Route::post('/Remove', 'API\UserController@deletePhoto');
//Delete User ads Post
Route::get('/RemovePost/{postId?}', 'API\UserController@RemovePost');

//Delete Saved post
  Route::get('/Removefavourite/{id?}', 'API\UserController@Remove_favourite');

// Delete Pending Approval posts
 Route::get('/RemovePending/{postId?}', 'API\UserController@RemovePendingApproval');
// Delete Archieved Post
  Route::get('/RemoveArchived/{postId?}', 'API\UserController@RemoveArchivedPost');
//Delete User Conversation
  Route::get('/deleteMessage/{conversationId?}', 'API\UserController@RemoveConversation');
//Delete Saved searches 
Route::get('/removeSavedSearch/{searchId?}', 'API\UserController@RemoveSavedSearch');
//Archieved Post 
  Route::get('/offline/{postId?}', 'API\UserController@getArchivedPosts');

//Unarchieved Post 
Route::get('/repost/{postId?}', 'API\UserController@getUnArchivedPosts');
//Update user settings
Route::post('/settings', 'API\UserController@updateSettings');

//Conversation
Route::post('/sendMessage/{conversationId?}', 'API\ConversationsController@sendMessage');

//Close Account
Route::post('/close', 'API\UserController@CloseAccount');

 //Logout Routes
 Route::get('/logout', 'API\UserController@logout');
 
 
});
  
  

