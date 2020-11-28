<?php
namespace App\Http\Controllers\API;

use App\Helpers\ArrayHelper;
use App\Models\Post;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\SubAdmin1;
use App\Models\City;
use App\Models\User;
use App\Models\Field;
use App\Models\SavedPost;
use App\Models\PostValue;
use App\Models\CategoryField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use Illuminate\Support\Facades\DB;

class HomeController extends FrontController
{
    use  CustomFieldTrait;

    /**
	 * CreateController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Check Country URL for SEO
		$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		
	}
    /**
	 * Home data.
	 */

	public function Home(Request $request){

		$value=[];
        //Get all the home location data 
		
		$LatestPosts =$this->getLatestPosts($request,'return');
		
		// Send home data response 
	
	     return response()->json(['status'=>'200','message'=>'','LatestPosts'=>$LatestPosts]);
		
	}
    /**
	 * Get App Data
	 *
	 * @param array $value
	 */

    public function appData(Request $request){
        $value=[];
        //Fetch all categories and their sub categories data
        $categories =$this->getCategories('return');

        //Get All cities
        $location =$this->getLocations($value,'return');
        //image url
        $img_url=imgUrl('');
        // Send   response 
	
	     return response()->json(['status'=>'200','message'=>'','location'=>$location,'categories'=>$categories,'img_url'=>$img_url]);
    }

    /**
	 * Fetch all the cities
	 *
	 * @param array $value
	 */

	public function getLocations($value=[],$type="")
	{
		// Get the default Max. Items
		$maxItems = 14;
		if (isset($value['max_items'])) {
			$maxItems = (int)$value['max_items'];
		}
		
		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($value);
		
		// Modal - States Collection
		$cacheId = config('country.code') . '.home.getLocations.modalAdmins';
		$modalAdmins = Cache::remember($cacheId, $cacheExpiration, function () {
			return SubAdmin1::currentCountry()->orderBy('name')->get(['code', 'name'])->keyBy('code');
		});
		
		
		// Get all cities
		$cacheId = config('country.code') . 'home.getLocations.cities';
		$cities = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
			return City::currentCountry()->orderBy('population', 'DESC')->orderBy('name')->get();
		});
        
		// Send response 
		if($type=='return'){
		    return $cities;
		}

		    return response()->json(['status'=>'200','message'=>'','record'=>$cities]);
	}

	/**
	 * Get latest posts
	 *
	 * @param array $value
	 */
	protected function getLatestPosts(Request $request,$return="")
	{
		$type = 'latest';
	 
		// Get the default Max. Items
		$maxItems = 5;
		
		// Get the default orderBy value
		$orderBy = 'date';
		
		
		// Get latest posts
		$cacheId = config('country.code') . '.home.getPosts.' . $type;
		$query =DB::table('posts')
               ->select('posts.*','pictures.filename' )
               ->leftJoin('pictures', 'posts.id', '=', 'pictures.post_id')
               ->orderBy('posts.id', 'DESC')
               ->limit($maxItems);
        // Filter for location based post
        if($request->input('location')){
            $query->where('posts.city_id', $request->input('location'));
        }

        $posts = $query->get();

        // Check posts are empty or not
		if (!empty($posts)) {
			foreach($posts as $post){
            
            //creating  full link for ads post image 
              if ($post->filename) {
					 $postImg = imgUrl($post->filename, 'medium');
					} else {
						$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
					}
              $post->post_img=$postImg;
              $data[]=$post;

            }
		}
		else{
            // Send no record found response
			 return response()->json(['status'=>'404','message'=>'No record found','posts'=>$data]);
		}

		//Sending response

		if($return=='return'){
		    return $data;
		}

		   return response()->json(['status'=>'200','message'=>'','record'=>$data]);
		
	}
    /**
	 * Get selected ads post full  data
	 *
	 * @param array $value
	 */
     public function ads($post_id=""){
        //Checking post id not empty
       if (empty($post_id) || !is_numeric($post_id)) {
		   return response()->json(['status'=>'404','message'=>'No post found']);
		}
        //check  authorised user 
            $user_id=0;
            if(Auth::guard('api')->check()){
                $user_id=Auth::guard('api')->user()->id;
            }
        //Getting ads posts data through $post_id
         $posts =DB::table('posts')
               ->select('posts.*',DB::raw("(SELECT post_id from saved_posts where saved_posts.post_id=posts.id and saved_posts.user_id=$user_id) as saved"))
               ->where('id',$post_id )  
               ->first();
            if(empty($posts)){
                return response()->json(['status'=>'404','message'=>'No record found']);
            }
            $saved=0;
            if($posts->saved){
                $saved=1;
            }
            $posts->saved=$saved;
            //Get all images of post
            $pictures=DB::table('pictures')
                     ->select('filename')
                     ->where('post_id',$post_id)
                     ->get();
            if(count($pictures)>0){
              foreach($pictures as $post_img){
                    
                 $postImg[]= imgUrl($post_img->filename , 'medium');
             }
            }
            else{
                $postImg=imgUrl(config('larapen.core.picture.default'), 'medium');
            }
            $posts->postImg=$postImg;

            $data=$posts;  

          // Sending response
           
            return response()->json(['status'=>'200','message'=>'','record'=>$data]);

     }

     public function ads2($post_id=""){
        //Checking post id not empty
       if (empty($post_id) || !is_numeric($post_id)) {
		   return response()->json(['status'=>'404','message'=>'No post found']);
		}
        //check  authorised user 
            $user_id=0;
            if(Auth::guard('api')->check()){
                $user_id=Auth::guard('api')->user()->id;
            }
        //Getting ads posts data through $post_id
         $posts =DB::table('posts')
               ->select('posts.*',DB::raw("(SELECT post_id from saved_posts where saved_posts.post_id=posts.id and saved_posts.user_id=$user_id) as saved"))
               ->where('id',$post_id )  
               ->first();
            if(empty($posts)){
                return response()->json(['status'=>'404','message'=>'No record found']);
            }
            $saved=0;
            if($posts->saved){
                $saved=1;
            }
            $posts->saved=$saved;
            //Get all images of post
            $pictures=DB::table('pictures')
                     ->select('filename')
                     ->where('post_id',$post_id)
                     ->get();
            if(count($pictures)>0){
              foreach($pictures as $post_img){
                    
                 $postImg[]= imgUrl($post_img->filename , 'medium');
             }
            }
            else{
                $postImg=imgUrl(config('larapen.core.picture.default'), 'medium');
            }
            $posts->postImg=$postImg;
            $posts->custom=[];
            $postFieldsValues =DB::table('post_values')
                              ->select('post_values.value','fields.name','fields_options.value as optionName')
                              ->leftJoin('fields_options', 'post_values.value', '=', 'fields_options.id')
                              ->Join('fields','fields.id','post_values.field_id')
                              ->where('post_values.post_id',$post_id)
                              ->get();
            
            if(count($postFieldsValues)>0){
                foreach($postFieldsValues as $customFields){
                   if($customFields->optionName==""){
                       $customFields->optionName=$customFields->value;
                   } 
                $fields[]=$customFields;
                
                }
                $posts->custom=$fields;
                
            }
		

            $data=$posts;  

          // Sending response
           
            return response()->json(['status'=>'200','message'=>'','record'=>$data]);

     }
	

    /**
	 * Get list of categories with their sub categories and sub categories sub categories
	 *
	 * @param array $value
	 */

    public function getCategories($type="")
	{
		
        //Get all categories with their respective sub categories
         $categories=   Category::with('children')->where('parent_id',0)->get();
        if($type=='return'){
			return $categories;
		}
		 return response()->json(['status'=>'200','message'=>'','categories'=>$categories]);

	}
    /**
	 * Get main categories data
	 *
	 * @param array $value
	 */

    public function category($cat_id){

      
        $maxItems=null;
        //Checking category id not empty
        if (empty($cat_id) || !is_numeric($cat_id)) {
		 return response()->json(['status'=>'404','message'=>'category not found']);
		}
        
        // Fetching category id data
	    if (!empty($maxItems)) {
				$categories = Category::trans()->where('parent_id', $cat_id)->take($maxItems)->orderBy('lft')->get();
			} else {
				$categories = Category::trans()->where('parent_id', $cat_id)->orderBy('lft')->get();
	  	}
       
         //Checking category id data
        if(count($categories)<=0){
             return response()->json(['status'=>'404','message'=>'Category not found. ']);
        }

        //Fetching category data
        
	 	foreach ($categories as  $cat) {
                // creating full link for  categories image
	 		$cat['categorie_img']=imgUrl($cat->picture, 'cat');
        
	 		$data[]=$cat;
          
	 	}
         // Sending response
         return response()->json(['status'=>'200','message'=>'','categories'=>$data]);

    }

    
    /**
	 * Get Searched data
	 *
	 * @param array $value
	 */

     public function search(Request $request){
        //Get all the request fields
        $q = $request->get('q');
        $l = $request->get('l');

        //Get auth user save posts
         // user post save data
            $searchData['save_post']=[]; 

            //check  authorised user 
            if (Auth::guard('api')->check()) {
                $user_id=Auth::guard('api')->user()->id;
               
                //Get auth user save posts
           
                $save_posts=DB::table('saved_posts')
                            ->select('saved_posts.*')
                            ->where('user_id', $user_id)
                            ->get();
                      
                if(count($save_posts)>0)
                {
                    $searchData['save_post']=$save_posts;
                }
             }

             //Get post count according to category

             $countPostsByCat = Category::countPostsByCategory();
           
			 $searchData['post_count']=$countPostsByCat;
        
        //Fetching data according to fields
         $query=DB::table('posts')
                ->select('posts.*',DB::raw("(SELECT filename FROM pictures
                         WHERE pictures.post_id = posts.id limit 1) as filename"),'categories.id')
               ->leftJoin('categories', 'posts.category_id', '=', 'categories.id');

                //if $q contains any value
                if ($q){
                     $query->where('categories.name', "like", "%".$q."%")
                           ->orWhere('posts.title', "like", "%".$q."%");
                 }
                
                 //if $location  have location id
                if ($l){
                    $query ->Join('cities', 'posts.city_id', '=', 'cities.id')
                           ->where('cities.id', $l);
                 }
                
                $data = $query->get();
                    
            //check search data if empty send no result response     
            if(count($data)<=0){
             return response()->json(['status'=>'404','message'=>'No result. Refine your search using other criteria.']); 
            }
             
             foreach($data as $post){
                // creating full link for  ads posts image
               if ($post->filename) {
					 $postImg = imgUrl($post->filename, 'medium');
					} else {
               // send default image if no image in posts
					 $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
					}
              
                $post->filename=$postImg;
                $searchData[]=$post;   
             }
             
                // Send response
                return response()->json(['status'=>'200','message'=>'','record'=>$searchData]);  

     }

     /**
         posts with filter
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
      public function Posts(Request $request){

        //Get all filters field
        $type=($request->input('type'))?$request->input('type'):"";
        $category=$request->input('category');
        $postedDate=$request->input('postedDate');
        $orderBy=$request->input('orderBy');
        $minPrice=$request->input('minPrice');
        $maxPrice=$request->input('maxPrice');
        $cf=$request->input('cf');  //Category filter
        $location=$request->input('location');

        //Post posted date
      
        if($postedDate){
            if($postedDate==2){
                $time='24 '.t('hours');
             
               $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
            elseif($postedDate==4){
                $time='3 '.t('days');
                $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
            elseif($postedDate==8){
                $time='7 '.t('days');
                $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
            elseif($postedDate==31){
                $time='30 '.t('days');
                $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
        }

        $categories_id=[];
        if($category){
        $posts=Category::with('children')->where('parent_id',$category)->get()->toArray();
        // Send response
        $cat_Arr = array();
        array_walk_recursive($posts, function ($value, $key) use (&$cat_Arr){
            if($key=='id')
            {
              $cat_Arr[] = $value;
            }
         }, $cat_Arr);
            
            array_push($cat_Arr,$category);
        }

            //check  authorised user 
            $user_id=0;
            if(Auth::guard('api')->check()){
                $user_id=Auth::guard('api')->user()->id;
            }      
         
            //Get Category custom fields
           
             $searchData['customFields'] = CategoryField::getFields($category);

            

          //Fetching data according to fields
        $query=DB::table('posts')
              ->select('posts.*',DB::raw("(SELECT filename FROM pictures WHERE pictures.post_id = posts.id limit 1) as filename"),DB::raw("(SELECT post_id  from saved_posts where saved_posts.post_id=posts.id and saved_posts.user_id=$user_id) as saved"))
               ->leftJoin('cities', 'posts.city_id', '=', 'cities.id')
               ->leftJoin('categories', 'posts.category_id', '=', 'categories.id');
                //category filter
                 if($cf){
                    $p=1;
                    foreach($cf as $key=>$cfvalues){
                        $query->Join('post_values as post_values'.$p.'',function($join) use ($p,$key,$cfvalues){
                            $join->on('post_values'.$p.'.post_id','posts.id');
                            $join->on('post_values'.$p.'.field_id',DB::raw("'".$key."'"));
                            $join->on('post_values'.$p.'.value','like',DB::raw("'".$cfvalues."'"));
                        });
 
                      $p++;
                    }
                  
               }
              
               //Type of Post
                 if($type){
                     $query->where('posts.post_type_id', $type);
                 }
               
                 //if $category have categories id
                if ($category){
                    $query ->whereIn('posts.category_id', $cat_Arr);
                 }
                 
                 //Post date
                 if($postedDate){
                      $query->where('posts.created_at','>=', $date);
                 }
                  
                 //Order by ASC and Desc for posts price
                if($orderBy){
                    if($orderBy=='date'){
                         $query->orderBy('posts.created_at', 'DESC');
                    }
                    else{
                        $order= substr($orderBy, 5);
                       $query->orderBy('posts.price', $order);
                    }
                    
                 }

                 //Maximum and minimum price

                 if($maxPrice && $minPrice){
                      $query->whereBetween('posts.price',[$minPrice,$maxPrice]);
                 }
                 
               
                 

                $data = $query->where('posts.reviewed',1)->get();

            if(count($data)<=0){
             return response()->json(['status'=>'404','message'=>'No result. Refine your search using other criteria. ','record'=>$searchData]); 
            }
             
             foreach($data as $post){
                 //Saved post status
                  $saved=0;
                    if($post->saved){
                        $saved=1;
                    }

                     $post->saved=$saved;

                // creating full link for  ads posts image
               
               if ($post->filename) {
					 $postImg = imgUrl($post->filename, 'medium');
					} else {
               // send default image if no image in posts
					 $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
					}
               
                $post->filename=$postImg;
                $searchData['posts'][]=$post;   
             }


          return response()->json(['status'=>'200','message'=>'','record'=>$searchData]);

     }
    

     public function Posts2(Request $request){

        //Get all filters field
        $type=($request->input('type'))?$request->input('type'):"";
        $category=$request->input('category');
        $postedDate=$request->input('postedDate');
        $orderBy=$request->input('orderBy');
        $minPrice=$request->input('minPrice');
        $maxPrice=$request->input('maxPrice');
        $cf=$request->input('cf');  //Category filter
        $location=$request->input('location');

        //Post posted date
      
        if($postedDate){
            if($postedDate==2){
                $time='24 '.t('hours');
             
               $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
            elseif($postedDate==4){
                $time='3 '.t('days');
                $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
            elseif($postedDate==8){
                $time='7 '.t('days');
                $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
            elseif($postedDate==31){
                $time='30 '.t('days');
                $date= date('Y-m-d H:i',strtotime('-'.$time));
            }
        }

        $categories_id=[];
        if($category){
        $posts=Category::with('children')->where('parent_id',$category)->get()->toArray();
        // Send response
        $cat_Arr = array();
        array_walk_recursive($posts, function ($value, $key) use (&$cat_Arr){
            if($key=='id')
            {
              $cat_Arr[] = $value;
            }
         }, $cat_Arr);
            
            array_push($cat_Arr,$category);
        }

            //check  authorised user 
            $user_id=0;
            if(Auth::guard('api')->check()){
                $user_id=Auth::guard('api')->user()->id;
            }      
         
            //Get Category custom fields
           
             $searchData['customFields'] = CategoryField::getFields($category);

            //filter data
            $where_cf="";
            if($cf){
              
                foreach($cf as $key=>$cfvalues){
                   $where_cf.=" AND post_values.field_id=".$key." and post_values.value= ".$cfvalues;
                }
            }

          //Fetching data according to fields
        $query=DB::table('posts')
              ->select('posts.*',DB::raw("(SELECT filename FROM pictures WHERE pictures.post_id = posts.id limit 1) as filename"),DB::raw("(SELECT post_id  from saved_posts where saved_posts.post_id=posts.id and saved_posts.user_id=$user_id) as saved"))
               ->leftJoin('cities', 'posts.city_id', '=', 'cities.id')
               ->leftJoin('categories', 'posts.category_id', '=', 'categories.id');
                //category filter
                 if($cf){
                    $p=1;
                    foreach($cf as $key=>$cfvalues){
                        $query->Join('post_values as post_values'.$p.'',function($join) use ($p,$key,$cfvalues){
                            $join->on('post_values'.$p.'.post_id','posts.id');
                            $join->on('post_values'.$p.'.field_id',DB::raw("'".$key."'"));
                            $join->on('post_values'.$p.'.value',DB::raw("'".$cfvalues."'"));
                        });

                    //    $where=('post_values'.$p.'.field_id = '.$key.' AND  post_values'.$p.'.value = '.$cfvalues);
                    // //     $query->Join('post_values as post_values'.$p.' ',' post_values'.$p.'.post_id','posts.id',$where);
                    //  $query->whereRaw('INNER JOIN post_values as post_values'.$p.' ON post_values'.$p.'.post_id=posts.id and '.$where);
                           
                    $p++;
                    }
                  
               }
              
               //Type of Post
                 if($type){
                     $query->where('posts.post_type_id', $type);
                 }
               
                 //if $category have categories id
                if ($category){
                    $query ->whereIn('posts.category_id', $cat_Arr);
                 }
                 
                 //Post date
                 if($postedDate){
                      $query->where('posts.created_at','>=', $date);
                 }
                  
                 //Order by ASC and Desc for posts price
                if($orderBy){
                    if($orderBy=='date'){
                         $query->orderBy('posts.created_at', 'DESC');
                    }
                    else{
                        $order= substr($orderBy, 5);
                       $query->orderBy('posts.price', $order);
                    }
                    
                 }

                 //Maximum and minimum price

                 if($maxPrice){
                      $query->where('posts.price','<=', $maxPrice);
                 }
                 if($minPrice){
                       $query->where('posts.price','<=', $minPrice);
                 }
               
                 

                $data = $query->where('posts.reviewed',1)->get();

            if(count($data)<=0){
             return response()->json(['status'=>'404','message'=>'No result. Refine your search using other criteria. ','record'=>$searchData]); 
            }
             
             foreach($data as $post){
                 //Saved post status
                  $saved=0;
                    if($post->saved){
                        $saved=1;
                    }

                     $post->saved=$saved;

                // creating full link for  ads posts image
               
               if ($post->filename) {
					 $postImg = imgUrl($post->filename, 'medium');
					} else {
               // send default image if no image in posts
					 $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
					}
               
                $post->filename=$postImg;
                $searchData['posts'][]=$post;   
             }


          return response()->json(['status'=>'200','message'=>'','record'=>$searchData]);

     }

     
     /**
        Save posts
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
     
      public function save_post(Request $request){
         //Get input fields
         $user_id= auth()->user()->id;
         $postId = $request->input('postId');
         if(!$postId){
              return response()->json(['status'=>'200','message'=>'Post Id cant be empty']);
         }
         $status = 0;
         if (auth()->check()) {
             //check save post
			$savedPost = SavedPost::where('user_id', auth()->user()->id)->where('post_id', $postId);
			if ($savedPost->count() > 0) {
				// Delete SavedPost
				$savedPost->delete();
                  
                  
			} else {
				// Store SavedPost
				$savedPostInfo = [
					'user_id' => auth()->user()->id,
					'post_id' => $postId,
				];
				$savedPost = new SavedPost($savedPostInfo);
				$savedPost->save();
                $status = 1;
                
			}
		}
         $result=[
                    'logged'   => (auth()->check()) ? auth()->user()->id : 0,
			        'postId'   => $postId,
			        'status'   => $status,
                ];
                //Create message according to status
            $message='Post deleted from favorites successfully!';
            if($status==1){
                     $message='Post saved in favorites successfully!';
                }
         // Send response
         return response()->json(['status'=>'200','message'=>$message,'record'=>$result]);
     }
     
     /**
        Categories dynamic fields
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */

     public function CustomFields(Request $request){
         $cat_id=$request->input('category');
         if (empty($cat_id) || !is_numeric($cat_id)) {
		 return response()->json(['status'=>'404','message'=>'category not found']);
		}
        //Get custom fields
         $customFields= CategoryField::getFields($cat_id);

         // Send response
         return response()->json(['status'=>'200','message'=>'','record'=>$customFields]);
     }
   

	private function getCacheExpirationTime($value = [])
	{
		// Get the default Cache Expiration Time
		$cacheExpiration = 0;
		if (isset($value['cache_expiration'])) {
			$cacheExpiration = (int)$value['cache_expiration'];
		}
		
		return $cacheExpiration;
	}
}