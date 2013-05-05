<?php
require_once 'lib/RedisClient.php';
require_once 'lib/Session.php';
require_once 'lib/User.php';

$db = RedisClient::GetConnectedInstance();
$session = new Session($db);
$user = null;

if ($session->isLoggedIn())
{
    $user = User::GetUserWithIdentifier($db, $session->getUserIdentifier());
}

if (isset($requireAuthenticated) && $requireAuthenticated && !$session->isLoggedIn())
{
    header("Location: /");
    exit;
}

?>
<?php
    // TODO: remove debugging code
    error_reporting(E_ALL);
    ini_set('display_errors', True);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>MentorWeb<?php
        if ($pageTitle !== null) {
            echo " - $pageTitle";
        }?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <style>
        body  {
            padding-top: 20px;
        }
        </style>
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">

        <link href="styles/mentorweb.css" rel="stylesheet">


        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#logout-button').click(function() {
                    window.location.replace('/api/logout.php');
                });
            });
        </script>

        <script src="rateit/jquery.rateit.min.js"></script>
        <link href="rateit/rateit.css" rel="stylesheet">
    </head>

    <body>

    <!-- main page container, closed in footer.php -->
    <div class="container">

        <div class="navbar">
            <div class="navbar-inner">
                <a class="brand" href="/index.php">MentorWeb</a>
                <ul class="nav">
                <?php
                $unread_messages_count = null;
                if ($user !== null) {
                    $unread_messages_count = $db->hget('messages:' . $user->getIdentifier() . ':unread', 'total');
                }
                if ($unread_messages_count === null) {
                    $unread_messages_count = 0;
                }

                function isActive($page) {
                    $pageName = basename($_SERVER['PHP_SELF']);
                    if ($page === $pageName) {
                        echo ' class="active"';
                    }
                }
                ?>
                    <li <?php isActive('index.php') ?>><a href="index.php"><i class="icon-home"></i> Home</a></li>
                <?php if ($session->isLoggedIn()): ?>
                <li <?php isActive('contacts.php') ?>><a href="contacts.php"><i class="icon-book"></i> Contacts</a></li>
                <li <?php isActive('messages.php') ?>><a href="messages.php"><i class="icon-comment"></i> Messages <span class="badge badge-important" id="messages-unread-count" style="display: <?php echo $unread_messages_count ? 'visible' : 'none';?>"><?php echo $unread_messages_count ?></span></a></li>
                <li <?php isActive('edit-profile.php') ?>><a href="edit-profile.php"><i class="icon-user"></i> My Profile</a></li>
                <li <?php isActive('findamentor.php') ?>><a href="findamentor.php"><i class="icon-thumbs-up"></i> Find a Mentor</a></li>
                <?php endif; ?>
                </ul>
                <?php if (!$session->isLoggedIn()): ?>
                <form action="/api/login.php" method="POST" class="navbar-form pull-right">
                    <input class="span2" type="text" name="username" placeholder="Email">
                    <input class="span2" type="password" name="password" placeholder="Password">
                    <button type="submit" class="btn">Sign in</button>
                </form>
                <?php else: ?>
                <a id="logout-button" class="pull-right btn btn-primary vcenter" href="#">Sign Out</a>
                <div class="loggedinas pull-right">Signed in as: <?php echo($user->getUsername()); ?>&nbsp;</div>
                <?php endif; ?>
            </div>
        </div>

<!-- end of header.php included content -->
