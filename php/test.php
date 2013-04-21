<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible
require './Match.php';
require 'Predis/Autoloader.php';

Predis\Autoloader::register();
//$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
$redis = new Predis\Client('tcp://localhost:6379');

//var_dump(Match::filter("i like cake and i am cool..cake! bob"));

$matcher = new Match($redis, "");
var_dump(Match::filter("i like cake and i am cool..cake! bob"));
?>