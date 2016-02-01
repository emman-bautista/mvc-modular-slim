<?php

namespace App\Modules\UserManagement;

class Register extends \App\Utilities\Module{

	public function initializeSchema() {

	}

	public function initializeRoutes() {
		$this->app->get('/users', function($request, $response, $args) {
			$this->view->render($response, 'test.phtml', []);
		} );
	}
}