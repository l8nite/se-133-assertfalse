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
$message = $_REQUEST['m'];
$sender = $uuid;

$redis->zadd("senders:$recipient", time(), $sender);
$redis->zadd("messages:$recipient:$sender", time(), $message);

echo("{}");
?>
