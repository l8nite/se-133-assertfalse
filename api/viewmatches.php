<?php
//disable domain access control
header('Access-Control-Allow-Origin: *');

require_once '../include/api-header.php';
require './Match.php';

$session = new Session(RedisClient::GetConnectedInstance());

if (!$session->isLoggedIn())
{
    header("Location: /index.php");
    exit;
}

$details = $user->getDetails();
var_dump($details);
$profile = null;

if (array_key_exists('profile', $details)) {
	$match = new Match($db, $user);
	echo json_encode($match->match());
}
?>