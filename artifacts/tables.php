<?php 

use Illuminate\Database\Capsule\Manager as Capsule;

$logger = $app->getContainer()->logger;
$schema = Capsule::schema();

// Use Capsule to create schema below:
// and logger just incase you want to log in console ($logger->info([some text]))



