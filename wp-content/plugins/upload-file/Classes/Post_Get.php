<?php
// Input.php

class Post_Get
{
	// form validation
	// this class can be used to validate $_POST and $_GET
	// check if $_POST or $_GET have data 
	public function exists($type = 'post')
	{
		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
				break;

			case 'get':
				return (!empty($_GET)) ? true : false;
				break;	

				case 'file':
				return (!empty($_FILES)) ? true : false;
				break;				
			
			default:
				return false;
				break;
		}
	}
	// get the data from $_POST or $_GET
	public function get($item , $name = null)
	{
		if (isset($_POST[$item])) {
			return $_POST[$item];
		}elseif (isset($_GET[$item])) {
			return $_GET[$item];
		}

		return '';
		exit();
	}

	public function getFile($item, $name)
	{
		if (isset($_FILES[$item][$name])) 
		{
			return $_FILES[$item][$name];
		}
	}
}