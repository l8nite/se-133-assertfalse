<?php
	include('./header.php');
?>

    <div class="container-fluid">
      <div class="row-fluid">
		<div class="span2">
		</div>
        <div class="span8">
          <div class="hero-unit">
              <h2>Create Your Profile</h1>
              <p>This profile will be shared with other Mentors and Mentees to help you connect with suitable peers.</p>
          </div>
          <div class="row-fluid">
            <div>
                <form class="form-horizontal" id="mainForm">
					<fieldset>
						<legend>Profile</legend>
						<div class="control-group">
							<label class="control-label" for="inputTitle">Title</label>
							<div class="controls">
								<input type="text" name="inputTitle" id="inputTitle" placeholder="Title">
								<span class="help-block">Example: Senior Software Engineer and Basketball Coach</span>
							</div>
						</div>

						<label class="control-label" for="inputSummary">Summary</label>
						<div class="controls">
							<textarea type="text" rows="4" name="inputSummary" id="inputSummary" placeholder="Summary"></textarea>
							<span class="help-block">Explain something about yourself.</span>
						</div>
					</fieldset>
					<fieldset>
						<legend>Goals</legend>
						<div class="control-group">
							<label class="control-label" for="inputGoals">Goals</label>
							<div class="controls">
								<textarea type="text" rows="4" name="inputGoals" id="inputGoals" placeholder="Goals"></textarea>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Experience</legend>
						<div class="control-group">
							<label class="control-label" for="inputExperience">Experience</label>
							<div class="controls">
								<textarea type="text" rows="4" name="inputExperience" id="inputExperience" placeholder="Experience"></textarea>
							</div>
						</div>
					</fieldset>
					<div class="row-fluid">
						<div class="span4"></div>
						<div class="span4"><button class="btn btn-primary btn-large" type="submit">Save Profile</button></div>
						<div class="span4"></div>
					</div>
				</form>
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
			$.post('/php/createaccount.php', $('#mainForm').serialize(), function(returnData) {
				window.location.replace("./findamentor.php"); //redirect to next sign up page
			}, 'text');
		});
</script>
  </body>
</html>