<?php 

namespace App\Modules;
use \App\Container\AppContainer as App;

class BaseModule implements \App\Interfaces\ModuleInterface{
	// To be used in template namespace
	protected $templateName = null;
	// Module version
	protected $version = 1.0;
	// Used as variable for the AppContainer
	protected $app = null;
	// Used to register the path and referencing
	protected $path = null;

	public function __construct() {
		
		$ref = new \ReflectionClass(static::class);
		$this->path = $ref->getFileName();		

		$this->app = App::getInstance();
		$this->registerTemplate();
		$this->registerSchema();
		$this->registerRoutes();

		return $this;

	}

	public function registerSchema() {

	}

	public function registerRoutes() {

		$routePath = dirname($this->path) . '/Routes.php';
		if(file_exists($routePath)) {
			require $routePath;
		}

	}

	public function registerTemplate() {
		if($this->templateName == null) return false;

		$templatePath = dirname($this->path) . "/Templates";
 		$this->app->getContainer()->view->getEnvironment()->getLoader()->addPath($templatePath, $this->templateName);
	}

}