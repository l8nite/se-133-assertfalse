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
	public static function filter($string) {
		$dictionary = array("i","am");
		$split = preg_split("/[.,:;\s\!\?-]+/", $string);
		$keywords = array();
		
		foreach($split as $word) {
			$word = strtolower($word);
			if (!in_array($word, $dictionary)) //if word is not in filter dictionary
				array_push($keywords, $word);
		}
		
		return $keywords;
	}
	
	/**
	 *
	 */
	public function getAllGoals() {
		return $this->database->keys('user:goals:*');
	}
	
	/**
	 *
	 */
	public function getAllExperience() {
		return $this->database->keys('user:experience:*');
	}
}
?>