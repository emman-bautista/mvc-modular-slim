<?php
// Routes

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });
// 

$app->get('/', function($request, $response, $args) {
	//print_r($this->get('authenticator')->getIdentity());
	$this->view->render($response, 'home.phtml', ['title' => 'Home']);
})->setName('home');

$app->map(['GET', 'POST'], '/login', function($request, $response, $args) {
	if($this->get('authenticator')->hasIdentity()) {
	    return $response->withStatus(301)->withHeader('Location', $this->router->pathFor('home'));
	}

	$params = $request->getParsedBody();

    if ($request->isPost()) {
        $username = $params['email'];
        $password = $params['password'];

        $result = $this->get('authenticator')->authenticate($username, $password);
        

        if ($result->isValid()) {
        	//die(print_r($result->getIdentity()));
        	$twig_environment = $this->view->getEnvironment();
        	$twig_environment->addGlobal('identity',  $result->getIdentity());

            return $response->withHeader('Location', $this->router->pathFor('home'));
        }
        
        // Login failed, handle error here
        $error_message =  $result->getMessages();
        $this->flash->addMessage('Error', $error_message[0]);
    }
    
    // Render login view here, perhaps.

	return $this->view->render($response, 'login.phtml', ['title' => 'Login']);
})->setName('login');

$app->map(['GET', 'POST'], '/register', function($request, $response, $args) {
	
	if($this->get('authenticator')->hasIdentity()) {
	    return $response->withRedirect($this->router->pathFor('home'));
	}

	$params = $request->getParsedBody();

    if($request->isPost()) {

		$user = \App\Models\User::where('email', '=', $params['email'])->first();

		// User exist
		if($user) {
			 $this->flash->addMessage("Error", 'User already exist.');
			 $params['title'] = 'Register';
			 return $this->view->render($response, 'register.phtml', $params);
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
				$this->flash->addMessage("Success", 'User added.');
				return $response->withRedirect($this->router->pathFor('login'));
		}

		exit;
    }

    return $this->view->render($response, 'register.phtml', ['title' => 'Register']);

})->setName('register');

$app->get('/profile', function($request, $response, $args) {
	return $this->view->render($response, 'home.phtml', ['title' => 'Home']);
})->setName('profile');

$app->get('/logout', function ($request, $response, $args) {
    $this->get('authenticator')->logout();
    return $response->withStatus(301)->withHeader('Location', $this->router->pathFor('login'));
});