<?php 

namespace App\Core;
use \App\Core\AppContainer as App;

class BaseModule implements \App\Interfaces\ModuleInterface{
	// To be used in template namespace
	protected $templateNamespace = null;
	// Module version
	protected $version = 1.0;
	// Used as variable for the AppContainer
	protected $app = null;
	// Used to register the path and referencing
	protected $path = null;
	protected $menu = null;

	public function __construct() {
		
		$ref = new \ReflectionClass(static::class);
		$this->path = $ref->getFileName();
		$this->app = App::getInstance();
		$this->registerTemplate();
		$this->registerSchema();
		$this->registerRoutes();
		$this->registerMiddlewares();
		$this->registerEvents();
		$this->setAcl();
		$this->registerMenu();
		return $this;

	}

	public function registerSchema() {
		require dirname($this->path) . '/schema.php';
	}

	public function registerRoutes() {
		$routePath = dirname($this->path) . '/routes.php';
		if(file_exists($routePath)) {
			require $routePath;
		}
	}

	private function setAcl() {
		$container = $this->app->getContainer();
		$aclClass = $container['acl'];
		$aclPath = dirname($this->path) . '/acl.php';
		if(file_exists($aclPath)) {
			$aclArray = require $aclPath;
			// APPLICATION ROLES
			foreach ($aclArray['roles'] as $key => $value) {
			    if(is_array($value)) {
			        $this->addRole($value[0], $value[1]);
			        continue;
			    }
			    $this->addRole($value);
			}

			foreach ($aclArray['permissions'] as $key => $value) {
			    // APPLICATION RESOURCES
			    // Application resources == Slim route patterns
			    $aclClass->addResource($value['route']);
			    // APPLICATION PERMISSIONS
			    // Now we allow or deny a role's access to resources. The third argument
			    // is 'privilege'. We're using HTTP method as 'privilege'.
			    $aclClass->allow($value['role'], $value['route'], $value['methods']);
			}
		}
	}

	public function registerTemplate() {
		if($this->templateNamespace == null) return false;

		$templatePath = dirname($this->path) . "/Templates";
 		$this->app->getContainer()->view->getEnvironment()->getLoader()->addPath($templatePath, $this->templateNamespace);
	}

	public function registerMiddlewares()
	{
		$middlewarePath = dirname($this->path) . '/middlewares.php';
		if(file_exists($middlewarePath)) {
			require $middlewarePath;
		}
	}


	public function registerEvents()
	{
		$eventsPath = dirname($this->path) . '/events.php';
		if(file_exists($eventsPath)) {
			require $eventsPath;
		}
	}

	public function registerMenu()
	{
		$menuPath = dirname($this->path) . '/menu.php';
		

		if(file_exists($menuPath)) {
			
			$menuItems = require $menuPath;
			
			$this->app->getContainer()->menu->addMenu($menuItems);
		}
	}
}