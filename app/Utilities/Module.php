<?php 

namespace App\Utilities;

class Module implements \App\Interfaces\ModuleInterface{
	protected $name;
	protected $version = 1.0;
	protected $app;

	function __construct() {
		$this->app = \App\AppContainer::getInstance();
	}

	function initialize() {
		$this->initializeSchema();
		$this->initializeRoutes();
	}

	function initializeSchema() {

	}

	function initializeRoutes() {

	}

}