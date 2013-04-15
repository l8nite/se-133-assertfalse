<?php
	require 'Predis/Autoloader.php';
	Predis\Autoloader::register();
	
	$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
	//$redis->set('user:12345', 'cake');
	
	$uuid = generateUUID();
	//test
	setPassword($redis, $uuid, 'cakecake');
	setProfile($redis, $uuid, 'Malcolm', 'Reynolds', 'Ship Captain', 'I like to smuggle.', 1, 99999);
	
	
	function generateUUID() {
		return randomString(8) . '-' . randomString(4) . '-4' . randomString(3) . '-8' . randomString(3) . '-' . randomString(12);
	}
	
	function randomString($len) {
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$charlen = strlen($chars);
		$rand = "";
		for ($i = 0; $i < $len; $i++) {
			$rand .= $chars[rand(0, $charlen - 1)];
		}
		return $rand;
	}
	
	function setPassword($db, $id, $pw) {
		$salt = randomString(8);
		$hash = crypt($pw, $salt);
		$passwordEntry = array(
			'pass' => $hash,
			'salt' => $salt
		);
		$db->set('user:password:' . $id, json_encode($passwordEntry));
	}
	
	function setProfile($db, $id, $fname, $lname, $ttl, $desc, $type, $zip) {
		$profileEntry = array (
			'first'       => $fname,
			'last'        => $lname,
			'title'       => $ttl,
			'description' => $desc,
			'user_type'   => $type,
			'zip_code'    => $zip
		);
		$db->set('user:profile:' . $id, json_encode($profileEntry));
	}
?>