<?php
class Profile {

	private $database;
	private $uuid;

	/**
	 * Constructor for Profile object.
	 *
	 * @param $db Predis database client.
	 * @param $uuid Raw UUID string.
	 */
	public function __construct($db, $uuid) {
		$this->database = $db;
		$this->uuid = $uuid;
	}

	/**
	 * Gets user's UUID.
	 *
	 * @return string User's UUID.
	 */
	public function getUUID() {
		return $this->uuid;
	}

	/**
	 * Get Contact object.
	 *
	 * @return string[] User's contact entry.
	 */
	public function getContact() {
		return json_decode($this->database->get('user:contact:' . $this->uuid));
	}

	/**
	 * Get Profile object.
	 *
	 * @return string[] User's profile entry.
	 */
	public function getProfile() {
		return json_decode($this->database->get('user:profile:' . $this->uuid));
	}

	/**
	 * Get Experience object.
	 *
	 * @return string[] User's experience entry.
	 */
	public function getExperience() {
		return json_decode($this->database->get('user:experience:' . $this->uuid));
	}

	/**
	 * Get Goals object.
	 *
	 * @return string[] User's goals entry.
	 */
	public function getGoals() {
		return json_decode($this->database->get('user:goals:' . $this->uuid));
	}

	//vvvv Mainly for Create Account function. vvvv
	/**
	 * Updates user's profile entry with title. For second signup page only!
	 *
	 * @param connection $db Redis connection object.
	 * @param string $uuid UUID.
	 * @param string $title User's new title.
	 */
	public static function updateTitle($db, $uuid, $title) {
		$profileEntry = json_decode($db->get('user:profile:' . $uuid));
		$profileEntry->{'title'} = $title;
		$db->set('user:profile:' . $uuid, json_encode($profileEntry));
	}

	/**
	 * Updates user's profile entry with description. For second signup page only!
	 *
	 * @param connection $db Redis connection object.
	 * @param string $uuid UUID.
	 * @param string $desc User's new description.
	 */
	public static function updateDescription($db, $uuid, $desc) {
		$profileEntry = json_decode($db->get('user:profile:' . $uuid));
		$profileEntry->{'description'} = $desc;
		$db->set('user:profile:' . $uuid, json_encode($profileEntry));
	}

	/**
	 * Generates a new, random UUID.
	 *
	 * @return string UUID
	 */
	public static function generateUUID() {
		return self::randomString(8) . '-' . self::randomString(4) . '-4' . self::randomString(3) . '-8' . self::randomString(3) . '-' . self::randomString(12);
	}

	/**
	 * Generates a random string of specified length.
	 *
	 * @param integer $len Desired string length.
	 * @return string Random string.
	 */
	private static function randomString($len) {
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$charlen = strlen($chars);
		$rand = "";
		for ($i = 0; $i < $len; $i++) {
			$rand .= $chars[rand(0, $charlen - 1)];
		}
		return $rand;
	}

	/**
	 * Sets user's password entry with a salt and hash.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $id UUID.
	 * @param string $pw User's password.
	 */
	public static function setPassword($db, $id, $pw) {
		$salt = self::randomString(8);
		$hash = crypt($pw, $salt);
		$passwordEntry = array (
			'pass' => $hash,
			'salt' => $salt
		);
		$db->set('user:password:' . $id, json_encode($passwordEntry));
	}

	/**
	 * Sets user's contact entry.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $id UUID
	 * @param string $email User's email address.
	 * @param string $zip User's zip code.
	 */
	public static function setContact($db, $id, $email, $zip) {
		$contactEntry = array (
			'email'    => $email,
			'zip_code' => $zip
		);
		$db->set('user:contact:' . $id, json_encode($contactEntry));
	}

	/**
	 * Sets user's profile entry.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $id UUID
	 * @param string $fname User's first name.
	 * @param string $lname User's last name.
	 * @param string $ttl User's title.
	 * @param string $desc User's description.
	 * @param string $type User's type (MENTOR, MENTEE, BOTH).
	 * @param string $zip User's zip code.
	 */
	public static function setProfile($db, $id, $fname, $lname, $ttl, $desc, $type, $zip) {
		$profileEntry = array (
			'first'       => $fname,
			'last'        => $lname,
			'title'       => $ttl,
			'description' => $desc,
			'user_type'   => $type,
			'zip_code'    => $zip
		);
		$db->set('user:profile:' . $id, json_encode($profileEntry));
	}

	/**
	 * Set user's goal entry.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $id UUID
	 * @param string $ttl User's title.
	 * @param string $desc User's goals description.
	 */
	public static function setGoals($db, $id, $ttl, $desc) {
		$goalsEntry = array (
			'title'            => $ttl,
			'goal_description' => $desc,
			'keywords'         => Match::filter($desc)
		);
		$db->set('user:goals:' . $id, json_encode($goalsEntry));
	}

	/**
	 * Set user's experience entry
	 *
	 * @param connection $db Redis connection object.
	 * @param string $id UUID
	 * @param string $desc User's experience description.
	 */
	public static function setExperience($db, $id, $desc) {
		$experienceEntry = array (
			'experience_description' => $desc,
			'keywords'               => Match::filter($desc)
		);
		$db->set('user:experience:' . $id, json_encode($experienceEntry));
	}
	//^^^^ Mainly for Create Account function. ^^^^
}
?>