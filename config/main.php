<?php
/**
 * Config file
 * 
 */

return array(

    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Realm',
    'APIUrlEmployees'=>'https://interview-assessment-1.realmdigital.co.za/employees',
    'APIUrlNoBirthdays'=>'https://interview-assessment-1.realmdigital.co.za/do-not-send-birthday-wishes',
    'emailTarget'=>'john@doe.com',
    'messageType'=>'birthday',

    'messageDetails'=>array(
        'birthday'=>array(
            'message'=>'Happy Birthday',
        ),
        'anniversary'=>array(
            'message'=>'Happy Anniversary',
        ),
    ),
);