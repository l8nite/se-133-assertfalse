<?php
class Session {

	/**
	 * Maps a user's session key or session ID to their UUID.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $sid User's session ID.
	 * @return string User's UUID.
	 */
	public static function resolveSessionID($db, $sid) {
		$sessionEntry = json_decode($db->get('session:user:' . $sid));
		return substr($sessionEntry[0], 5); //strip off 'user:'
	}

	/**
	 * Creates a new session and session ID for a user.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $id User's UUID.
	 * @return string Random session ID that maps to user.
	 */
	public static function generateSession($db, $id) {
		$sid = self::generateSessionID();

		$userSessionEntry = array (
			'session:user:' . $sid
		);
		$db->set('user:session:' . $id, json_encode($userSessionEntry));

		$sessionUserEntry = array (
			'user:' . $id
		);
		$db->set('session:user:' . $sid, json_encode($sessionUserEntry));

		return $sid;
	}

	/**
	 * Generates a new, random session ID.
	 *
	 * @return string Session ID.
	 */
	private static function generateSessionID() {
		return self::randomString(8) . '-' . self::randomString(4) . '-4' . self::randomString(3) . '-9' . self::randomString(3) . '-' . self::randomString(12);
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
}
?>