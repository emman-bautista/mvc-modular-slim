<?php

namespace App\Modules\DefaultModule;

class Register extends \App\Utilities\Module{
	protected $name;

	public function __construct() {
		

		//extends your the class
		$this->name = "Default";

		//extend the class now;
		return parent::__construct();
	}

	public function registerSchema() {

	}

	public function registerRoutes() {
		$this->app->get('/', '\App\Modules\DefaultModule\Controllers\HomeController:home');
	}

	public function registerTemplate() {
		$templatePath = __DIR__ . "/Templates";
 		$this->app->getContainer()->view->getEnvironment()->getLoader()->addPath($templatePath, 'Default');
	}
}