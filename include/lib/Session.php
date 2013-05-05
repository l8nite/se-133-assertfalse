<?php
require_once 'UUID.php';

/**
 * A class for managing a MentorWeb user's session
 * Upon construction, determines if the user is logged in or not
 * Has facilities for logging a user in or out
 */
class Session
{
    const SESSION_CREATED = 1;
    const SESSION_INVALID_CREDENTIALS = -1;
    const SESSION_INVALID_USERNAME = -2;

    const SessionCookieName = 'MentorWebSession';
    const SessionExpireTimeSeconds = 2592000; // 30 days

    private $sessionIdentifier = null;
    private $userIdentifier = null;
    private $isLoggedIn = false;
    private $db = null;

    /** Constructs a Session object.
     * 
     * @param Predis\Client $db The Predis Client object.
     * @throws Exception Throws an exception when $db is null.
     */
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

    /** Logs a user in. If the credentials are correct, creates a session.
     * 
     * @param String $username The username.
     * @param String $password The user's password.
     * @return int An integer that represents the result of the login attempt. The meaning of the integer can be determined by the Class constants.
     */
    public function login($username, $password)
    {
        if ($this->isLoggedIn)
        {
            error_log('login() of session who was already logged in...');
        }

        $this->userIdentifier = $this->db->get("user_id_for:$username");

        if ($this->userIdentifier === null) {
            return self::SESSION_INVALID_USERNAME; // user not in database
        }

        $details = json_decode($this->db->get($this->userIdentifier));
        $computedHash = crypt($password, $details->{'passwordSalt'});

        if ($computedHash === $details->{'hashedPassword'})
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

            return self::SESSION_CREATED;
        }

        return SESSION_INVALID_CREDENTIALS;
    }

    /** Checks if the user is logged in.
     * 
     * @return boolean True if the user is logged in; false otherwise.
     */
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    /** Logs a user out.
     */
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

    /** Gets the logged in user's identifier.
     * 
     * @return UUID The logged in user's UUID.
     */
    public function getUserIdentifier()
    {
        return $this->userIdentifier;
    }
}
?>
