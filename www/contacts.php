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

    function showProfileFor(uid) {
        selectedContactUID = uid;

        $.get('/api/profile.php', { 'uid': uid }, function (returnData) {
            var response = $.parseJSON($.trim(returnData));

            $('#contacts-content-area').empty().append(
                '<h3>' + response.username + '</h3>'
            );

            if (response.profile !== undefined) {
                var rating = $('<div class="rateit" data-rateit-value="3.5"></div>');
                rating.rateit();

                $('#contacts-content-area').append(
                    '<div class="row-fluid"><div class="span3"></div><div class="span6"><img src="images/Bill-Nye.jpg"/></div><div class="span3"></div></div>' +
                    '<div class="row-fluid"><div class="span2"><b>Summary:</b></div><div class="span9">' + response.profile.summary + '</div></div>' +
                    '<div class="row-fluid"><div class="span2"><b>Goals:</b></div><div class="span9">' + response.profile.goals + '</div></div>' +
                    '<div class="row-fluid"><div class="span2"><b>Experience:</b></div><div class="span9">' + response.profile.experience + '</div></div>'
                );

                $('#contacts-content-area').append(rating);
            }
            else {
                $('#contacts-content-area').append('<div><h2>This user has not created their profile yet!</h2></div>');
            }
        });
    }
    </script>

<?php
	include('../include/footer.php');
?>
