<?php
/**
This page lets a user post feedback aboutt the website.
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Your Feedback</title>
</head>

<body>
<?php
//Script 3.3 handle_form.php
//This page receives the data from feedback.html
//It will reveive: title, name, email, response, comments, and submit in $_POST.
$title = $_POST['title'];
$name = $_POST['name'];
$email = $_POST['email'];
$response = $_POST['response'];
$comments = $_POST['comments'];

//print the received data:
print "<p> Thank you, $title $name, for your comments.</p>
<p>You state that you found this example to be '$response' and added: <br />$comments <br />Should we contact you with your email: $email ?</p>";
?>
</body>
</html> 
