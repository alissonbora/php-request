<?php

namespace AlissonBora\Request;

class Request {
	
	private $get = [];
	private $post = [];
	private $files = [];
	private $hasFile = false;
	
	public function __construct()
	{
		$this->initialize($_GET, $_POST, $_FILES);
	}
	
	public function get($value = null) 
	{		
		if (!$value) {
			return $this->get;
		}
		else {
			return isset($this->get[$value]) ? $this->get[$value] : null;
		}
	}
	
	public function post($value = null) 
	{		
		if (!$value) {
			return $this->post;
		}
		else {
			return isset($this->post[$value]) ? $this->post[$value] : null;
		}
	}
	
	public function all() 
	{		
		return $this->get + $this->post + $this->files;
	}
	
	public function hasFile($value) 
	{
		if (isset($this->files[$value]) && is_array($this->files[$value])) {
			$this->hasFile = true;
			
			return true;
		}
		
		return false;
	}
	
	public function file($value) 
	{
		if ($this->hasFile) {
			return new UploadedFile($this->files[$value]);
		}	
	}
	
	private function initialize($get = [], $post = [], $files = []) {
		foreach ($get as $key => $value) {
			$this->get[$key] = $this->sanitize($value);
		}
		
		foreach ($post as $key => $value) {
			$this->post[$key] = $this->sanitize($value);
		}
		
		foreach ($files as $key => $array) {
			$this->files[$key] = $array;
		}
	}
		
	private function sanitize($value) 
	{
		return trim(htmlspecialchars($value, ENT_QUOTES));
	}
	
}			