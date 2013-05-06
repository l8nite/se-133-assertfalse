<?php
require_once 'RedisClient.php';
require_once 'UUID.php';

/**
 * This class allows for the creation and update of a user's profile.
 */
class User
{
    /** Creates a User in the database. Creates a User object for manipulation.
     * 
     * @param String $username The username.
     * @param String $password The user's password.
     * @param String $mentorType Whether the person wants to be a mentor, mentee, or both.
     * @param String $firstName The user's firstname.
     * @param String $lastName The user's lastname.
     * @param String $zipCode The user's zip code.
     * @return User A user object for manipulation, or null if the user already exists.
     */
    public static function CreateUser($username, $password, $mentorType, $firstName, $lastName, $zipCode)
    {
        $db = RedisClient::GetConnectedInstance();

        $passwordSalt = UUID::v4();
		$hashedPassword = crypt($password, $passwordSalt);

        $details = array(
            'username' => $username,
            'mentorType' => $mentorType,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'zipCode' => $zipCode,
            'hashedPassword' => $hashedPassword,
            'passwordSalt' => $passwordSalt,
        );

        $userIdentifier = 'user:' . UUID::v4();

        // check if username is already in use
        if ($db->get($userIdentifier) !== null) {
            return null;
        }

        $db->set($userIdentifier, json_encode($details));
        $db->set("user_id_for:$username", $userIdentifier);

        return new User($db, $userIdentifier);
    }

    /** Gets the User from the database.
     * 
     * @param Predis/Client $db The Predis client connected to the Redis database.
     * @param String $identifierOrUsername A string that is either the UUID or username.
     * @return User A User object with the user's data loaded into it.
     */
    public static function GetUser($db, $identifierOrUsername)
    {
        if (UUID::is_valid(substr($identifierOrUsername, 5))) {
            return User::GetUserWithIdentifier($db, $identifierOrUsername);
        }
        else {
            return User::GetUserWithUsername($db, $identifierOrUsername);
        }
    }

    /** Gets the User from the database.
     * 
     * @param Predis/Client $db The Predis client connected to the Redis database.
     * @param String $username The username.
     * @return User A User object with the user's data loaded into it.
     */
    public static function GetUserWithUsername($db, $username)
    {
        $userIdentifier = $db->get("user_id_for:$username");

        if ($userIdentifier === null) {
            return null;
        }

        return User::GetUserWithIdentifier($db, $userIdentifier);
    }

    /** Gets the User from the database.
     * 
     * @param Predis/Client $db The Predis client connected to the Redis database.
     * @param String $userIdentifier The UUID.
     * @return User A User object with the user's data loaded into it.
     */
    public static function GetUserWithIdentifier($db, $userIdentifier)
    {
        if (!$db->exists($userIdentifier)) {
            return null;
        }

        return new User($db, $userIdentifier);
    }


    private $db = null;
    private $details = null;
    private $userIdentifier = null;

    /** The constructor to create a User object.
     * 
     * @param Predis/Client $db The Predis client connected to the Redis database.
     * @param String $userIdentifier The UUID.
     * @throws Exception Throws an exception when the constructor is missing parameters.
     */
    public function __construct($db, $userIdentifier)
    {
        if ($db === null || $userIdentifier === null) {
            throw new Exception("You probably meant User::Get* or User::CreateUser");
        }

        $this->db = $db;
        $this->userIdentifier = $userIdentifier;

        $details = json_decode($db->get($userIdentifier));
        $this->details = $details;
    }

    /** This method stores the User in the database. To be called when the User object's attributes are changed.
     * 
     */
    private function persist() {
        $this->db->set($this->userIdentifier, json_encode($this->details));
    }

    /** Gets the UUID
     * 
     * @return String The UUID.
     */
    public function getIdentifier() {
        return $this->userIdentifier;
    }
    
    /** Gets the username.
     * 
     * @return String The Username.
     */
    public function getUsername() {
        return $this->details->{'username'};
    }

    /** Returns a JSON array with the User's details.
     * 
     * @return JSONArray A JSON array with the User's details.
     */
    public function getDetails() {
        return $this->details;
    }

    /** Sets the User's profile information.
     * 
     * @param String $profile The profile information.
     */
    public function setProfile($profile) {
        $this->details->{'profile'} = $profile;
        $this->persist();
    }

    /** Gets the uers's type.
     * 
     * @return String The User's type (mentor, mentee, or both).
     */
    public function getUserType() {
        return $this->details->{'mentorType'};
    }

    /** Sets the user's type.
     * 
     * @param String $type The type of account the user has.
     */
    public function setUserType($type) {
        $this->details->{'mentorType'} = $type;
        $this->persist();
    }

    /** Gets the user's contacts.
     * 
     * @return array An array with the user's contacts.
     */
    public function getContacts() {
        $userIdentifier = $this->userIdentifier;
        return $this->db->zrange("contacts:$userIdentifier", 0, -1);
    }
}
