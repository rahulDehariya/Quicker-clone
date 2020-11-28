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

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Post\CreateOrEdit\Traits\FieldOptionsTrait;
// use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Models\FieldOption;
use App\Models\Field;

class OptionSubfieldsController extends FrontController
{
	// use CategoriesTrait;
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getModelHtml(Request $request)
	{
		$languageCode = $request->input('languageCode');
		$catId = $request->input('catId');
		$postId = $request->input('postId');

		$html = '<option value="" selected="selected">Select</option>';
		$fieldOption = FieldOption::where('id' , $catId)->first();
		if($fieldOption){
			$field = Field::where('id' , $fieldOption->field_id)->first();
			if($field->name=='Make'){
				$fieldOptionFinal = FieldOption::where('parent_id' , $catId)->where('translation_lang' , $languageCode)->get();
				foreach ($fieldOptionFinal as $key => $value) {
					$html .= '<option value="'.$value->id.'">'.$value->value.'</option>';
				}
			}
		}
		
		// Get Result's Data
		$data = [
			'customFields' => $html,
		];
		
		return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
