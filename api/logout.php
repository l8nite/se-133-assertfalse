<?php
/** 
 * This script is used to disconnect a user from MentorWeb.
 */
require_once '../include/lib/RedisClient.php';
require_once '../include/lib/Session.php';

$session = new Session(RedisClient::GetConnectedInstance());

// if they're not logged in, what business do they have trying to log out?
if (!$session->isLoggedIn())
{
    header("Location: /index.php");
    exit;
}

$session->logout();
header("Location: /index.php");
?>
