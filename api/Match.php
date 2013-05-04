<?php
/**
 * This class allows a user to match with all other mentors or mentees based on a scoring algorithm.
 */
class Match {

	private $database;
	private $uuid;
	private $profile;

	/**
	 * Constructor for Match object.
	 *
	 * @param connection $db Redis connection object.
	 * @param string $uuid User UUID.
	 */
	public function __construct($db, $uuid) {
		$this->database = $db;
		$this->uuid = $uuid;
		$this->profile = new Profile($db, $uuid);
	}

	/**
	 * Executes matching algorithm and generates column-based multi-dimensional array of results. Scores of 0 are not returned.
	 *
	 * @return array[] Column-based multi-dimensional array: UUID, score, full name, title, description.
	 */
	public function match($searchKeywords = NULL) {
		$user_type = $this->profile->getProfile()->{'user_type'};
		$array = NULL;

		if ($searchKeywords == NULL) { //profile comparison
			if ($user_type == 'MENTOR') {
				$array = self::scoreAllMentees($this->profile->getExperience()->{'keywords'});
			} elseif ($user_type == 'MENTEE') {
				$array = self::scoreAllMentors($this->profile->getGoals()->{'keywords'});
			}
		} else { //search parameter comparison
			if ($user_type == 'MENTOR') {
				$array = self::scoreAllMentees($searchKeywords);
			} elseif ($user_type == 'MENTEE') {
				$array = self::scoreAllMentors($searchKeywords);
			}
		}

		//multi-dimensional sort and convert row-based array to column-based
		$idCol          = array();
		$scoreCol       = array();
		$nameCol        = array();
		$titleCol       = array();
		$descriptionCol = array();
		foreach ($array as $key => $row) {
			if ($row[0] > 0) { //do not return if score is 0
				$idCol[]          = $key;
				$scoreCol[]       = $row[0];
				$nameCol[]        = $row[1];
				$titleCol[]       = $row[2];
				$descriptionCol[] = $row[3];
			}
		}
		array_multisort($scoreCol, SORT_NUMERIC, SORT_DESC,
			$idCol,
			$nameCol,
			$titleCol,
			$descriptionCol);
		$array = array($idCol, $scoreCol, $nameCol, $titleCol, $descriptionCol);

		return $array;
	}

	/**
	 * Scores array of keywords against all mentors' experience keywords.
	 *
	 * @param string[] $keywords Array of keywords.
	 * @return array[] Row-based multi-dimensional array: key = UUID & value = {score, full name, title, description}.
	 */
	private function scoreAllMentors($keywords) {
		$allUsers = $this->database->keys('user:profile:*');
		$array = array();

		foreach($allUsers as $user) {
			$profile = new Profile($this->database, substr($user, 13)); //strip off 'user:profile:'
			$user_type = $profile->getProfile()->{'user_type'};
			if ($user_type == 'MENTOR' || $user_type == 'BOTH') {
				$array[$profile->getUUID()] = array($this->score($keywords, $profile->getExperience()->{'keywords'}),
					$profile->getProfile()->{'first'} . ' ' . $profile->getProfile()->{'last'},
					$profile->getProfile()->{'title'},
					$profile->getExperience()->{'experience_description'});
			}
		}

		return $array;
	}

	/**
	 * Scores array of keywords against all mentees' goal keywords.
	 *
	 * @param string[] $keywords Array of keywords.
	 * @return array[] Row-based multi-dimensional array: key = UUID & value = {score, full name, title, description}.
	 */
	private function scoreAllMentees($keywords) {
		$allUsers = $this->database->keys('user:profile:*');
		$array = array();

		foreach($allUsers as $user) {
			$profile = new Profile($this->database, substr($user, 13)); //strip off 'user:profile:'
			$user_type = $profile->getProfile()->{'user_type'};
			if ($user_type == 'MENTEE' || $user_type == 'BOTH') {
				$array[$profile->getUUID()] = array($this->score($keywords, $profile->getGoals()->{'keywords'}),
					$profile->getProfile()->{'first'} . ' ' . $profile->getProfile()->{'last'},
					$profile->getProfile()->{'title'},
					$profile->getGoals()->{'goal_description'});
			}
		}

		return $array;
	}

	/**
	 * Splits a string on given regex and filters out words based on a dictionary. Words that are not filtered are converted to lower case.
	 *
	 * @param string $string User profile entry.
	 * @return string[] Array of keywords.
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
	 * Counts the number of words that exist in both of two string arrays.
	 *
	 * @param string[] $array1 String array.
	 * @param string[] $array2 String array.
	 * @return integer Comparison score.
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