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


$sender_uuid = $_REQUEST['from'];

$sender_contact = json_decode($redis->get("user:contact:$sender_uuid"));
$sender_username = $sender_contact->{'email'};

$messages = $redis->zrange("messages:$uuid:$sender_uuid", 0, -1, 'withscores');
$response = array();
$response['messages'] = array();
$response['sender'] = $sender_username;

foreach ($messages as $message) {
    array_push($response['messages'], array('message' => $message[0], 'time' => $message[1]));
}

echo(json_encode($response));
?>
