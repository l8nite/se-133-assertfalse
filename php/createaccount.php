<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible

require 'Predis/Autoloader.php';
require './Session.php';
require './Profile.php';

Predis\Autoloader::register();
$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
//TEST
//setPassword($redis, $uuid, 'cakecake');
//setContact($redis, $uuid, 'mal@serenity', 99999);
//setProfile($redis, $uuid, 'Malcolm', 'Reynolds', 'Ship Captain', 'I like to smuggle.', 1, 99999);
//setGoals($redis, $uuid, 'Captain', 'comma,delimited,stuff?');
//setExperience($redis, $uuid, 'done,this,and,that');
//Profile::updateTitle($redis, 'fbzlmfv6-6sol-4103-89o6-cy2v42o7negr', 'testTitle');
//Profile::updateDescription($redis, 'fbzlmfv6-6sol-4103-89o6-cy2v42o7negr', 'testSummary');
//TEST

//if first sign up page
if (isset($_REQUEST['inputEmail']) && isset($_REQUEST['inputPassword']) && isset($_REQUEST['typeOptions']) && isset($_REQUEST['inputFirst']) && isset($_REQUEST['inputLast']) && isset($_REQUEST['inputZip'])) {
	$uuid = generateUUID();
	
	setPassword($redis, $uuid, $_REQUEST['inputPassword']);
	setContact($redis, $uuid, $_REQUEST['inputEmail'], $_REQUEST['inputZip']);
	setProfile($redis, $uuid, $_REQUEST['inputFirst'], $_REQUEST['inputLast'], 'Title', 'Description', $_REQUEST['typeOptions'], $_REQUEST['inputZip']);

	$sid = Session::generateSession($redis, $uuid);
	setcookie('MentorWebSession', $sid, time()+60*60*24*30, "/"); //30 days
	echo $sid;
}

//if second sign up page
if (isset($_REQUEST['inputTitle']) && isset($_REQUEST['inputSummary']) && isset($_REQUEST['inputGoals']) && isset($_REQUEST['inputExperience'])) {
	if (isset($_COOKIE['MentorWebSession'])) {
		$uuid = Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);
		
		Profile::updateTitle($redis, $uuid, $_REQUEST['inputTitle']);
		Profile::updateDescription($redis, $uuid, $_REQUEST['inputSummary']);
		setGoals($redis, $uuid, $_REQUEST['inputTitle'], $_REQUEST['inputGoals']);
		setExperience($redis, $uuid, $_REQUEST['inputExperience']);
		
		echo $_COOKIE['MentorWebSession'];
	} else {
	}
}

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