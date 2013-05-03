<?php
	include('./header.php');
?>

    <div class="container-fluid" style="margin-top:20px;">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Profile</li>
              <li class="active"><a href="#">Overview</a></li>
              <li><div class="divider" /></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Experience</a></li>
              <li><a href="#">Goals</a></li>
              <li><a href="#">Education</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9" id="mainField" style="display:none">
          <div class="row-fluid">
            <div class="span4">
                <img src="images/John-Doe.jpg" alt="" />
            </div>
            <div class="span8">
                <h2 id="nameField">loading...</h2>
                <h4 id="titleField">loading...</h4>
                <p  id="descField">loading...</p>
            </div>
            <p><a href="#" class="btn btn-primary btn-small">Update &raquo;</a></p>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <h3>Contact</h3>
              <p id="contactField">loading...</p>
            <p><a href="#" class="btn btn-primary btn-small">Update &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span12">
              <h3>Experience</h3>
              <p id="expField">loading...</p>
            <p><a href="#" class="btn btn-primary btn-small">Update &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span12">
              <h3>Goals</h3>
              <p id="goalsField">loading...</p>
              <p><a href="#" class="btn btn-primary btn-small">Update &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span12">
              <h3>Education</h3>
              <p>loading...</p>
              <p><a href="#" class="btn btn-primary btn-small">Update &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->
	</div>

   <script>
		$(document).ready(function () {
			$.get('../../php/viewownprofile.php', function(returnData) {
				var profileData = $.parseJSON($.trim(returnData)); //PHP seems to add two invisible, trimmable characters in front of output

				$('#nameField').html(profileData.name);
				$('#titleField').html(profileData.title);
				$('#descField').html(profileData.description);
				$('#contactField').html(profileData.email);
				$('#expField').html(profileData.experience);
				$('#goalsField').html(profileData.goals);

				$('#mainField').show(0); //div mainField has inline "display:none"
			}, 'text');
		});
	</script>

<?php
	include('./footer.php');
?>
