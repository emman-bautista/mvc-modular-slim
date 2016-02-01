<?php 
	namespace App\Controllers;
	
	class HomeController extends BaseController
	{
		
		public function home($request, $response, $args) {
			// Sample log message
		    // $this->container->logger->info("Slim-Skeleton '/' route");
		   	
		   	$user = \App\Models\User::find(1);
		   	// $this->container->logger->info($user);
		    
		    $args = array(
		    	'user' => $user,
		    	'profile' => $user->profile
		    );

		    // Render index view
		    return  $this->render($response, 'index.phtml', $args);

		}
	}
 ?>