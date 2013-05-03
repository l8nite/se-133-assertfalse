<?php
require_once '../include/lib/RedisClient.php';
require_once '../include/lib/Session.php';

$session = new Session(RedisClient::GetConnectedInstance());

// don't log the user in again if they're already logged in
if ($session->isLoggedIn())
{
    header("Location: /index.php");
    exit;
}

// attempt to log the user in and then redirect them to the home page
$username = $_POST['username'];
$password = $_POST['password'];

$result = $session->login($username, $password);

if ($result === $session::SESSION_INVALID_USERNAME)
{
    header("Location: /signup.php?username=$username");
}
else
{
    header("Location: /index.php");
}
?>
