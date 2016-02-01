<?php 


namespace App\Utilities;


class Menu
{
	private $app;
	function __construct()
	{
		$this->app = \App\AppContainer::getInstac();
	}

	function getMenu() {
		$this->app->appContainer()->menu;
	}

	function render() {

	}
}