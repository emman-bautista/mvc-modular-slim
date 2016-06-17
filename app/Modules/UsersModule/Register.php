<?php

namespace App\Modules\UsersModule;

class Register extends \App\Modules\BaseModule{
	

	public function __construct() {

		// Extends your the class
		$this->templateNamespace = 'Users';

		//extend the class now;
		return parent::__construct();
	}

	
}