MentorWeb
=
Team Assert(false) - SE133 Project

The MentorWeb site is primarily written in PHP.
MentorWeb
=
Team Assert(false) - SE133 Project

The MentorWeb site is primarily written in PHP.

To set up a local development environment you need:

- <a href="http://httpd.apache.org/">Apache</a>, <a href="http://php.net/">PHP</a>, and <a href="http://redis.io/">Redis</a>

The website content is primarily written in PHP and HTML within the *www* subdirectory.

APIs which support the site live within the *api* subdirectory

Interface documentation is in the *docs* directory

You should configure the site such that requests to http://yourhost/ load **home.php** in the *www* subdirectory by default.
You also need to ensure that requests to http://yourhost/api are routed to the *api* subdirectory.
