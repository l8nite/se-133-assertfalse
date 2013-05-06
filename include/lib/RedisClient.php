<?php

require_once 'Predis/Autoloader.php';

/**
 * Factory method which returns a single instance of the Predis client object
 */
class RedisClient
{
    /**
    * Returns a connected instance of the predis client. Multiple calls to this function will return the same result.
    * @return Predis\Client The Predis client. If one already exists, returns that one.
    */
    public static function GetConnectedInstance()
    {
        static $predis = null;

        if ($predis === null) {
            Predis\Autoloader::register();
            $predis = new Predis\Client('tcp://kong.idlemonkeys.net:6379');
        }
 
        return $predis;
    }

    /**
     * Constructor that should not be called.
     * @throws Exception RedisClient should not be constructed.
     */
    public function __construct()
    {
        throw new Exception("RedisClient should not be constructed.");
    }
}
?>
