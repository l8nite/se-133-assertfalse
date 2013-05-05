<?php
/** 
 * This script is used to generate a validation token and email.
 */
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once '../include/lib/RedisClient.php';
require_once '../include/lib/Validation.php';
require_once '../include/lib/User.php';

$db = RedisClient::GetConnectedInstance();


// attempt to log the user in and then redirect them to the home page
$username = $_GET['username'];

//$UUID = User::GetUserWithUsername($db, $username)->getIdentifier();
$UUID = $db->get("user_id_for:$username");
//echo "$UUID";
$validator = new Validation($db, $UUID);
//var_dump($validator);
$validator->generateToken();
$validator->sendValidationEmail();

header("Location: /validation.php?username=$username");
?>
 