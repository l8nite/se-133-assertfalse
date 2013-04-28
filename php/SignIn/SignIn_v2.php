<?php
/*
require_once 'Predis/Autoloader.php';
require_once '../Session.php';
Predis\Autoloader::register();
$redis = new Predis\Client('tcp://localhost:6379');
*/
/**
 * Description of SignIn. This class is used to manage signins and signouts.
 *
 * @author Ryan
 */
class SignIn {
    
    /**
     * This method is used to sign in a user.
     *  @param username The user's username;
     *  @param password The user's password;
     *  @return true if the credentials are valid and the session was registered; otherwise false.
     */
    public static function signIn($username, $password, $db)
    {
        if (areValidCredentials($username, $password, $db))
        {
            // get UUID
           $uuid = $db->get("uuid_for:$username");
            
           $sid = Session::generateSession($db, $uuid);
           setcookie('MentorWebSession', "$sid", time()-1, "/");
           setcookie('MentorWebSession', $sid, time()+60*60, "/"); //1 hour
           return true;
        }
        return false;
    }
     /**
     * This method checks if a user's credentials are valid.
     *  @param username The user's username;
     *  @param password The user's password;
     *  @return true if the credentials are valid; otherwise false.
     */
    private static function areValidCredentials($username, $password, $db)
    {
        // do something in the database
        $uuid = $db->get("uuid_for:$username");
        $passwordArray = json_decode($db->get('user:password:' . $uuid));
        $hash = $passwordArray->{'pass'};
        $salt = $passwordArray->{'salt'};
        
        return crypt($password, $salt) == $hash;
    }
     /**
     * This method checks if a user is signed in.
     *  @return true if the user is signed in; otherwise false.
     */
    public static function isSignedIn()
    {
        return isset($_COOKIE['MentorWebSession']);
    }
    
     /**
     * This method gets the userid of the user signed in.
     *  @return the UUID if the user is signed in; otherwise NULL.
     */
    public static function getUUID($redis)
    {
        return Session::resolveSessionID($redis, $_COOKIE['MentorWebSession']);
    }
    
    /**
     * This method signs a user out.
     */
    public static function signOut()
    {
       // set the cookie to expire an hour ago
       setcookie('MentorWebSession', '', time()-3600, "/");
    }
}

?>
