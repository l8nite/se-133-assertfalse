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

$recipient = $_REQUEST['to'];
// TODO : need to look up recipient UUID
$recipient_uuid = $recipient;
$message = $_REQUEST['m'];
$sender_uuid = $uuid;

$redis->zadd("senders:$recipient_uuid", time(), $sender_uuid);
$redis->zadd("messages:$recipient_uuid:$sender_uuid", time(), $message);

echo("{}");
?>
