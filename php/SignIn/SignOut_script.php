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


Predis\Autoloader::register();
$redis = new Predis\Client('tcp://localhost:6379');


if(SignIn::isSignedIn())
    SignIn::signOut($redis);
header(SignIn::REDIRECT_HOME);

?>
