<?php 


namespace App\Utilities;


class Menu
{
	private $app;
	private $menu = [];
	private $template = null;

	function __construct()
	{
		
		$this->app = \App\Core\AppContainer::getInstance();
	}

	function getMenu() {
		return $this->menu;
	}

	function setTemplate($template) {
		$this->template = $template;
	}

	function addMenu($menu = []) {
		$this->menu = array_merge($this->menu, $menu);
	}

	function render() {
		
		if($this->template != null ){
			return $this->container->view->render($response, "$this->template", $this->menu);
		}else {
			return $response->withStatus(500)
					->withHeader('Content-Type', 'text/html')
					->write('Template name not define in class ' . static::class);
		}
	}
}