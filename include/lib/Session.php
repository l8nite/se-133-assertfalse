<?php
require_once 'UUID.php';

/**
 * A class for managing a MentorWeb user's session
 * Upon construction, determines if the user is logged in or not
 * Has facilities for logging a user in or out
 */
class Session
{
    const SessionCookieName = 'MentorWebSession';
    const SessionExpireTimeSeconds = 2592000; // 30 days

    private $sessionIdentifier = null;
    private $userIdentifier = null;
    private $isLoggedIn = false;
    private $db = null;

    public function __construct($db)
    {
        if ($db === null) {
            throw new Exception('Missing $db parameter to Session::__construct');
        }

        $this->db = $db;

        if (isset($_COOKIE[self::SessionCookieName])) {
            $this->sessionIdentifier = "session:" . $_COOKIE[self::SessionCookieName];

            // look session up in the database
            $this->userIdentifier = $db->get($this->sessionIdentifier);

            if ($this->userIdentifier !== null) {
                $this->userIdentifier = $this->userIdentifier;
                $this->isLoggedIn = true;
            }
        }
    }

    public function login($username, $password)
    {
        if ($this->isLoggedIn)
        {
            error_log('login() of session who was already logged in...');
        }

        $this->userIdentifier = $this->db->get("uuid_for:$username");

        if ($this->userIdentifier === null) {
            return false; // user not in database
        }

        $storedPassword = json_decode($this->db->get("password:$this->userIdentifier"));
        $computedHash = crypt($password, $storedPassword->{'salt'});

        if ($computedHash === $storedPassword->{'pass'})
        {
            // create a new session
            $sessionUUID = UUID::v4();
            $this->sessionIdentifier = "session:" . $sessionUUID;

            // store it in the database
            $this->db->set($this->sessionIdentifier, $this->userIdentifier);
            $this->db->expire($this->sessionIdentifier, self::SessionExpireTimeSeconds);

            // set the user's session cookie
            // note: we don't send the session: prefix to the user for security reasons
            setcookie(self::SessionCookieName, $sessionUUID, time() + self::SessionExpireTimeSeconds, "/");

            $this->isLoggedIn = true;

            return true;
        }

        return false;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logout()
    {
        if (!$this->isLoggedIn)
        {
            error_log('logout() of session that was not logged in...');
        }

        $this->db->del($this->sessionIdentifier);
        setcookie(self::SessionCookieName, "", time() - self::SessionExpireTimeSeconds, "/");

        $this->isLoggedIn = false;
    }
}
?>
