<?php
include '../../include/api-header.php';

$contacts = $user->getContacts();

$response = array();

foreach ($contacts as $sender_userIdentifier) {
    $sender = User::GetUserWithIdentifier($db, $sender_userIdentifier);
    $sender_username = $sender->getUsername();
    array_push($response, array('username' => $sender_username, 'userIdentifier' => $sender_userIdentifier));
}

respond_success($response);
?>
