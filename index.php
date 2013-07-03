<?php

	error_reporting(E_ALL ^ E_NOTICE);
	include_once("config.php");
	include_once("cdbproxy-private.php");
	include_once("cdbproxy-public.php");
	
	// echo '<pre>';
	file_put_contents('./test.txt', date('Y-m-d H:i:s'));
	
	# Map all GET arguments
	$params = $_GET;
	
	if(!(isset($params['tileString']) && $params['tileString'] != '')) {
		die('tileString should be provided!');
	}
	$dataConfig = array_merge($config, $params);
	
	$cp = new CartoProxy($dataConfig);
	if(isset($params['tileString']) && $params['tileString'] != '') {
		$cp->getTiles();
	}
	
	function print_j($str) {
		header('Content-type: application/json');
		print $str;
	}

?>