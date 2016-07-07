<?php 

namespace App\Core;

/**
* Base Controller that accepts Slim App Container
*/
class BaseController
{
	protected $container = null;
	protected $templateNamespace = null;
	
	function __construct($container)
	{
		$this->container = $container;
	}

	function render($response, $template, $args) {
		$menu = $this->container->menu->getMenu();
		$args['menu'] = $menu;
		if($this->templateNamespace != null ){
			return $this->container->view->render($response, "@$this->templateNamespace/$template", $args);
		}else {
			return $response->withStatus(500)
					->withHeader('Content-Type', 'text/html')
					->write('Template name not define in class ' . static::class);
		}
	}

	

}