<?php

namespace AlissonBora\Request;

use Illuminate\Http\Request as BaseRequest;

class Request {
	
	public static function capture()
	{
		$request = BaseRequest::createFromGlobals();		
		self::sanitize($request);
		
		return $request;
	}
		
	private static function sanitize(BaseRequest $request) 
	{
		$output = [];
		
		foreach ($request->all() as $key => $value) {
			$output[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
		}
		
		$request->merge($output);
	}
	
}			