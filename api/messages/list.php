<?php
/** 
 * This page creates a list of messages.
 */
include '../../include/api-header.php';

if (!isset($_REQUEST['with'])) {
    respond_error('missing "with" parameter');
}

$interlocutor = User::GetUser($db, $_REQUEST['with']);

if ($interlocutor === null) {
    respond_error("invalid 'with' user");
}

$my_uid = $user->getIdentifier();
$il_uid = $interlocutor->getIdentifier();

$rcvd = $db->zrange("messages:$my_uid:$il_uid", 0, -1, 'withscores');
$sent = $db->zrange("messages:$il_uid:$my_uid", 0, -1, 'withscores');

// no messages
$il_uname = $interlocutor->getUsername();
$unread = $db->hget("messages:$my_uid:unread", $il_uid);

$response = array(
    'with' => $il_uname,
    'unread' => $unread,
    'messages' => array()
);

if (!(count($rcvd) || count($sent))) {
    respond_success($response);
}

$db->hdel("messages:$my_uid:unread", $il_uid);
$db->hincrby("messages:$my_uid:unread", "total", 0 - $unread);

// mark up each message with the right sender
foreach ($rcvd as &$m) {
    array_push($m, $il_uname, $il_uid);
}

$my_uname = $user->getUsername();
foreach ($sent as &$m) {
    array_push($m, $my_uname, $my_uid);
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

$senders = array();

foreach ($messages as $mraw) {
    $message = array(
        'text' => preg_replace('/\n/', '<br/>', $mraw[0]),
        'time' => $mraw[1],
        'name' => $mraw[2],
        'uid' => $mraw[3]
    );

    array_push($response['messages'], $message);
}

respond_success($response);
?>
