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
		}
		elseif ($user_type == 'MENTEE') {
			$array = self::scoreAllMentors($this->profile->getGoals()->{'keywords'});
		}

		//multi-dimensional sort and convert row-based array to column-based
		$idCol          = array();
		$scoreCol       = array();
		$nameCol        = array();
		$titleCol       = array();
		$descriptionCol = array();
		foreach ($array as $key => $row) {
			$idCol[]          = $key;
			$scoreCol[]       = $row[0];
			$nameCol[]        = $row[1];
			$titleCol[]       = $row[2];
			$descriptionCol[] = $row[3];
		}
		array_multisort($idCol,
		                $scoreCol, SORT_NUMERIC, SORT_DESC,
						$nameCol,
						$titleCol,
						$descriptionCol);
		$array = array($idCol, $scoreCol, $nameCol, $titleCol, $descriptionCol);

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
				$array[$profile->getUUID()] = array($this->score($keywords, $profile->getExperience()->{'keywords'}),
													$profile->getProfile()->{'first'} . $profile->getProfile()->{'last'},
													$profile->getProfile()->{'title'},
													$profile->getExperience()->{'experience_description'});
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
				$array[$profile->getUUID()] = array($this->score($keywords, $profile->getGoals()->{'keywords'}),
				                                    $profile->getProfile()->{'first'} . $profile->getProfile()->{'last'},
													$profile->getProfile()->{'title'},
				                                    $profile->getGoals()->{'goal_description'});
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
				$keywords[] = $word;
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