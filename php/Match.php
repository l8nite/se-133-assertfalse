<?php
class Match {

	private $database;
	private $uuid;

	/**
	 * Constructor.
	 *
	 * @param
	 */
	public function __construct($db, $uuid) {
		$this->database = $db;
		$this->uuid = $uuid;
	}

	/**
	 *
	 */
	public function match() {
		
	}

	/**
	 *
	 */
	public function getAllGoals() {
		$allGoals = $this->database->keys('user:goals:*');
		//foreach($allGoals as $goalEntry) {
		//	json_decode($this->database->get('user:goals:' . $this->uuid));
		//}
	} 

	/**
	 *
	 */
	public function getAllExperience() {
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
	public static function score($array1, $array2) {
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