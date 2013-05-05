<?php
/** This page tells the user whether they have been validated or not.
 */

$pageTitle = 'Register Account';

require_once '../include/lib/RedisClient.php';
require_once '../include/lib/Validation.php';
require_once '../include/lib/User.php';

$db = RedisClient::GetConnectedInstance();

if(isset($_GET['username']))
{
    $username = $_GET['username'];
    $UUID = $db->get("user_id_for:$username");
    if ($UUID == "")
    {
        $result = false;
    }
    else
    {
        $validator = new Validation($db, $UUID);
        $result = $validator->isValidated();
    }
}
else
    $result = false;

include('../include/header.php');
/*
$username = null;
if (isset($_REQUEST['username'])) {
    $username = $_REQUEST['username'];
}

$username = null;
if (isset($_REQUEST['username'])) {
    $username = $_REQUEST['username'];
}

*/

?>
<div class="container-fluid" >
    <div class="row-fluid">
        <div class="span12">
            <div class="">
                <h2>MentorWeb Registration</h2>
                <?php if($result): ?>
                    <p>Thank you, <?php echo $username; ?>. Your registration is now complete.</p>
                <?php else: ?>
                    <p>Thank you for registering. 
                       An email has been sent with details on how to activate your account. 
                    <p>
                <?php endif; ?>
            </div>
        </div><!--/span-->
    </div><!--/row-->
</div>


<?php
    include('../include/footer.php');
?>
