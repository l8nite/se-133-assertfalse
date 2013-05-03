<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title><?php echo $pageTitle || 'MentorWeb' ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="styles/bootstrap.css" rel="stylesheet">
        <link href="styles/bootstrap-responsive.css" rel="stylesheet">
        <link href="styles/mentorweb.css" rel="stylesheet">
    </head>

    <body>
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
                                <li><a href="#about">About</a></li>
                            </ul>
                            <?php
                                if($isLoggedIn == false):
                            ?>
                                <a class="btn btn-success" href="signin.php">Sign In</a>
                            <?php else: ?>
                                <a class="btn btn-success" href="SignOut_script.php">Sign Out</a>
                            <?php endif; ?>
                        </div><!--/.nav-collapse -->
                    </div><!-- /.navbar-inner -->
                </div><!-- /.navbar -->
            </div> <!-- /.container -->
        </div><!-- /.navbar-wrapper -->

<!-- end of header.php included content -->
