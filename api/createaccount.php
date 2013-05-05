<?php
require_once '../include/lib/RedisClient.php';
require_once '../include/lib/Session.php';
require_once '../include/lib/User.php';

$session = new Session(RedisClient::GetConnectedInstance());

if ($session->isLoggedIn()) {
    header("Location: /index.php");
    exit;
}


$reqParameters = array('inputEmail', 'inputPassword', 'typeOptions', 'inputFirst', 'inputLast', 'inputZip');

foreach ($reqParameters as $parameter)
{
    if (!isset($_POST[$parameter])) {
        header("Location: /signup.php?error=Missing%20required%20parameter");
        exit;
    }

    // TODO: validate parameter values instead of blindly trusting user input
}

$username = $_POST['inputEmail'];
$password = $_POST['inputPassword'];
$mentorType = $_POST['typeOptions'];
$firstName = $_POST['inputFirst'];
$lastName = $_POST['inputLast'];
$zipCode = $_POST['inputZip'];

$user = User::CreateUser($username, $password, $mentorType, $firstName, $lastName, $zipCode);

if ($user === null) {
    header("Location: /signup.php?error=Could%20not%20create%20your%20account");
    exit;
}

//$session->login($username, $password);
//header("Location: /index.php");
header("Location: generateValidation.php?username=$username");
