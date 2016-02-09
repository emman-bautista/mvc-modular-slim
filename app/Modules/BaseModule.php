<?php 

namespace App\Modules;
use \App\Container\AppContainer as App;

class BaseModule implements \App\Interfaces\ModuleInterface{
	protected $name;
	protected $version = 1.0;
	protected $app;
	protected $path = null;


	function __construct() {
		
		$ref = new \ReflectionClass(static::class);
		$this->path = $ref->getFileName();

		$this->app = App::getInstance();
		$this->registerTemplate();
		$this->registerSchema();
		$this->registerRoutes();

		return $this;
	}

	function registerSchema() {

	}

	function registerRoutes() {

	}

	function registerTemplate() {

	}

}