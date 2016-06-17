<?php 
	
	return [
			'roles' => [],  // roles are optional
            'permissions' => [
                // from Default Module
                [ 'route' => '/users/login', 'role' => 'guest', 'methods' => ['GET', 'POST'] ],
                [ 'route' => '/users/register', 'role' => 'guest', 'methods' => ['GET', 'POST'] ],
            ]
        ]
	
?>