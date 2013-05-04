<?php
include '../../include/api-header.php';

$my_uid = $user->getIdentifier();
respond_success($db->get("messages:$my_uid:unread"));
?>
