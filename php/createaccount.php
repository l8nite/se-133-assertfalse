<?php
	require 'Predis/Autoloader.php';
	Predis\Autoloader::register();
	
	$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
	//$redis->set('mwuser:12345', 'cake');
	
	function generateUUID() {
		return randomString(8) . '-' . randomString(4) . '-4' . randomString(3) . '-8' . randomString(3) . '-' . randomString(12);
	}
	
	function randomString($length) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$charlen = strlen($chars);
		$rand = "";
		for ($i = 0; $i < $length; $i++) {
			$rand .= $chars[rand(0, $charlen - 1)];
		}
		return $rand;
	}
	
	echo generateUUID();
?>