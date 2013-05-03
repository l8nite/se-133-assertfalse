<?php
/**
 * Factory method which returns a single instance of the Predis client object
 */
require_once 'Predis/Autoloader.php';

class RedisClient
{
    /**
    * Returns a connected instance of the predis client
    * Multiple calls to this function will return the same result
    */
    public static function GetConnectedPredisInstance()
    {
        static $predis = null;

        if ($predis === null) {
            Predis\Autoloader::register();
            $predis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
        }

        return $predis;
    }

    public function __construct()
    {
        throw new Exception("RedisClient should not be constructed.");
    }
}
?>
