﻿<?php
/** 
 * This script is used to get unread messages.
 */
include '../../include/api-header.php';

$my_uid = $user->getIdentifier();
respond_success($db->hgetall("messages:$my_uid:unread"));
?>
