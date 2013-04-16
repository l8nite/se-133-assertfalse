<?php
class Session {
	public static function resolveSessionID($db, $sid) {
		$sessionEntry = json_decode($db->get('session:user:' . $sid));
		return substr($sessionEntry[0], 5); //strip off the 'user:'
	}

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

	private static function generateSessionID() {
		return randomString(8) . '-' . randomString(4) . '-4' . randomString(3) . '-9' . randomString(3) . '-' . randomString(12);
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
}
?>