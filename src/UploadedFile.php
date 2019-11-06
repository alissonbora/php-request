<?php

namespace AlissonBora\Request;

class UploadedFile {
	
	private $name;
	private $tmp_name;
	private $size;
	private $type;
	private $error;
	
	public function __construct($files = [])
	{
		foreach ($files as $key => $value) {
			$this->$key = $value;
		}

		if ($this->isValid() == false) {
			throw new \Exception("This is not valid uploaded file.");
		}
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getExtension($mimes)
	{
		$extension = strtolower(pathinfo($this->name, PATHINFO_EXTENSION));
		
		if ($extension == "") {
			require_once "mime_types.php";
			
			$allowed = array_filter($mime_types, function($key) use ($mimes) {
				return in_array($key, $mimes);
			}, ARRAY_FILTER_USE_KEY);
		
			foreach ($allowed as $key => $value) {
				if (in_array($this->getMimeType(), $value)) {
					return $key;
					break;
				}
			}
		}
		else {
			return $extension;
		}
	}
	
	public function getSize()
	{
		return $this->size / 1024;
	}
	
	public function getMimeType()
	{
		return mime_content_type($this->tmp_name);
	}
	
	public function notUploadedFile()
	{
		if ($this->error == 4) {
			return true;
		}
		
		return false;
	}
	
	private function isValid()
	{
		if ($this->tmp_name) {
			return file_exists($this->tmp_name);
		}
		
		return false;
	}
	
}