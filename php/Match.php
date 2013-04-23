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
		$profile = new Profile($this->database, $uuid);
	}

	/**
	 *
	 */
	public function match() {
	}

	/**
	 *
	 */
	public function compareAllMentors($keywords) {
		$allUsers = $this->database->keys('user:profile:*');
		$array = array();
		
		foreach($allUsers as $user) {
			$profile = new Profile($this->database, substr($user, 13)); //strip off 'user:profile:'
			if ($profile->getProfile()->{'user_type'} == 'MENTOR') {
				echo $array[$profile->getUUID()] = $this->score($keywords, $profile->getExperience()->{'keywords'}); //this vs that profile
			}
		}
		
		return $array;
	} 

	/**
	 *
	 */
	public function compareAllExperience() {
		return $this->database->keys('user:experience:*');
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