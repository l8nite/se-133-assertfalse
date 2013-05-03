<?php
	include('./header.php');
?>

    <div class="container-fluid" style="margin-top:20px;">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul id="friends" class="nav nav-list">
              <!-- TODO: make sure link color is right -->
              <li id="send-new-message-text" class="nav-header" style="color: blue;">Send new message</li>
              <li class="nav-header">Friends</li>
              <li><div class="divider" /></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9" id="message-area" style="display: none;">
          <div class="row-fluid">
            <div class="span12">
              <h3 id="messages-with">Messages</h3>
              <div id="messages-list"></div>
              <p><input id="message-text"/>&nbsp;<a href="#" id="send-message-button" class="btn btn-primary btn-small">Send &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
        <div class="span9" id="new-message-area" style="display: none;">
          <div class="row-fluid">
            <div class="span12">
              <h3>Send a new message</h3>
                <div class="control-group">
                  <label class="control-label" for="inputTo">To</label>
                  <div class="controls">
                    <input type="text" id="inputTo" placeholder="To">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputMessage">Message</label>
                  <div class="controls">
                    <input type="text" id="inputMessage" placeholder="Message">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                    <button id="send-new-message-button" class="btn">Send &raquo;</button>
                  </div>
                </div>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->
      </div><!--/row-->

<?php
	include('./footer.php');
?>
    <script>
        var currentMessagesFrom = null;

        $(document).ready(function () {
            setInterval(displayMessagesFromCurrentUser, 500);

          $.get('../../php/getcontacts.php', function(returnData) {
            var senders = $.parseJSON($.trim(returnData));
            for (var i = 0; i < senders.length; ++i) {
                console.log(senders[i]);
                var li = $('<li uuid="' + senders[i].uuid + '">' + senders[i].username + '</li>');
                li.click(function() {
                    displayMessagesFrom($(this).attr('uuid'));
                });
                $('#friends').append(li);
            }
          }, 'text');

          $('#send-message-button').click(function () {
            $.get('../../php/sendmessage.php', { 'to': currentMessagesFrom, 'm': $('#message-text').val() }, function () {
                $('#message-text').val('');
                displayMessagesFrom(currentMessagesFrom);
            });
          });

          $('#send-new-message-text').click(function () {
              currentMessagesFrom = null;
              $('#message-area').hide();
              $('#new-message-area').show();
          });

          $('#message-text').keypress(function (e) {
            if (e.which == 13) {
                $('#send-message-button').click();
            }
          });

          $('#inputMessage').keypress(function (e) {
            if (e.which == 13) {
                $('#send-new-message-button').click();
            }
          });

          $('#send-new-message-button').click(function () {
            $to = $('#inputTo').val();
            $m = $('#inputMessage').val();

            $.get('../../php/sendmessage.php', {'to': $to, 'm': $m}, function () {
                $('#inputTo').val('');
                displayMessagesFrom($to);
            });
          });
        });

        function displayMessagesFromCurrentUser() {
            if (currentMessagesFrom === null) {
                return;
            }

            displayMessagesFrom(currentMessagesFrom);
        }

        function displayMessagesFrom(sender) {
          currentMessagesFrom = sender;
          $.get('../../php/getmessages.php', { 'from': sender }, function (returnData) {
              var response = $.parseJSON($.trim(returnData));
              console.log(response);
              $('#messages-with').html('Messages with ' + response.with);

              $('#messages-list').empty();
              for (var i = 0; i < response.messages.length; ++i) {
                  var message = response.messages[i];
                  var d = new Date(message.time * 1000);
                  var df = getISODateTime(d);
                  var div = $('<div class="row-fluid"><div class="span2">' + df + '</div><div class="span3">' + message.name + '</div><div class="span7">' + message.text + '</div></div>');
                  $('#messages-list').append(div);
              }
              $('#new-message-area').hide();
              $('#message-area').show();
          });
        }

        function getISODateTime(d){
            // padding function
            var s = function(a,b){return(1e15+a+"").slice(-b)};

            // default date parameter
            if (typeof d === 'undefined'){
                d = new Date();
            };

            // return ISO datetime
            return d.getFullYear() + '-' +
                s(d.getMonth()+1,2) + '-' +
                s(d.getDate(),2) + ' ' +
                s(d.getHours(),2) + ':' +
                s(d.getMinutes(),2) + ':' +
                s(d.getSeconds(),2);
        }
        </script>
        </body>
</html>  
