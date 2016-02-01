<?php 
namespace App\Interfaces;

interface ModuleInterface {
	public function initialize();
	public function initializeSchema();
	public function initializeRoutes();
}