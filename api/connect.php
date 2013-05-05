<?php
/** 
 * This script prevents invalid connect requests.
 */
//disable domain access control
header('Access-Control-Allow-Origin: *');

require_once '../include/api-header.php';

$session = new Session(RedisClient::GetConnectedInstance());
if (!$session->isLoggedIn())
{
    header("Location: /index.php");
    exit;
}

if (isset($_REQUEST['connect']) && UUID::is_valid(substr($_REQUEST['connect'], 5))) {
	$db->zadd('contacts:' . $_REQUEST['connect'], time(), $user->getIdentifier());
	$db->zadd('contacts:' . $user->getIdentifier(), time(), $_REQUEST['connect']);
	echo json_encode(array('success' => 'Connected.'));
}
else
	echo json_encode(array('error' => 'Invalid connection request!'));
?>
