<?php

namespace App\Modules\DefaultModule;

class Register extends \App\Core\BaseModule{
	

	public function __construct() {

		// Extends your the class
		$this->templateNamespace = 'Default';

		//extend the class now;
		return parent::__construct();
	}

	
}