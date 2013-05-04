<?php
	include('../include/header.php');
?>
    <div class="container-fluid" style="margin-top:20px;">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Mentors</li>
              <li class="active"><a href="#">Find a Mentor</a></li>
              <li><a href="#">Review a Mentor</a></li>
              <li><a href="#">Contact a Mentor</a></li>
              <li><a href="#">Manage Mentors</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div id="mainList" class="span9" style="display:none">
          <div class="hero-unit">
              <h2>Find A Mentor</h2>
              <p>Enter desired related skills of mentors to search</p>
              <form class="form-search" id="searchForm">
                  <div class="input-append">
                    <input type="text" class="search-query">
                    <button type="submit" class="btn">Search</button>
                  </div>
             </form>
          </div> <!-- COMMENT
          <div class="row-fluid">
            <div class="span4">
                <img src="images/John-Doe.jpg" alt="" />
            </div>
            <div class="span8">
                <h2>John Doe</h2>
                <h4>Embedded Systems Entrepreneur and Web Application Designer</h4>
                <p>Computer engineering has not only been my chosen educational path, but a passion. Between my professional career and education at San Jose State University, I have had an opportunity to use my time for digital hardware and web application projects. I am looking for a mentor to guide me toward my goal in computer engineering.</p>
            </div>
            <p><a href="#" class="btn btn-success btn-small">Connect &raquo;</a></p>
          </div>
          <div class="row-fluid">
            <div class="span4">
                <img src="images/Bill-Nye.jpg" alt="" />
            </div>
            <div class="span8">
                <h2>Bill Nye</h2>
                <h4>The Science Guy</h4>
                <p>Computer engineering has not only been my chosen educational path, but a passion. Between my professional career and education at San Jose State University, I have had an opportunity to use my time for digital hardware and web application projects. I am looking for a mentor to guide me toward my goal in computer engineering.</p>
            </div>
            <p><a href="#" class="btn btn-success btn-small">Connect &raquo;</a></p>
          </div> COMMENT -->
        </div><!--/span-->
      </div><!--/row-->

<?php
	include('../include/footer.php');
?>
	<script>
		$(document).ready(function () {
			$.get('/api/viewmatches.php', function(returnData) {
				//console.log(returnData);
				var data = $.parseJSON($.trim(returnData)); //PHP seems to add two invisible, trimmable characters in front of output
				console.log(data);
				populate(data);
			}, 'text');
		});

		$('#searchForm').on('submit', function(event) {
			event.preventDefault();
			$.post('../../php/viewmatches.php', $('#searchForm').serialize(), function(returnData) {
				var data = $.parseJSON($.trim(returnData)); //PHP seems to add two invisible, trimmable characters in front of output
				console.log(data);
				populate(data);
			}, 'text');
		});

		function populate(matchData) {
			$('.MentorWeb').empty(); //remote elements with class = MentorWeb, see rest of populate() code

			for (var i = 0; i < matchData[0].length; i++) {
				var divRowFluid = $('<div class="row-fluid MentorWeb"></div>');

				var divSpan4 = $('<div class="span4"></div>');
				var img = $('<img src="images/Bill-Nye.jpg" alt="" />');

				var divSpan8 = $('<div class="span8"></div>');
				var header2 = $('<h2>' + matchData[2][i] + '</h2>');
				var header4 = $('<h4>' + matchData[3][i] + '</h4>');
				var para = $('<p>' + matchData[4][i] + '</p>');

				var para2 = $('<p><a href="#" class="btn btn-success btn-small">Connect &raquo;</a></p>');

				divSpan4.append(img);
				divSpan8.append(header2);
				divSpan8.append(header4);
				divSpan8.append(para);
				divRowFluid.append(divSpan4);
				divRowFluid.append(divSpan8);
				divRowFluid.append(para2);

				$('#mainList').append(divRowFluid);
			}

			$('#mainList').show(0); //div mainList has inline "display:none"
		};
	</script>
	</body>
</html>