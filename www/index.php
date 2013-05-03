<?php
$pageTitle = "Home";
include('../include/header.php');

if (!$isLoggedIn)
{
    include('../include/pages/home-marketing.php');
}
else
{
    include('../include/pages/home.php');
}

include('../include/footer.php');
?>
