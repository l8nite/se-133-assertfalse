<?php
$pageTitle = 'Register Account';
include('../include/header.php');

if ($session->isLoggedIn()) {
    header("Location: /index.php");
    exit;
}

$username = null;
if (isset($_REQUEST['username'])) {
    $username = $_REQUEST['username'];
}
?>

<div class="container-fluid" >
    <div class="row-fluid">
        <div class="span12">
            <div class="">
                <h2>MentorWeb Sign Up</h2>
                <p>In order to join the MentorWeb, we need to know a little more about you.</p>
                <p>Please take the time to fill out the details below and decide what role you would like to pursue. </p>
            </div>
            <div class="row-fluid">
                <div>
                    <form class="form-horizontal" id="signup-form" action="/api/createaccount.php" method="POST">
                        <fieldset>
                            <legend>Account</legend>
                            <div class="control-group">
                                <label class="control-label" for="inputEmail">Email Address</label>
                                <div class="controls">
                                    <input type="text" name="inputEmail" id="inputEmail" placeholder="Bill.Nye@ScienceGuy.com"<?php if($username !== null):?> value="<?php echo($username);?>"<?php endif;?>>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputPassword">Password</label>
                                <div class="controls">
                                    <input type="password" name="inputPassword" id="inputPassword" placeholder="Must have A-Z, a-z, !@#$%^&amp;*()">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputPasswordConfirm">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" name="inputPasswordConfirm" id="inputPasswordConfirm" placeholder="Password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Account Type</label>
                                <div class="controls">
                                    <input type="radio" name="typeOptions" id="menteeRadio" value="MENTEE">
                                    Mentee

                                </div>
                                <div class="controls">
                                    <input type="radio" name="typeOptions" id="mentorRadio" value="MENTOR">
                                    Mentor
                                </div>
                                <div class="controls">
                                    <input type="radio" name="typeOptions" id="bothRadio" value="BOTH">
                                    Both
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Contact</legend>
                            <div class="control-group">
                                <label class="control-label" for="inputFirst">First Name</label>
                                <div class="controls">
                                    <input type="text" name="inputFirst" id="inputFirst" placeholder="First Name">
                                    <span class="help-block">Example: Bill</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputLast">Last Name</label>
                                <div class="controls">
                                    <input type="text" name="inputLast" id="inputLast" placeholder="Last Name">
                                    <span class="help-block">Example: Nye</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputZip">Zip Code</label>
                                <div class="controls">
                                    <input type="text" name="inputZip" id="inputZip" placeholder="Zip Code">
                                    <span class="help-block">Example: 95117</span>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-actions">
                            <button class="btn btn-success btn-large" type="submit">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--/span-->

    </div><!--/row-->

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
$(function() {
    $.validator.addMethod('pwCheck', function (value, element) {
        return this.optional(element) ||
            (
                value.match(/[A-Z]/) &&
                value.match(/[a-z]/) &&
                value.match(/[!@#$%^&*()]/)
            );
    }, 'Password must contain an upper and lower case letter, a number, and symbol !@#$%^&*()');

    $('#signup-form').validate({
        rules: {
            inputEmail: {
                required: true,
                    email: true
            },
            inputPassword: {
                required: true,
                    minlength: 5,
                    pwCheck: true,
            },
            inputPasswordConfirm: {
                required: true,
                    minlength: 5,
                equalTo: "#inputPassword",
                pwCheck: true,
            },
            inputFirst: {
                required: true,
                    minlength: 2
            },
            inputLast: {
                required: true,
                    minlength: 2
            },
            inputZip: {
                required: true,
                    minlength: 5
            },
            typeOptions: {
                required: true
            },
        },
        highlight: function (el) {
            $(el).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function (el) {
            $(el).addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>

<?php
    include('../include/footer.php');
?>
