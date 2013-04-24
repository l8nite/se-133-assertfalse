<?php
class Match {

	private $database;
	private $uuid;
	private $profile;

	/**
	 * Constructor.
	 *
	 * @param
	 */
	public function __construct($db, $uuid) {
		$this->database = $db;
		$this->uuid = $uuid;
		$this->profile = new Profile($db, $uuid);
	}

	/**
	 *
	 */
	public function match() {
		$user_type = $this->profile->getProfile()->{'user_type'};
		$array = NULL;

		if ($user_type == 'MENTOR') {
			$array = self::scoreAllMentees($this->profile->getExperience()->{'keywords'});
			arsort($array);
		}
		elseif ($user_type == 'MENTEE') {
			$array = self::scoreAllMentors($this->profile->getGoals()->{'keywords'});
			arsort($array);
		}

		return $array;
	}

	/**
	 *
	 */
	private function scoreAllMentors($keywords) {
		$allUsers = $this->database->keys('user:profile:*');
		$array = array();

		foreach($allUsers as $user) {
			$profile = new Profile($this->database, substr($user, 13)); //strip off 'user:profile:'
			$user_type = $profile->getProfile()->{'user_type'};
			if ($user_type == 'MENTOR' || $user_type == 'BOTH') {
				$array[$profile->getUUID()] = $this->score($keywords, $profile->getExperience()->{'keywords'}); //this vs that profile
			}
		}

		return $array;
	}

	/**
	 *
	 */
	private function scoreAllMentees($keywords) {
		$allUsers = $this->database->keys('user:profile:*');
		$array = array();

		foreach($allUsers as $user) {
			$profile = new Profile($this->database, substr($user, 13)); //strip off 'user:profile:'
			$user_type = $profile->getProfile()->{'user_type'};
			if ($user_type == 'MENTEE' || $user_type == 'BOTH') {
				$array[$profile->getUUID()] = $this->score($keywords, $profile->getGoals()->{'keywords'}); //this vs that profile
			}
		}

		return $array;
	}

	/**
	 *
	 */
	public static function filter($string) {
		$dictionary = array("i","am","could","would","should");

		$split = preg_split("/[.,:;\s\!\?-]+/", $string);
		$keywords = array();

		foreach($split as $word) {
			$word = strtolower($word);
			if (!empty($word) && !in_array($word, $dictionary) && !in_array($word, $keywords)) //if word is: not empty, not in filter, not repeated
				array_push($keywords, $word);
		}

		return $keywords;
	}

	/**
	 *
	 */
	private static function score($array1, $array2) {
		$score = 0;

		foreach ($array1 as $word1) {
			foreach ($array2 as $word2) {
				if ($word1 == $word2)
					$score++;
			}
		}

		return $score;
	}
}
?>