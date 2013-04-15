<?php
	require 'Predis/Autoloader.php';
	Predis\Autoloader::register();
	
	$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
	//$redis->set('user:12345', 'cake');
	
	$uuid = generateUUID();
	echo $uuid;
	//test
	//setPassword($redis, $uuid, 'cakecake');
	//setContact($redis, $uuid, 'mal@serenity', 99999);
	//setProfile($redis, $uuid, 'Malcolm', 'Reynolds', 'Ship Captain', 'I like to smuggle.', 1, 99999);
	//setGoals($redis, $uuid, 'Captain', 'comma,delimited,stuff?');
	//setExperience($redis, $uuid, 'done,this,and,that');
	
	
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
		$passwordEntry = array (
			'pass' => $hash,
			'salt' => $salt
		);
		$db->set('user:password:' . $id, json_encode($passwordEntry));
	}
	
	function setContact($db, $id, $email, $zip) {
		$contactEntry = array (
			'email'    => $email,
			'zip_code' => $zip
		);
		$db->set('user:contact:' . $id, json_encode($contactEntry));
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
	
	function setGoals($db, $id, $ttl, $desc) {
		$goalsEntry = array (
			'title'            => $ttl,
			'goal_description' => $desc
		);
		$db->set('user:goals:' . $id, json_encode($goalsEntry));
	}
	
	function setExperience($db, $id, $desc) {
		$experienceEntry = array (
			'experience_description' => $desc
		);
		$db->set('user:experience:' . $id, json_encode($experienceEntry));
	}
?>