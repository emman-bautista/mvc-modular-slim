<?php 

namespace App\Controllers;

use Respect\Validation\Validator as v;

/**
* 
*/
class UserController extends App\Core\BaseController
{

	function login($request, $response, $args) {

		/*if($this->container->get('authenticator')->hasIdentity()) {
		    return $response->withStatus(301)->withHeader('Location', $this->container->router->pathFor('home'));
		}*/

		$params = $request->getParsedBody();

	    if ($request->isPost()) {
	        $username = $params['email'];
	        $password = $params['password'];

	        /*if(!v::notEmpty()->validate($username)) {
	        	$this->container->flash->addMessage('Error', "Username is required.");
	        	return $response->withHeader('Location', $this->container->router->pathFor('login'));
	        }

	        if(!v::email()->validate($username)) {
	        	$this->container->flash->addMessage('Error', "Please use valid email address in Username field.");
	        	return $response->withHeader('Location', $this->container->router->pathFor('login'));
	        }

	        if(!v::notEmpty()->validate($password)) {
	        	$this->container->flash->addMessage('Error', "Password is required.");
	        	return $response->withHeader('Location', $this->container->router->pathFor('login'));
	        }
	        */
	       
	        if($this->container->loginValidation->hasErrors()){
	        	$errors = $this->container->loginValidation->getErrors();
	        	$error_messages = [];
	        	foreach ($errors as $key => $value) {
	        		
	        		$this->container->flash->addMessage('Error', str_replace("\"\"", ucfirst($key), $value[0]));
	        	}
	        	
	        	return $response->withHeader('Location', $this->container->router->pathFor('login'));
	        }

	        $result = $this->container->get('authenticator')->authenticate($username, $password);

	        if ($result->isValid()) {

	        	$twig_environment = $this->container->view->getEnvironment();
	        	$twig_environment->addGlobal('identity',  $result->getIdentity());

	        	$this->container->events->fire('auth.login', $result->getIdentity());

	            return $response->withHeader('Location', $this->container->router->pathFor('home'));
	        }

	       
	        
	        // Login failed, handle error here
	        $error_message =  $result->getMessages();
	        $this->container->flash->addMessage('Error', $error_message[0]);
	    }
	    
	    // Render login view here, perhaps.

		return $this->container->view->render($response, 'login.phtml', ['title' => 'Login']);
	}

	function register($request, $response, $args) {
	
		if($this->container->get('authenticator')->hasIdentity()) {
		    return $response->withRedirect($this->container->router->pathFor('home'));
		}

		$params = $request->getParsedBody();
		
	    if($request->isPost()) {
	    	$_SESSION['register_params'] = $params;
	    	
	    	if($this->container->registerValidation->hasErrors()){
	        	$errors = $this->container->registerValidation->getErrors();
	        	$error_messages = [];
	        	foreach ($errors as $key => $value) {
	        		
	        		$this->container->flash->addMessage('Error', str_replace("\"\"", ucfirst($key), $value[0]));
	        	}
	        	
	        	return $response->withHeader('Location', $this->container->router->pathFor('register'));
	        }

			$user = \App\Models\User::where('email', '=', $params['email'])->first();

			// User exist
			if($user) {
				 $this->container->flash->addMessage("Error", 'User already exist.');
				 $params['title'] = 'Register';
				 return $this->container->view->render($response, 'register.phtml', $params);
			}

			// Insert new user
			$user = new \App\Models\User;
			$user->email = $params['email'];
			$user->password = password_hash($params['password'], PASSWORD_DEFAULT);

			$result = $user->save();
			
			if($result) {
					// Create user profile
				$user_profile = new \App\Models\UserProfile;
				$user_profile->first_name = $params['first_name'];
				$user_profile->last_name = $params['last_name'];

				$user->profile()->save($user_profile);
				$this->container->flash->addMessage("Success", 'User added.');
				
				return $response->withRedirect($this->container->router->pathFor('login'));
			}

			exit;
	    }

	    $register_params = [
	    	'first_name' =>'',
			'last_name' =>'',
			'email' =>'',
			'password' =>'',
			'confirm_password' =>'',
	    ];
	    if(isset($_SESSION['register_params'])){
	    	$register_params =  $_SESSION['register_params'];
	    }


	    unset($_SESSION['register_params']);
	    return $this->container->view->render($response, 'register.phtml', ['title' => 'Register', 'params' =>$register_params]);

	}

	private function validateForm($params) {
		
		if(!v::notEmpty()->validate($params['first_name'])) {
			return [
				'isValid' => false,
				'message' => 'First name is required.'
			];
		}

		if(!v::notEmpty()->validate($params['last_name'])) {
			return  [
				'isValid' => false,
				'message' => 'Last name is required.'
			];
		}

		if(!v::notEmpty()->validate($params['email'])) {
			return  [
				'isValid' => false,
				'message' => 'Email is required.'
			];
		}

		if(!v::email()->validate($params['email'])) {
			return  [
				'isValid' => false,
				'message' => 'Business Email should be a valid email.'
			];
		}

		if(!v::notEmpty()->validate($params['password'])) {
			return  [
				'isValid' => false,
				'message' => 'Password is required.'
			];
		}

		if(!v::equals($params['confirm_password'])->validate($params['password'])) {
			return  [
				'isValid' => false,
				'message' => 'Password mismatched.'
			];
		}

		return [
			'isValid' => true,
			'message' => 'User saved.'
		];

	}


	function logout($request, $response, $args) {
		$user_id = $this->container->get('authenticator')->getIdentity();
	    $this->container->get('authenticator')->logout();
	    $this->container->events->fire("auth.logout", $user_id);
	    return $response->withStatus(301)->withHeader('Location', $this->container->router->pathFor('login'));
	}

}