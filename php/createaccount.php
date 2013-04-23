<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible

require 'Predis/Autoloader.php';
require './Profile.php';
require './Session.php';
require_once './Match.php';

Predis\Autoloader::register();
//$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
$redis = new Predis\Client('tcp://localhost:6379');

//if first sign up page
if (isset($_REQUEST['inputEmail']) && isset($_REQUEST['inputPassword']) && isset($_REQUEST['typeOptions']) && isset($_REQUEST['inputFirst']) && isset($_REQUEST['inputLast']) && isset($_REQUEST['inputZip'])) {
	$uuid = Profile::generateUUID();

	Profile::setPassword($redis, $uuid, $_REQUEST['inputPassword']);
	Profile::setContact($redis, $uuid, $_REQUEST['inputEmail'], $_REQUEST['inputZip']);
	Profile::setProfile($redis, $uuid, $_REQUEST['inputFirst'], $_REQUEST['inputLast'], 'Title', 'Description', $_REQUEST['typeOptions'], $_REQUEST['inputZip']);

	$sid = Session::generateSession($redis, $uuid);
	setcookie('MentorWebSession', $sid, time()-1, "/");
	setcookie('MentorWebSession', $sid, time()+60*60*24*30, "/"); //30 days
	echo $sid;
}

//if second sign up page
if (isset($_REQUEST['inputTitle']) && isset($_REQUEST['inputSummary']) && isset($_REQUEST['inputGoals']) && isset($_REQUEST['inputExperience'])) {
	if (isset($_COOKIE['MentorWebSession'])) {
		$uuid = Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);

		Profile::updateTitle($redis, $uuid, $_REQUEST['inputTitle']);
		Profile::updateDescription($redis, $uuid, $_REQUEST['inputSummary']);
		Profile::setGoals($redis, $uuid, $_REQUEST['inputTitle'], $_REQUEST['inputGoals']);
		Profile::setExperience($redis, $uuid, $_REQUEST['inputExperience']);
	} else {
	}
}
?>