<?php
	include('./header.php');
?>
    <div class="container">
      <form class="form-signin" action="../../php/SignIn/SignIn_script.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
		<div class="row-fluid">
			To Become a member, <a href="./signup.php" >Click here</a>.
		</div>
        <input type="text" class="input-block-level" placeholder="Email address" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <a href="">Forgot your password?</a>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->

<?php
	include('./footer.php');
?>
  </body>
</html>