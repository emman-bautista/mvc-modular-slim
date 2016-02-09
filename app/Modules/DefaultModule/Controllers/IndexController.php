<?php 
namespace App\Modules\DefaultModule\Controllers;

/**
* 
*/
class IndexController extends \App\Controllers\BaseController
{	
	protected $templateName = 'Default';

	// Parameters $request, $response and $args show always be declared.
	function home($request, $response, $args) {
		$this->render($response, 'index.phtml', ['name'=>'Emman']);
	}

	function about($request, $response, $args) {
		$this->render($response, 'about.phtml', ['title'=>'About']);	
	}
}