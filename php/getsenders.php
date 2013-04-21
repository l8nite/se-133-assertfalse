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



$senders = $redis->zrange("senders:$uuid", 0, -1);

$response = array();

foreach ($senders as $sender_uuid) {
    $sender_contact = json_decode($redis->get("user:contact:$sender_uuid"));
    $sender_username = $sender_contact->{'email'};
    array_push($response, array('username' => $sender_username, 'uuid' => $sender_uuid));
}

echo(json_encode($response));

?>
