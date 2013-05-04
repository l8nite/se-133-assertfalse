<?php
require_once 'lib/RedisClient.php';
require_once 'lib/Session.php';
require_once 'lib/User.php';

$db = RedisClient::GetConnectedInstance();
$session = new Session($db);
$user = null;

if ($session->isLoggedIn())
{
    $user = new User($db, $session->getUserIdentifier());
}

if ($requireAuthenticated && !$session->isLoggedIn())
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
    </head>

    <body>

    <!-- main page container, closed in footer.php -->
    <div class="container">

        <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <a class="brand" href="/index.php">MentorWeb</a>
                <ul class="nav">
                <?php
                    $pages = array(
                        'index.php' => '<i class="icon-home"></i> Home',
                        'about.php' => '<i class="icon-book"></i> About',
                    );

                    $pageName = basename($_SERVER['PHP_SELF']);
                    foreach ($pages as $link => $description) {
                        if ($pageName === $link) {
                            echo '<li class="active"><a href="#">' . $description . '</a></li>';
                        }
                        else {
                            echo '<li><a href="' . $link . '">' . $description . '</a></li>';
                        }
                    }
                ?>
                <?php if ($session->isLoggedIn()): ?>
                <!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="./edit-profile.php">Edit Profile</a></li>
                        <li><a href="#">Upgrade to Premium</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">Mentors</li>
                        <li><a href="findamentor.php">Find a Mentor</a></li>
                        <li><a href="#">Review a Mentor</a></li>
                        <li><a href="#">Manage Mentors</a></li>
                    </ul>
                </li>
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
