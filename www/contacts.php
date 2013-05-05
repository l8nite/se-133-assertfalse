<?php
    $pageTitle = 'Connections';
    $requireAuthenticated = true;
	include('../include/header.php');
?>

<style>
#connections-contacts-list {
    overflow-y: auto;
    border-right: 1px solid gray;
    height: 80%;
}

#connections-content-area {
    overflow-y: auto;
    height: 60%;
}
</style>

<div class="container-fluid">
    <div class="row-fluid" id="contacts-layout-row">
        <div class="span3" id="contacts-contacts-list">
            <h4> Contacts </h4>
            <?php
            $contacts = $user->getContacts();
            foreach ($contacts as $sender_userIdentifier) {
                $sender = User::GetUserWithIdentifier($db, $sender_userIdentifier);
                $sender_uid = $sender->getIdentifier();
                $sender_name = $sender->getUsername();
                echo "<a class=\"btn btn-link\" onclick=\"showProfileFor('$sender_uid');\">$sender_name</a>";
                ?>
            <?php
            }
            ?>
        </div>
        <div class="span9">
            <div id="contacts-content-area" style="margin-bottom: 20px;">
                <div style="padding-top: 100px; text-align: center;">
                    <h3>Choose one of your contacts!</h3>
                    <p>Select one of your contacts from the left to view their profile</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
    var selectedContactUID = null;

    $(function() {
    });

    function showProfileFor(uid) {
        selectedContactUID = uid;
        /*

        $.get('/api/profile.php', { 'uid': uid }, function (returnData) {
            var response = $.parseJSON($.trim(returnData));

            $('#contacts-content-area').empty().append(
                '<h3>contacts with ' + response.with + '</h3>'
            );

            for (var i = 0; i < response.contacts.length; ++i) {
                var message = response.contacts[i];
                var d = new Date(message.time * 1000);
                var df = getISODateTime(d);
                var div = $(
                    '<div class="row-fluid">' +
                    '<div class="span6"><h5>' + message.name + '</h5></div>'
                    + '<div class="span5 date" style="text-align: right;"><h5>' + df + '</h5></div>'
                    + '</div><div class="row-fluid">'
                    + '<div class="span12">' + message.text + '</div></div>');
                $('#contacts-content-area').append(div);
            }

            $('#contacts-content-area').animate({ scrollTop: $('#contacts-content-area')[0].scrollHeight }, 1000);
            $('#send-message-area').show();
         */
        alert('show profile for: ' + uid);
    });

    }
    </script>

<?php
	include('../include/footer.php');
?>
