<?php 

namespace App\Controllers;

/**
* Base Controller that accepts Slim App Container
*/
class BaseController
{
	protected $container = null;
	
	function __construct($container)
	{
		$this->container = $container;
	}

	function render($response, $template, $args) {
		return $this->container->view->render($response, $template, $args);
	}
}