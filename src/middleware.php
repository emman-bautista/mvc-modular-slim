<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
// 

use Respect\Validation\Validator as v;

// Register provider
$container['loginValidation'] = function () {
  //Create the validators
  $usernameValidator = v::notEmpty()->alnum()->noWhitespace()->length(1, 10);
  $ageValidator = v::numeric()->positive()->between(1, 20);
  $emailValidator = v::email()->noWhitespace();
  $firstNameValidator = v::notEmpty();
  $lastNameValidator = v::notEmpty();
  $roleValidator = v::notEmpty();
  $companyValidator = v::notEmpty();
  $passwordValidator = v::length(6, null);

  $validators = array(
    'email' => $emailValidator,
    'password' => $passwordValidator,
  );

  return new \DavidePastore\Slim\Validation\Validation($validators);
};

$container['registerValidation'] = function () {
  //Create the validators
  $usernameValidator = v::notEmpty()->alnum()->noWhitespace()->length(1, 10);
  $ageValidator = v::numeric()->positive()->between(1, 20);
  $emailValidator = v::email()->noWhitespace();
  $firstNameValidator = v::notEmpty();
  $lastNameValidator = v::notEmpty();
  $roleValidator = v::notEmpty();
  $companyValidator = v::notEmpty();
  $passwordValidator = v::length(8, null);

  $validators = array(
    'email' => $emailValidator,
    'password' => $passwordValidator,
    'first_name' => $firstNameValidator,
    'last_name' => $lastNameValidator
  );

  return new \DavidePastore\Slim\Validation\Validation($validators);
};


// route middleware
$container['homeRedirect'] = function($container){
  
  $uri = $container->get('request')->getUri();
  
  $identity = $container->get('authenticator')->getIdentity();
  die(print_r($identity));

	return true;
};