<?php
/** 
 * This script is to retrieve a user's profile.
 */
include '../include/api-header.php';

if (!isset($_REQUEST['uid'])) {
    respond_error('missing "uid" parameter');
}

$contact = User::GetUser($db, $_REQUEST['uid']);

if ($contact === null) {
    respond_error("invalid 'uid' user");
}

respond_success($contact->getDetails());
?>
