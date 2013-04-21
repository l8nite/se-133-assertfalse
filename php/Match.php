<?php
class Match {

	///**
	// * Constructor.
	// *
	// * @param
	// */
	//public function __construct() {
	//}
	
	/**
	 *
	 */
	public static function filter($string) {
		$dictionary = array("i","am");
		$split = preg_split("/[.,:;\s\!\?-]+/", $string);
		$keywords = array();
		
		foreach($split as $word) {
			if (!in_array(strtolower($word), $dictionary))
				array_push($keywords, $word);
		}
		
		return $keywords;
	}
}
?>