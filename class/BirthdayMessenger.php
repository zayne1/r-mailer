<?php
/**
 * BirthdayMessenger
 * Sends the email (for real if you uncomment the commented block in send())
 * Sets a flag to only allow one email run per day.
 */

require_once('InterfaceMessenger.php');

class BirthdayMessenger implements InterfaceMessenger {

    protected $messageType;
    protected $message;
    protected $birthdaysArray;
    protected $sentFlagName;
    
    public function __construct(Model $model) {
        
        $this->messageType = Config::getConfig('messageType');
        $this->message = Config::getConfig('messageDetails')->{$this->messageType}->message;
        $this->birthdaysArray = $model->getTodaysBirthdays();
        $this->sentFlagName = $this->messageType . '-' . date('Y-m-d') . '.txt';
    }

    public function send() {
        
        if ($this->_getSentFlag()) {
        
            echo "\r\n {$this->messageType} already completed for today";

        } else {
        
            $birthdayNamesList = null;

            foreach ($this->birthdaysArray as $key => $value) {
                $birthdayNamesList .= $value->name . ', ';
            }
        
            $birthdayNamesList = rtrim($birthdayNamesList, ', ');

            // below we output what we can send. Further down is a comment block of code that can actually send an email
            echo 'send message';
            echo "\r\n -- Email sent to " . Config::getConfig('emailTarget') . " -- \r\n";
            echo "\r\n -- Email contents: " . $this->message .' ' . $birthdayNamesList . " -- \r\n";

            // Below mailer code was used in recent project, modified for realm. Should work (but not locally)
            /*
            $replyEmail = 'info@realm.co.za';
            $headers = 'From: Realm <realm_email@realm.com>' . "\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n" .
            'Reply-To: Realm <' . $replyEmail . ">\r\n";

            mail(
                Config::getConfig('emailTarget'), 
                "Today's Staff Birthdays", 
                $this->message .' ' . $birthdayNamesList, 
                $headers
            );
            */        
            $this->_setSentFlag();
        }
    }

    public function _setSentFlag() {
        /* here we could update the 'lastNotification' field on the records in the API, 
        but there's no documentation to show if this is possible. I would usually exec a
        curl command to update the API. 
        Since we can't POST to the API, we could go a more low tech route:
        Upon successful email birthday message sent, we create a local file named with 
        the current date.
        That will serve as a flag to disallow subsequent birthday emails being sent */

        file_put_contents($this->sentFlagName, "This file was created by the mailer system. Do not delete.");
    }   

    public function _getSentFlag() {
        return file_exists($this->sentFlagName);
    }
}
