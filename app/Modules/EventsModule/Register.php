<?php

namespace App\Modules\EventsModule;

class Register extends \App\Modules\BaseModule{
	

	public function __construct() {

		// Extends your the class
		$this->templateNamespace = 'Events';

		//extend the class now;
		return parent::__construct();
	}

	
}