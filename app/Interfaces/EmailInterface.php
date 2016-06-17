<?php 
namespace App\Interfaces;

interface EmailInterface {
	 function onRegister();
	 function onForgotPassword();
	 function onLogin();
	 function onActivation();
}