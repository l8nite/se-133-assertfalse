<?php
/*
This page gets loaded when the user is logged in and visits the home page
 */
?>
<p>
This is the user's home page.
</p>
<p>
I'm not really sure what should go here, so here's a dump of your user profile data.
</p>
<textarea style="width: 50%; height: 800px;">
<?php var_dump($user->getDetails()); ?>
</textarea>
