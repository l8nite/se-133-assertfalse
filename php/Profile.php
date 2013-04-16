<?php
class Profile {
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
}
?>