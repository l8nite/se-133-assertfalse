<?php
	include('./header.php');
?>

    <div class="container-fluid" style="margin-top:20px;">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Profile</li>
              <li><a href="./profile.php">Overview</a></li>
              <li><div class="divider" /></li>
              <li class="active"><a href="#Contact">Contact</a></li>
              <li><a href="#Experience">Experience</a></li>
              <li><a href="#Goals">Goals</a></li>
              <li><a href="#Education">Education</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div class="row-fluid">
            <div class="span12">
                <form class="form-horizontal" id="mainForm">
					<fieldset ID="Contact">
						<legend>Contact Details</legend>
						<div class="control-group">
							<label class="control-label" for="inputEmail">Email</label>
							<div class="controls">
								<input type="text" name="inputEmail" id="inputEmail" placeholder="Email">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputFirst">First Name</label>
							<div class="controls">
								<input type="text" name="inputFirst" id="inputFirst" placeholder="First Name">
								
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputLast">Last Name</label>
							<div class="controls">
								<input type="text" name="inputLast" id="inputLast" placeholder="Last Name">
								
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Additional Contact Details</legend>
						<div class="control-group">
							<label class="control-label" for="inputFirst">Address</label>
							<div class="controls">
								<input type="text" name="inputStreet" id="inputStreet" class="input-xlarge" placeholder="Street Address">
							</div>
						</div>				
						<div class="control-group">
							<label class="control-label" for="inputCity">City</label>
							<div class="controls">
								<input type="text" name="inputCity" id="inputCity" class="input-small" placeholder="City">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputState">State</label>
							<div class="controls">
								<input type="text" name="inputState" id="inputState" class="input-mini" placeholder="State">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputZip">Zip Code</label>
							<div class="controls">
								<input class="input-mini" type="text" name="inputZip" id="inputZip" placeholder="Zip Code">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputCell">Cell Phone</label>
							<div class="controls">
								<input class="input-mini" type="text" name="inputCellArea" id="inputCellArea" placeholder="408">
								<input class="input-small" type="text" name="inputCell" id="inputCell" placeholder="555-3689">
							</div>
						</div>
					</fieldset>
					<fieldset ID="Experience">
						<legend>Experience</legend>
						<div class="control-group">
							<label class="control-label" for="inputFirst">Professional Experience</label>
							<div class="controls">
								<textarea rows="4" type="text" name="inputExperience" id="inputExperience" class="input-xlarge" placeholder="Experience"></textarea>
								<span class="help-block">Write about your past work experiences.</span>
							</div>
						</div>				
						<div class="control-group">
							<label class="control-label" for="inputInterest">Interests and Hobbies</label>
							<div class="controls">
								<textarea rows="4" type="text" name="inputInterest" id="inputInterest" class="input-xlarge" placeholder="I like basketball..."></textarea>
								<span class="help-block">Write about your interests and hobbies outside of your professional career.</span>
							</div>
						</div>
					</fieldset>
					<fieldset ID="Goals">
						<legend>Goals</legend>
						<div class="control-group">
							<label class="control-label" for="inputFirst">Future Prospects</label>
							<div class="controls">
								<textarea rows="4" type="text" name="inputGoals" id="inputGoals" class="input-xlarge" placeholder="Goals"></textarea>
								<span class="help-block">Write about your future goals, both longterm and short term for professional and personal growth.</span>
							</div>
						</div>				
					</fieldset>
					<fieldset ID="Education">
						<legend>Education</legend>
						<div class="control-group">
							<label class="control-label" for="inputDegree">Degrees</label>
							<div class="controls">
								<textarea rows="4" type="text" name="inputDegree" id="inputDegree" class="input-xlarge" placeholder="Bachelor of Computer Engineer, San Jose State University"></textarea>
								<span class="help-block">What degrees have you obtained in school?</span>
							</div>
							<label class="control-label" for="inputEducationOther">Other Notable Educational Accomplishments</label>
							<div class="controls">
								<textarea rows="4" type="text" name="inputEducationOther" id="inputEducationOther" class="input-xlarge" ></textarea>
								<span class="help-block">What other notable education have you obtained outside of school?</span>
							</div>
						</div>				
					</fieldset>
				</form>
            </div>
            <p><a href="#" class="btn btn-primary btn-small">Update &raquo;</a></p>           
          </div>
        </div><!--/span-->
      </div><!--/row-->

<?php
	include('./footer.php');
?>
  </body>
</html>