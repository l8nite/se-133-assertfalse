<?php
require_once 'UUID.php';
require_once 'Mailer.php';

/**
 * This class is used to validate a user's email.
 */
class Validation
{
    const TOKEN_VALIDATED = "true";
    const TOKEN_NOT_VALIDATED = "false";
    
    private $db = null;
    private $UUID = null;
   
    /** The constuctor.
     * 
     * @param Predis/Client $db The Predis client connected to the Predis database.
     * @param String $UUID The user's UUID.
     * @throws Exception Throws an exception when $db is null.
     */
    public function __construct($db, $UUID)
    {
        if ($db === null) {
            throw new Exception('Missing $db parameter to Session::__construct');
        }

        $this->db = $db;
        $this->UUID = $UUID;
       
    }
    
    /** Gets the token that user needs to validate the email address.
     * 
     * @return String The token.
     */
    public function getToken()
    {
        $details = json_decode($this->db->get("uuid:validation:$this->UUID"));
        return $details->{'token'};
    }
    
    /** Checks whether the user has validated their email.
     * 
     * @return boolean True if the user has validated their email; false otherwise.
     */
     public function isValidated()
    {
        $details = json_decode($this->db->get("uuid:validation:$this->UUID"));
        return ($details->{'validated'} == self::TOKEN_VALIDATED);
    }
    
    /** Generates a token in the database that user needs to validate his email. This function does nothing if it has already been called for a particular user.
     * 
     * 
     */
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
    
    /** Checks if the token presented is valid. This function does nothing if the user has already been validated. The results are stored in the database.
     * 
     * @param String $token The token to be checked.
     */
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

    /** Sends an email with a link that user can use to validate his email.
     * 
     */
    public function sendValidationEmail()
    {
       $user = User::GetUserWithIdentifier($this->db, $this->UUID);
       //var_dump($user);
       Mailer::mail($user->getUsername(), 'Action Required to Activate Membership for MentorWeb', Mailer::validateBody($user->getUsername(), $this->getToken()));
    }
    
    
}
?>
