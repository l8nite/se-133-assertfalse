<?php
    require 'Predis/Autoloader.php';
    Predis\Autoloader::register();
    $redis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
?>
