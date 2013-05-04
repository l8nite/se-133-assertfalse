<?php
    $pageTitle = 'Messages';
    $requireAuthenticated = true;
	include('../include/header.php');
?>

<style>
#messages-contacts-list {
    overflow-y: auto;
}
</style>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2" id="messages-contacts-list">
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
            <div> Contact 1 </div>
        </div>
        <div class="span10" id="messages-content-area">
            <div> Message content here </div>
        </div>
    </div>
</div>

<?php
	include('../include/footer.php');
?>
