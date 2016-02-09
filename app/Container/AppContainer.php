<?php 

namespace App\Container;

use Slim\App;
 
class AppContainer
{
    private static $app = null;

    public static function getInstance($settings = array())
    {

        if (null === self::$app) {
            self::$app = self::makeInstance($settings);
        }

        return self::$app;
    }

    private static function makeInstance($settings)
    {
        $app = new App($settings);
        // do all logic for adding routes etc

        return $app;
    }
}