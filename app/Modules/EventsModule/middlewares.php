<?php 

use Respect\Validation\Validator as v;

$container['eventValidation'] = function () {
  //Create the validators
  
  $validators = array(
    'title' => $v::notEmpty(),
    'date_start' => v::date(),
    'date_end' => v::date(),
    'date_start' => v::notEmpty()
  );

  return new \DavidePastore\Slim\Validation\Validation($validators);
};