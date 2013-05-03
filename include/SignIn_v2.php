<?php

//require_once '../Session.php';

/**
 * Description of SignIn. This class is used to manage signins and signouts.
 *
 * @author Ryan
 */
class SignIn {
    const REDIRECT_SUCCESS = "Location: ../../MentorWeb/content/messages.php";
    const REDIRECT_FAIL = "Location: ../../MentorWeb/content/signin.php";
    const REDIRECT_SIGNIN = "Location: ./signin.php"; //to be called only the main pages
    const REDIRECT_HOME = "Location: ../../MentorWeb/content/home.php";
    private static $REDIRECT_EXCEPTIONS = array("home", "signin", "signup");
    
    /**
     * This method is used to sign in a user.
     *  @param username The user's username;
     *  @param password The user's password;
     *  @return true if the credentials are valid and the session was registered; otherwise false.
     */
    public static function doSignIn($username, $password, $db)
    {
        if (SignIn::areValidCredentials($username, $password, $db))
        {
            // sign out
            SignIn::signOut($db);
            
            // create new session
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
    public static function areValidCredentials($username, $password, $db)
    {
        
        $uuid = $db->get("uuid_for:$username");
        
        if ($uuid == "") // user not in database
            return false;
        else // check password
        {
            $passwordArray = json_decode($db->get('user:password:' . $uuid));
            $hash = $passwordArray->{'pass'};
            $salt = $passwordArray->{'salt'};

            return crypt($password, $salt) == $hash;
        }
    }
     /**
     * This method checks if a user is signed in.
     *  @return true if the user is signed in; otherwise false.
     */
    public static function isSignedIn()
    {
        return isset($_COOKIE['MentorWebSession']);
    }
    
    public static function enforceSignIn()
    {
        if(!isset($_COOKIE['MentorWebSession']))
        {
            
           // var_dump(SignIn::$REDIRECT_EXCEPTIONS);
            // check if need to redirect
       
            //echo '<div style="position:absolute;top:100px;left:100px;">';
            foreach(SignIn::$REDIRECT_EXCEPTIONS as $exception)
            {
                
                //echo $_SERVER["REQUEST_URI"] . " ";
                //echo $exception . " ";
                /*$s = strpos($_SERVER["REQUEST_URI"], $exception) . " ";
                echo $s . " ";
                $b = (strpos($_SERVER["REQUEST_URI"], $exception) !== false);
                echo $b . "<br />";*/
               
                
                if (strpos($_SERVER["REQUEST_URI"], $exception) !== false) // if no need to redirect
                        return false; // exit
            }
            //echo '</div>';
            //return true;
            header(SignIn::REDIRECT_SIGNIN);
        }
        else {
            return true;
        }
    }
    
     /**
     * This method gets the userid of the user signed in.
     *  @return the UUID if the user is signed in; otherwise NULL.
     */
    public static function getUUID($db)
    {
        return Session::resolveSessionID($db, $_COOKIE['MentorWebSession']);
    }
    
    /**
     * This method signs a user out.
     */
    public static function signOut($db)
    {
       // set the cookie to expire an hour ago
       if (isset($_COOKIE['MentorWebSession']))
       {
        $sid = $_COOKIE["MentorWebSession"];
        $db->del("session:user:$sid");
       }
       setcookie('MentorWebSession', '', time()-3600, "/");
	echo $_COOKIE['MentorWebSession'];
    }
}

?>
