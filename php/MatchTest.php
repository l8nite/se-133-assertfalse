﻿<?php
//disable domain access control
header('Access-Control-Allow-Origin: *'); //TODO, fix if possible
require './Match.php';
require './Profile.php';
require 'Predis/Autoloader.php';

Predis\Autoloader::register();
//$redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
$redis = new Predis\Client('tcp://localhost:6379');

//$array1 = Match::filter("i like cake and i am cool..cake! bob");
//$array2 = Match::filter("i hate cake and i am cool..cake! bob");
//$array3 = Match::filter("i hate cake and i am cool..cake! bob software engineering. I would like to dream in code.");
//
//echo Match::score($array1, $array1);
//echo Match::score($array1, $array2);
//echo Match::score($array1, $array3);

$cake = new Match($redis, "oaagcvbr-omuw-4rrr-8u70-d33ljk08mr24");
//var_dump($cake->compareAllMentors(Match::filter("experience")));
//var_dump($cake->compareAllMentors(Match::filter("software")));
//var_dump($cake->compareAllMentors(Match::filter("cake root beer engineer")));

var_dump($cake->profile);
var_dump($cake->match());
?>