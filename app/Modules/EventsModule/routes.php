<?php 

// $this is the instance of the class that requires this file.

// Assign the HomeController namespace to make it shorter.

$indexController = '\App\Modules\EventsModule\Controllers\IndexController';

// Assign the /about route to $indexController with method home.
$this->app->get('/events', "$indexController:home")->setName('events');
$this->app->get('/events/create', "$indexController:home")->setName('events_create');
// Assign the /about route to $indexController with method about.
$this->app->get('/events/about', "$indexController:about")->setName('event_about'); 
$this->app->map(['GET', 'POST'], '/events/invite', "$indexController:invite")->setName('event_invite'); 

// Add more routes below if needed. Remember to user $indexController::[method] 
// and that method exist in the controller