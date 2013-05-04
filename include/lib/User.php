<?php
require_once 'RedisClient.php';
require_once 'UUID.php';

/**
 * This class allows for the creation and update of a user's profile.
 */
class User
{
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

        $db->set($userIdentifier, json_encode($details));
        $db->set("user_id_for:$username", $userIdentifier);

        return new User($db, $userIdentifier);
    }

    public static function GetUser($db, $identifierOrUsername)
    {
        if (UUID::is_valid(substr($identifierOrUsername, 5))) {
            return User::GetUserWithIdentifier($db, $identifierOrUsername);
        }
        else {
            return User::GetUserWithUsername($db, $identifierOrUsername);
        }
    }

    public static function GetUserWithUsername($db, $username)
    {
        $userIdentifier = $db->get("user_id_for:$username");

        if ($userIdentifier === null) {
            return null;
        }

        return User::GetUserWithIdentifier($db, $userIdentifier);
    }

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

    private function persist() {
        $this->db->set($this->userIdentifier, json_encode($this->details));
    }

    public function getIdentifier() {
        return $this->userIdentifier;
    }

    public function getUsername() {
        return $this->details->{'username'};
    }

    public function getDetails() {
        return $this->details;
    }

    public function setProfile($profile) {
        $this->details->{'profile'} = $profile;
        $this->persist();
    }

    public function getContacts() {
        $userIdentifier = $this->userIdentifier;
        return $this->db->zrange("contacts:$userIdentifier", 0, -1);
    }
}
