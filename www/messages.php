<?php
    $pageTitle = 'Messages';
    $requireAuthenticated = true;
	include('../include/header.php');
?>

<style>
#messages-contacts-list {
    overflow-y: auto;
    border-right: 1px solid gray;
    height: 80%;
}

#messages-content-area {
    overflow-y: auto;
    height: 60%;
}
</style>

<div class="container-fluid">
    <div class="row-fluid" id="messages-layout-row">
        <div class="span3" id="messages-contacts-list">
            <h4> Contacts </h4>
            <?php
            $contacts = $user->getContacts();

            foreach ($contacts as $sender_userIdentifier) {
                $sender = User::GetUserWithIdentifier($db, $sender_userIdentifier);
                $sender_uid = $sender->getIdentifier();
                $sender_name = $sender->getUsername();
                echo "<a class=\"btn btn-link\" onclick=\"showMessagesWith('$sender_uid');\">$sender_name</a>";
            }
            ?>
        </div>
        <div class="span9">
            <div id="messages-content-area" style="margin-bottom: 20px;">
                <div style="padding-top: 100px; text-align: center;">
                    <h3>No conversation selected</h3>
                    <p>Select one of your conversations from the left or send a new message</p>
                </div>
            </div>

            <div id="send-message-area" class="well" style="display: none;">
                <textarea placeholder="Say something..." id="send-message-input" style="height: 80px; width: 100%;"></textarea>
                <a href="#" id="send-message-button" class="btn btn-primary btn-small">Send &raquo;</a>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
    var selectedInterlocuterUID = null;
    var lastDisplayedMessageCount = -1;

    $(function() {
        setInterval(refreshMessages, 1000);

        $('#send-message-button').click(sendMessage);

        $('#send-message-input').keypress(function (e) {
            if (e.which == 13 && !e.shiftKey) {
                $('#send-message-button').click();
            }
        });
    });

    function sendMessage() {
        var message = $('#send-message-input').val();

        if (message === "") {
            return;
        }

        $.get('/api/messages/send.php', { 'to': selectedInterlocuterUID, 'm': message }, function () {
            $('#send-message-input').val('');
            refreshMessages();
        });
    }

    function refreshMessages() {
        if (selectedInterlocuterUID === null) {
            return;
        }

        showMessagesWith(selectedInterlocuterUID);
    }

    function showMessagesWith(uid) {
        var newUser = uid !== selectedInterlocuterUID;
        selectedInterlocuterUID = uid;

        $.get('/api/messages/list.php', { 'with': uid }, function (returnData) {
            var response = $.parseJSON($.trim(returnData));

            if (!newUser && lastDisplayedMessageCount === response.messages.length) {
                return;
            }

            lastDisplayedMessageCount = response.messages.length;

            $('#messages-content-area').empty().append(
                '<h3>Messages with ' + response.with + '</h3>'
            );

            for (var i = 0; i < response.messages.length; ++i) {
                var message = response.messages[i];
                var d = new Date(message.time * 1000);
                var df = getISODateTime(d);
                var div = $(
                    '<div class="row-fluid">' +
                    '<div class="span6"><h5>' + message.name + '</h5></div>'
                    + '<div class="span6 date" style="text-align: right;"><h5>' + df + '</h5></div>'
                    + '</div><div class="row-fluid">'
                    + '<div class="span12">' + message.text + '</div></div>');
                $('#messages-content-area').append(div);
            }

            $('#messages-content-area').animate({ scrollTop: $('#messages-content-area')[0].scrollHeight }, 1000);
            $('#send-message-area').show();
//            $('#new-message-area').hide();
//            $('#message-area').show();

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

<?php
	include('../include/footer.php');
?>

<?php /*

<?php
	include('../include/header.php');
?>

    <script>
        var currentMessagesFrom = null;

        $(document).ready(function () {
            setInterval(displayMessagesFromCurrentUser, 500);

          $.get('../../php/getcontacts.php', function(returnData) {
            var senders = $.parseJSON($.trim(returnData));
            for (var i = 0; i < senders.length; ++i) {
                console.log(senders[i]);
                var li = $('<li uid="' + senders[i].uid + '">' + senders[i].username + '</li>');
                li.click(function() {
                    displayMessagesFrom($(this).attr('uid'));
                });
                $('#friends').append(li);
            }
          }, 'text');


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

        </script>
        </body>
</html>
*/?>
