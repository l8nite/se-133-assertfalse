<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible
require 'Predis/Autoloader.php';
require './Match.php';
require './Profile.php';
require './Session.php';

Predis\Autoloader::register();
//$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
$redis = new Predis\Client('tcp://localhost:6379');
?>