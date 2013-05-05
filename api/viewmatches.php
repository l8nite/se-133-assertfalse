<?php
//disable domain access control
header('Access-Control-Allow-Origin: *');

require_once '../include/api-header.php';
require '../include/lib/Match.php';

$session = new Session(RedisClient::GetConnectedInstance());
if (!$session->isLoggedIn())
{
    header("Location: /index.php");
    exit;
}

$details = $user->getDetails();
if (!array_key_exists('profile', $details)) { //if no profile
	header("Location: /edit-profile.php");
    exit;
}
elseif (array_key_exists('profile', $details) && isset($_REQUEST['search-query'])) { //if skill search
	if (strlen($_REQUEST['search-query']) == 0) {
		echo json_encode(array('error' => 'No search parameters given.'));
	} else {
		$match = new Match($db, $user);
		$result = $match->match(Match::filter($_REQUEST['search-query'])); //TODO validate input

		if (empty($result[0]))
			echo json_encode(array('error' => 'No matches found. Try again later.'));
		else
			echo json_encode($result);
	}
}
elseif (array_key_exists('profile', $details)) { //if profile match
	$match = new Match($db, $user);
	$result = $match->match();

	if (empty($result[0]))
		echo json_encode(array('error' => 'No matches found. Try again later.'));
	else
		echo json_encode($result);
}
?>
