<div class="container-fluid">

<?php
// only show the page-header if they haven't given us details before
$details = $user->getDetails();
$profile = null;

if (array_key_exists('profile', $details)):
    $profile = $details->{'profile'};
else:
?>
    <div class="page-header">
        <h1>Create your profile <small>(it'll only take a minute!)</small></h1>
        <p>It looks like you haven't given us your profile details yet!  This profile will be shared with other Mentors and Mentees to help you connect with suitable peers.</p>
    </div>
<?php endif; ?>

<!-- begin edit profile form -->
    <div class="row-fluid">
        <div class="span12">
            <form action="/api/editprofile.php" method="POST" class="form-horizontal" id="mainForm">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="inputTitle">Title</label>
                        <div class="controls">
                        <?php
                            $defaultTitleValue = isset($profile) && array_key_exists('title', $profile) ? ' value="' . $profile->{'title'} . '"' : '';
                        ?>
                        <input type="text" name="inputTitle" id="inputTitle" placeholder="Senior Software Engineer" <?php echo $defaultTitleValue ?>/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="inputSummary">Summary</label>
                        <div class="controls">
                        <textarea type="text" rows="4" name="inputSummary" id="inputSummary" placeholder="Give us some details about yourself..."><?php echo isset($profile) ? $profile->{'summary'} : "" ?></textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="control-group">
                    <label class="control-label" for="inputGoals">Goals</label>
                    <div class="controls">
                        <textarea type="text" rows="4" name="inputGoals" id="inputGoals" placeholder="What do you aspire towards?"><?php echo isset($profile) ? $profile->{'goals'} : "" ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputExperience">Experience</label>
                    <div class="controls">
                        <textarea type="text" rows="4" name="inputExperience" id="inputExperience" placeholder="What are some interesting things you've done?"><?php echo isset($profile) ? $profile->{'experience'} : "" ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" >Account Type</label>
                    <div class="controls">
                    <input type="radio" name="inputUserType" id="menteeRadio" value="MENTEE" <?php if ($user->getDetails()->{'mentorType'} === "MENTEE"): ?>checked="checked"<?php endif; ?>>
                        Mentee
                    </div>
                    <div class="controls">
                    <input type="radio" name="inputUserType" id="mentorRadio" value="MENTOR" <?php if ($user->getDetails()->{'mentorType'} === "MENTOR"): ?>checked="checked"<?php endif; ?>>
                        Mentor
                    </div>
                </div>

                    <div class="form-actions">
                    <div>
                        Pssst.  You can also <a href="">import your LinkedIn profile <img src="images/linkedin-logo.png" style="width: 25px; height: 25px;" /></a>
                    </div>
                    <button class="btn btn-primary btn-large" type="submit">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
<!-- end edit profile form -->

</div>
