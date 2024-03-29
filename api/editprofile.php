﻿<?php
/** 
 * This script is used to update a user's information.
 */
$redirectOnFailure = '/index.php';
include '../include/api-header.php';

$reqParameters = array('inputTitle', 'inputSummary', 'inputGoals', 'inputExperience', 'inputUserType');

foreach ($reqParameters as $parameter)
{
    if (!isset($_POST[$parameter])) {
        header("Location: /index.php");
        exit;
    }

    // TODO: validate parameter values instead of blindly trusting user input
}

$title = $_POST['inputTitle'];
$summary = $_POST['inputSummary'];
$goals = $_POST['inputGoals'];
$experience = $_POST['inputExperience'];
$userType = $_POST['inputUserType'];

$profile = array(
    'title' => $title,
    'summary' => $summary,
    'goals' => $goals,
    'experience' => $experience
);

$user->setUserType($userType);
$user->setProfile($profile);

header("Location: /index.php");
