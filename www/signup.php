<?php
	include('./header.php');
?>

    <div class="container-fluid" >
      <div class="row-fluid">
		<div class="span2">
		</div>
        <div class="span8">
          <div class="hero-unit">
              <h2>MentorWeb Sign Up</h2>
              <p>In order to join the MentorWeb, we need to know a little more about you. Please take the time to fill out the details below and decide what role you would like to pursue. </p>
          </div>
          <div class="row-fluid">
            <div>
                <form class="form-horizontal" id="mainForm">
					<fieldset>
						<legend>Account</legend>
						<div class="control-group">
							<label class="control-label" for="inputEmail">Email Address</label>
							<div class="controls">
								<input type="email" name="inputEmail" id="inputEmail" placeholder="Email Address">
								<span class="help-block">Example: JohnDoe@Email.com</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Password</label>
							<div class="controls">
								<input type="password" name="inputPassword" id="inputPassword" placeholder="Password">
								<span class="help-block">Password must contain an upper and lower case letter, a number, and symbol !@#$%^&*() </span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPasswordConfirm">Confirm Password</label>
							<div class="controls">
								<input type="password" name="inputPasswordConfirm" id="inputPasswordConfirm" placeholder="Password">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" >Account Type</label>
							<div class="controls">
								<input type="radio" name="typeOptions" id="menteeRadio" value="MENTEE">
								Mentee

							</div>
							<div class="controls">
								<input type="radio" name="typeOptions" id="mentorRadio" value="MENTOR">
								Mentor
							</div>
							<div class="controls">
								<input type="radio" name="typeOptions" id="bothRadio" value="BOTH">
								Both
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Contact</legend>
						<div class="control-group">
							<label class="control-label" for="inputFirst">First Name</label>
							<div class="controls">
								<input type="text" name="inputFirst" id="inputFirst" placeholder="First Name">
								<span class="help-block">Example: Bill</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputLast">Last Name</label>
							<div class="controls">
								<input type="text" name="inputLast" id="inputLast" placeholder="Last Name">
								<span class="help-block">Example: Nye</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputZip">Zip Code</label>
							<div class="controls">
								<input type="text" name="inputZip" id="inputZip" placeholder="Zip Code">
								<span class="help-block">Example: 95117</span>
							</div>
						</div>
					</fieldset>
					<div class="row-fluid">
						<div class="span4"></div>
						<div class="span4"><button class="btn btn-success btn-large" type="submit">Sign Up</button></div>
						<div class="span4"></div>
					</div>
				</form>
            </div>
			<div class="span2">
			</div>
          </div>
		  <div class="span2">
			</div>
        </div><!--/span-->

      </div><!--/row-->

<?php
	include('./footer.php');
?>
    <script>
		$('#mainForm').on('submit', function(event) {
			event.preventDefault(); //TODO could not find original listener, search and disable safely
			$.post('../../php/createaccount.php', $('#mainForm').serialize(), function(returnData) {
				window.location.replace("./signup1.php"); //redirect to next sign up page
			}, 'text');
		});
	</script>
	
	  </body>
</html>