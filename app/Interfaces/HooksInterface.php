<?php 
namespace App\Interfaces;

interface HookInterface {
	public function onBeforeSaveToDB();
	public function onAfterSaveToDB();
}