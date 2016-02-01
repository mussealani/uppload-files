<?php //config.php


// Autoloader
spl_autoload_register(function($class) {
	if (is_file('Classes/' . $class . '.php'))
	{
		require_once('Classes/' . $class . '.php');
	}else
	 {
	 	 $filename = dirname(dirname(__FILE__)) . '/Classes/' . $class .'.php';
	 	 if(is_readable($filename))
	 	 {
	 	 	require_once $filename;
	 	 }
	 }
});
