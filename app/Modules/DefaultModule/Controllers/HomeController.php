<?php 
namespace App\Modules\DefaultModule\Controllers;

/**
* 
*/
class HomeController extends \App\Controllers\BaseController
{
	function home($request, $response, $args) {
		$this->render($response, '@Default/index.phtml', ['name'=>'Emman']);
	}
}