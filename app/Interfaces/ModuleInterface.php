<?php 
namespace App\Interfaces;

interface ModuleInterface {
	public function registerSchema();
	public function registerRoutes();
	public function registerTemplate();
}