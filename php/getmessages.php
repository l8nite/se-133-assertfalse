<?php
require './Session.php';
require 'Predis/Autoloader.php';

Predis\Autoloader::register();
$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');

if (isset($_COOKIE['MentorWebSession'])) {
    $my_uuid = Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);
    if ($my_uuid == "") {
        echo("You are not logged in.");
        exit;
    }
}
else {
    echo("You are not logged in.");
    exit;
}



$my_contact = json_decode($redis->get("user:contact:$my_uuid"));
$my_username = $my_contact->{'email'};

$from = $_REQUEST['from'];
$from_uuid = "";
if (preg_match("/^[a-z0-9]{8}-([a-z0-9]{4}-){3}[a-z0-9]{12}$/i", $from)) {
    $from_uuid = $from;
}
else {
    $from_uuid = $redis->get("uuid_for:$from");
}

if ($from_uuid == null) {
    header(':', true, 409);
    echo(json_encode(array('error' => 'UUID not found')));
    exit;
}

$from_contact = json_decode($redis->get("user:contact:$from_uuid"));
$from_username = $from_contact->{'email'};

$rcvd = $redis->zrange("messages:$my_uuid:$from_uuid", 0, -1, 'withscores');
$sent = $redis->zrange("messages:$from_uuid:$my_uuid", 0, -1, 'withscores');

// no messages
if (!(count($rcvd) || count($sent))) {
    echo('[]');
    exit;
}

// mark up each message with the right sender
foreach ($rcvd as &$m) {
    array_push($m, $from_username, $from_uuid);
}

foreach ($sent as &$m) {
    array_push($m, $my_username, $my_uuid);
}

// merge the arrays and sort by timestamp
$messages = array_merge($rcvd, $sent);

function cmp_msg_time ($a, $b) {
    $at = $a[1];
    $bt = $b[1];

    if ($at < $bt) {
         return -1;
    }
    else if ($at > $bt) {
        return 1;
    }
    else {
        return 0;
    }
}

usort($messages, "cmp_msg_time");

$response = array(
    'with' => $from_username,
    'messages' => array()
);
$senders = array();

foreach ($messages as $mraw) {
    $message = array(
        'text' => $mraw[0],
        'time' => $mraw[1],
        'name' => $mraw[2],
        'uuid' => $mraw[3]
    );

    array_push($response['messages'], $message);
}

echo(json_encode($response));
?>
