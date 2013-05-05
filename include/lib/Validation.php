<?php
require_once 'UUID.php';
require_once 'Mailer.php';

/**
 * A class for managing a MentorWeb user's session
 * Upon construction, determines if the user is logged in or not
 * Has facilities for logging a user in or out
 */
class Validation
{
    const TOKEN_VALIDATED = "true";
    const TOKEN_NOT_VALIDATED = "false";
    

    //private $sessionIdentifier = null;
    
    //private $isLoggedIn = false;
    private $db = null;
    private $UUID = null;
    //private $token = null;
    //private $validated = false;

    public function __construct($db, $UUID)
    {
        if ($db === null) {
            throw new Exception('Missing $db parameter to Session::__construct');
        }

        $this->db = $db;
        $this->UUID = $UUID;
        /*
        $this->generateToken();
        $details = json_decode($this->db->get("uuid:validation:$this->UUID"));
        $this->token = $details->{'token'};
        $this->validated = ($details->{'validated'} === self::TOKEN_VALIDATED);
        */
    }
    
    public function getToken()
    {
        $details = json_decode($this->db->get("uuid:validation:$this->UUID"));
        return $details->{'token'};
    }
    
     public function isValidated()
    {
        $details = json_decode($this->db->get("uuid:validation:$this->UUID"));
        return ($details->{'validated'} == self::TOKEN_VALIDATED);
    }
    
    public function generateToken()
    {
        $jsonDetails = $this->db->get("uuid:validation:$this->UUID");
        if ($jsonDetails == "")
        {
           $token = UUID::v4();
           $details = array(
                'token' => $token,
                'validated' => self::TOKEN_NOT_VALIDATED
            );
           $this->db->set("uuid:validation:$this->UUID", json_encode($details));
           return;
            
        }
        else
        {
            return; // token already exists
        }
    }
    
    public function validate($token)
    {
        if ($this->isValidated())
            return;
        else
        {
            if($token == $this->getToken())
            {
                $details = json_decode($this->db->get("uuid:validation:$this->UUID"));
                $details->{'validated'} = self::TOKEN_VALIDATED;
                $this->db->set("uuid:validation:$this->UUID", json_encode($details));
                //$this->validated = true;
            }
        }
    }

    public function sendValidationEmail()
    {
       $user = User::GetUserWithIdentifier($this->db, $this->UUID);
       //var_dump($user);
       Mailer::mail($user->getUsername(), 'Action Required to Activate Membership for MentorWeb', Mailer::validateBody($user->getUsername(), $this->getToken()));
    }
    
    
}
?>
