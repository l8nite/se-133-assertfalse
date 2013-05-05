<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once '../include/lib/RedisClient.php';
require_once '../include/lib/Validation.php';
require_once '../include/lib/User.php';

$db = RedisClient::GetConnectedInstance();


// attempt to log the user in and then redirect them to the home page

if(isset($_GET['username']) && isset($_GET['token']))
{
    $username = $_GET['username'];

    $token = $_GET['token'];
    $UUID = $db->get("user_id_for:$username");

    if ($UUID == "")
        header("Location: /validation.php");
    else
    {	
        $validator = new Validation($db, $UUID);
        $validator->validate($token);
        header("Location: /validation.php?username=$username");
    }
}
else
    header("Location: /validation.php");
//$validator->validate($token);
//$result = $validator->isValidated();

 
//header("Location: /validation.php?username=$username");
//include('..include/pages/validation.php');
?>
