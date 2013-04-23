<?php
class Profile {

	private $database;
	private $uuid;

	/**
	 * Constructor.
	 *
	 * @param $db Predis database client.
	 * @param $uuid Raw UUID string.
	 */
	public function __construct($db, $uuid) {
		$this->database = $db;
		$this->uuid = $uuid;
	}

	/**
	 * Get Contact object.
	 * @return Array.
	 */
	public function getContact() {
		return json_decode($this->database->get('user:contact:' . $this->uuid));
	}

	/**
	 * Get Profile object.
	 * @return Array.
	 */
	public function getProfile() {
		return json_decode($this->database->get('user:profile:' . $this->uuid));
	}

	/**
	 * Get Experience object.
	 * @return Array.
	 */
	public function getExperience() {
		return json_decode($this->database->get('user:experience:' . $this->uuid));
	}

	/**
	 * Get Goals object.
	 * @return Array.
	 */
	public function getGoals() {
		return json_decode($this->database->get('user:goals:' . $this->uuid));
	}

	//vvvv Mainly for Create Account function. vvvv
	public static function updateTitle($db, $uuid, $title) {
		$profileEntry = json_decode($db->get('user:profile:' . $uuid));
		$profileEntry->{'title'} = $title;
		$db->set('user:profile:' . $uuid, json_encode($profileEntry));
	}

	public static function updateDescription($db, $uuid, $desc) {
		$profileEntry = json_decode($db->get('user:profile:' . $uuid));
		$profileEntry->{'description'} = $desc;
		$db->set('user:profile:' . $uuid, json_encode($profileEntry));
	}

	public static function generateUUID() {
		return self::randomString(8) . '-' . self::randomString(4) . '-4' . self::randomString(3) . '-8' . self::randomString(3) . '-' . self::randomString(12);
	}

	private static function randomString($len) {
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$charlen = strlen($chars);
		$rand = "";
		for ($i = 0; $i < $len; $i++) {
			$rand .= $chars[rand(0, $charlen - 1)];
		}
		return $rand;
	}

	public static function setPassword($db, $id, $pw) {
		$salt = self::randomString(8);
		$hash = crypt($pw, $salt);
		$passwordEntry = array (
			'pass' => $hash,
			'salt' => $salt
		);
		$db->set('user:password:' . $id, json_encode($passwordEntry));
	}

	public static function setContact($db, $id, $email, $zip) {
		$contactEntry = array (
			'email'    => $email,
			'zip_code' => $zip
		);
		$db->set('user:contact:' . $id, json_encode($contactEntry));
	}

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

	public static function setGoals($db, $id, $ttl, $desc) {
		$goalsEntry = array (
			'title'            => $ttl,
			'goal_description' => $desc,
			'keywords'         => Match::filter($desc)
		);
		$db->set('user:goals:' . $id, json_encode($goalsEntry));
	}

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