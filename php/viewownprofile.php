<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible

require 'Predis/Autoloader.php';
require './Session.php';
require './Profile.php';

if (isset($_COOKIE['MentorWebSession'])) {
	Predis\Autoloader::register();
	//$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
	$redis = new Predis\Client('tcp://localhost:6379');

	$uuid = Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);

	$profile = new Profile($redis, $uuid);
	$profileEntry = $profile->getProfile();
	$experienceEntry = $profile->getExperience();
	$goalsEntry = $profile->getGoals();
	
	$return = array (
		'name'        => $profileEntry->{'first'} . ' ' . $profileEntry->{'last'},
		'title'       => $profileEntry->{'title'},
		'description' => $profileEntry->{'description'}
	);
	
	echo json_encode($return);
}
?>