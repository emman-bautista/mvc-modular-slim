<?php 

use Illuminate\Database\Capsule\Manager as Capsule;

$logger = $this->app->getContainer()->logger;
$schema = Capsule::schema();
