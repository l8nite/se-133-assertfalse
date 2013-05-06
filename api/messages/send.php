<?php
/** 
 * This script is used to send messages.
 */
include '../../include/api-header.php';


if (!isset($_REQUEST['to']) || !isset($_REQUEST['m'])) {
    respond_error('to and m parameters are required');
}

$to = $_REQUEST['to'];
$message = $_REQUEST['m'];


$recipient = User::GetUser($db, $_REQUEST['to']);

if ($recipient === null) {
    respond_error('recipient not found');
}

$sender_userIdentifier = $user->getIdentifier();
$recipient_userIdentifier = $recipient->getIdentifier();

// TODO: move adding contacts to User class
// TODO: write Message class to encapsulate database access
$db->zadd("contacts:$recipient_userIdentifier", time(), $sender_userIdentifier);
$db->zadd("contacts:$sender_userIdentifier", time(), $recipient_userIdentifier);
$db->zadd("messages:$recipient_userIdentifier:$sender_userIdentifier", time(), $message);
$db->hincrby("messages:$recipient_userIdentifier:unread", "total", 1);
$db->hincrby("messages:$recipient_userIdentifier:unread", $sender_userIdentifier, 1);

respond_success(array('success' => true));
?>
