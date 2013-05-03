<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible
require 'Predis/Autoloader.php';
require './Match.php';
require './Profile.php';
require './Session.php';

if (isset($_COOKIE['MentorWebSession'])) {
	Predis\Autoloader::register();
	//$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
	$redis = new Predis\Client('tcp://localhost:6379');

	$uuid = Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);
	
	$match = new Match($redis, $uuid);
	echo json_encode($match->match());
}
?>