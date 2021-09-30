<?php
/**
 * Static Config class that we can use anywhere
 * 
 */
class Config
{
    protected static $config = null;
    
    public static function init() {

        static::$config = require(dirname(__FILE__).'/../config/main.php');
        
        // recursively make all arrays and sub arrays into objects, so that 
        // we can acces via obj notation
        static::$config = json_decode(json_encode(static::$config), FALSE); 
    }

    public static function getConfig($item) {
        return static::$config->{$item};
    }
}