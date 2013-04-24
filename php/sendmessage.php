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

$recipient_uuid = "";
if (preg_match("/^[a-z0-9]{8}-([a-z0-9]{4}-){3}[a-z0-9]{12}$/i", $recipient)) {
    $recipient_uuid = $recipient;
}
else {
    $recipient_uuid = $redis->get("uuid_for:$recipient");
}

if ($recipient_uuid == null) {
    header(':', true, 409);
    echo(json_encode(array('error' => 'UUID not found')));
    exit;
}

$message = $_REQUEST['m'];
$sender_uuid = $uuid;

$redis->zadd("contacts:$recipient_uuid", time(), $sender_uuid);
$redis->zadd("contacts:$sender_uuid", time(), $recipient_uuid);
$redis->zadd("messages:$recipient_uuid:$sender_uuid", time(), $message);

echo("{}");
?>
