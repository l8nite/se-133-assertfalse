<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting(E_ALL);
ini_set('display_errors', True);

// Import
require_once 'SignIn_v2.php';
require_once '../Session.php';
require_once 'Predis/Autoloader.php';
$REDIRECT_SUCCESS = "Location: ../../MentorWeb/content/messages.php";
$REDIRECT_FAIL = "Location: ../../MentorWeb/content/signin.php";

Predis\Autoloader::register();
$redis = new Predis\Client('tcp://localhost:6379');

// From the post
$username = $_POST['username'];
$password = $_POST['password'];
$db = $redis;


if(SignIn::doSignIn($username, $password, $db)){
    //header($REDIRECT_SUCCESS);
    header(SignIn::REDIRECT_SUCCESS);
    //echo SignIn::isSignedIn();
    //header("Location: SignIn_script_1.php");
}
else{
    header(SignIn::REDIRECT_FAIL);
    //echo "fai";
  
   // header("Location: SignIn_script_1.php");
}
?>
