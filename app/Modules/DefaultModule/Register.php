<?php

namespace App\Modules\DefaultModule;

class Register extends \App\Modules\BaseModule{
	

	public function __construct() {

		// Extends your the class
		$this->templateNamespace = 'Default';

		//extend the class now;
		return parent::__construct();
	}

	public function registerSchema() {
		require dirname($this->path) . '/Schema.php';
	}

	
}