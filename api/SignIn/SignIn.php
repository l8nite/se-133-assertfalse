<?php

require_once 'Predis/Autoloader.php';
Predis\Autoloader::register();
$redis = new Predis\Client('tcp://localhost:6379');

/**
 * Description of SignIn. This class is used to manage signins and signouts.
 * 
 * DEPRECATED as of April 27, 2013.
 * 
 * @author Ryan
 *//*
class SignIn {
    /**
     * This method is used to sign in a user.
     *  @param username The user's username;
     *  @param password The user's password;
     *  @return true if the credentials are valid and the session was registered; otherwise false.
     *
    public static function signIn($username, $password)
    {
        if (areValidCredentials($username, $password))
        {
            // get UUID
            $UUID = "somethiing in the database";
            
            if (session_start()) // if the session successfully starts
            {
                $_SESSION['sessionUUID'] = $UUID;
                return true;
            }
        }
        return false;
    }
     /**
     * This method checks if a user's credentials are valid.
     *  @param username The user's username;
     *  @param password The user's password;
     *  @return true if the credentials are valid; otherwise false.
     *
    private static function areValidCredentials($username, $password)
    {
        // do something in the database
        return true;
    }
     /**
     * This method checks if a user is signed in.
     *  @return true if the user is signed in; otherwise false.
     *
    public static function isSignedIn()
    {
        session_start();
        return isset($_SESSION['sessionUUID']);
    }
    
     /**
     * This method gets the userid of the user signed in.
     *  @return the UUID if the user is signed in; otherwise NULL.
     *
    public static function getUUID()
    {
        session_start();
        if(isSignedIn())
        {
            return $_SESSION['sessionUUID'];
        }
        return NULL;
    }
    
    /**
     * This method signs a user out.
     *
    public static function signOut()
    {
        session_start();
        if(isSignedIn())
        {
            unset($_SESSION['sessionUUID']);
        }
        session_destroy();
    }
}
*/
?>
