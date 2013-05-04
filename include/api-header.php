<?php
require_once 'lib/RedisClient.php';
require_once 'lib/Session.php';
require_once 'lib/User.php';

$db = RedisClient::GetConnectedInstance();

$session = new Session($db);

function respond_error($message) {
    if (isset($redirectOnFailure) && $redirectOnFailure) {
        header("Location: $redirectOnFailure");
    }
    else {
        header(':', true, 409);
        echo json_encode(array('error' => $message));
    }
    exit;
}

function respond_success($data) {
    echo json_encode($data);
    exit;
}

if (!$session->isLoggedIn()) {
    respond_error('Not authenticated');
}

$user = User::GetUserWithIdentifier($db, $session->getUserIdentifier());
?>
