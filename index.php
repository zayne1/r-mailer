<?php 
/**
 * Main entry point.
 * Message types (birthday/annivesary) can be changed via the cfg file in config/main.php
 * Simply change 'messageType' val to 'anniversary' in cfg file config/main.php to use a 
 * that messenger.
 */
date_default_timezone_set('Africa/Johannesburg');

require('class/Config.php');
require('class/Model.php');
require('class/BirthdayMessenger.php');
require('class/AnniversaryMessenger.php');
Config::init();

$model = new Model();

// Strategy pattern below:

$messageType = Config::getConfig('messageType');

switch ($messageType) {
    case 'birthday':
        $messenger = new BirthdayMessenger($model);
        break;

    // Change 'messageType' val to 'anniversary' in cfg file config/main.php to use a this messenger
    case 'anniversary':
        $messenger = new AnniversaryMessenger($model); 
        break;
    
    default:
        $messenger = new BirthdayMessenger;
        break;
}

$messenger->send();