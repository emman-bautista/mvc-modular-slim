<?php 
namespace App\Modules\DefaultModule\Controllers;

/**
* 
*/
class IndexController extends \App\Controllers\BaseController
{	
	protected $templateNamespace = 'Default';

	// Parameters $request, $response and $args show always be declared.
	function login($request, $response, $args) {
		$this->render($response, 'index.phtml', ['name'=>'Emman']);
	}

	function register($request, $response, $args) {
		$this->render($response, 'about.phtml', ['title'=>'About']);	
	}
	
}