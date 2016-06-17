<?php 

// $this is the instance of the class that requires this file.

// Assign the HomeController namespace to make it shorter.

$indexController = '\App\Modules\UsersModule\Controllers\IndexController';

// Assign the /about route to $indexController with method home.
$this->app->get('/users/login', "$indexController:home");

// Assign the /about route to $indexController with method about.
$this->app->get('/users/register', "$indexController:about"); 

// Add more routes below if needed. Remember to user $indexController::[method] 
// and that method exist in the controller