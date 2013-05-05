<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mailer
 *
 * @author ryan
 */

require_once 'swift_required.php';

class Mailer {




   public static function mail($to, $subject, $body)
   {
        $GMAIL_USERNAME= 'noreply.mentorweb';
        $PASSWORD = 'pearl<eed';
        $FROM = 'noreply.mentorweb@gmail.com';
        $EMAILNAME = 'MentorWeb Team';

       $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
        ->setUsername($GMAIL_USERNAME)
        ->setPassword($PASSWORD);

      $mailer = Swift_Mailer::newInstance($transport);

      $message = Swift_Message::newInstance($subject)
        ->setFrom(array($FROM => $EMAILNAME))
        ->setTo(array($to))
        ->setBody($body);

      $result = $mailer->send($message);
   }

   public static function validateBody($username, $token)
   {

       $HOST_DOMAIN='assertfalse.pw';

       return
"Dear $username,

Thank you for registering at the MentorWeb. Before we can activate your account one last step must be taken to complete your registration.

Please note - you must complete this last step to become a registered member. You will only need to visit this URL once to activate your account.

To complete your registration, please visit this URL:
http://$HOST_DOMAIN/api/validate.php?username=$username&token=$token

If you are still having problems, please contact a member of our support staff.

All the best,
MentorWeb Team"
        ;
   }

}

?>
