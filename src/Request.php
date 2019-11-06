<?php

namespace AlissonBora\Request;

use Illuminate\Http\Request as BaseRequest;

class Request {
	
	public function __construct()
	{
		$request = BaseRequest::create();		
		$this->sanitize($request);
		
		return $request;
	}
		
	private function sanitize(Request $request) 
	{
		$output = [];
		
		foreach ($request->all() as $key => $value) {
			$output[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
		}
		
		$request->merge($output);
	}
	
}			