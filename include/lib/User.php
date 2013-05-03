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

    private $db = null;
    private $details = null;
    private $userIdentifier = null;

    public function __construct($db, $userIdentifier)
    {
        if ($db === null || $userIdentifier === null) {
            throw new Exception("You probably meant User::CreateUser");
        }

        $this->db = $db;
        $this->userIdentifier = $userIdentifier;

        $this->details = json_decode($db->get($userIdentifier));
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

    public function getHashedPassword() {
        return $this->details->{'hashedPassword'};
    }

    public function getPasswordSalt() {
        return $this->details->{'passwordSalt'};
    }
}
