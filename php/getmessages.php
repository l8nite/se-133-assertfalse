<?php
require './Session.php';
require 'Predis/Autoloader.php';

Predis\Autoloader::register();
$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');

if (isset($_COOKIE['MentorWebSession'])) {
    $uuid = Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);
    if ($uuid == "") {
        echo("You are not logged in.");
        exit;
    }
}
else {
    echo("You are not logged in.");
    exit;
}


$sender = $_REQUEST['from'];
// TODO: LOOK UP SENDER UUID
$sender_uuid = $sender;

$messages = $redis->zrange("messages:$uuid:$sender_uuid", 0, -1, 'withscores');
$responses = array();
foreach ($messages as $message) {
    array_push($responses, array('message' => $message[0], 'time' => $message[1]));
}
echo(json_encode($responses));
?>
