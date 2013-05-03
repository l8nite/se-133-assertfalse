<?php
require_once 'lib/RedisClient.php';
require_once 'lib/Session.php';

$session = new Session(RedisClient::GetConnectedInstance());

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

    </head>

    <body>

    <!-- main page container, closed in footer.php -->
    <div class="container">

        <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <a class="brand" href="#">MentorWeb</a>
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
                        <li><a href="./profile-edit.php">Edit Profile</a></li>
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
                <a id="logout-button" class="btn btn-primary pull-right" href="#">Sign Out</a>
                <?php endif; ?>
            </div>
        </div>


<?php
/*
        <div class="navbar-wrapper">
            <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
            <div class="container">
                <div class="navbar navbar-inverse">
                    <div class="navbar-inner">
                        <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="brand" href="index.php">MentorWeb</a>

                        <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class="active"><a href="#">Home</a></li>
                                <li><a href="#about">About</a></li>
                            <?php
                                if($isLoggedIn == false):
                            ?>
                                <li><div><a class="btn btn-success" href="signin.php">Sign In</a></div>
                            <?php else: ?>
                                <a class="btn btn-success" href="SignOut_script.php">Sign Out</a>
                            <?php endif; ?>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div><!-- /.navbar-inner -->
                </div><!-- /.navbar -->
            </div> <!-- /.container -->
        </div><!-- /.navbar-wrapper -->

*/?>
<!-- end of header.php included content -->
