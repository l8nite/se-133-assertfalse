<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting(E_ALL);
ini_set('display_errors', True);

require_once 'SignIn_v2.php';
require_once 'Predis/Autoloader.php';
Predis\Autoloader::register();
$redis = new Predis\Client('tcp://localhost:6379');
$username = $_POST['username'];
$password = $_POST['password'];
$db = $redis;
if(SignIn::doSignIn($username, $password, $db)){
    echo "true";
}
else{
    echo "false";
}
?>
