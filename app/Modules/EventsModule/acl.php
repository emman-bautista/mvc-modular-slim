<?php 
	
	return [
			'roles' => [],  // roles are optional
            'permissions' => [
                // from Default Module
                [ 'route' => '/events', 'role' => 'member', 'methods' => ['GET'] ],
                [ 'route' => '/events/invite', 'role' => 'member', 'methods' => ['GET','POST'] ],
                [ 'route' => '/events/about', 'role' => 'member', 'methods' => ['GET'] ],
            ]
        ]
	
?>