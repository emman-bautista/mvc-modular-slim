<?php 
	
	return [
			'roles' => [],  // roles are optional
            'permissions' => [
                // from Default Module
                [ 'route' => '/default', 'role' => 'member', 'methods' => ['GET'] ],
                [ 'route' => '/default/about', 'role' => 'guest', 'methods' => ['GET'] ],
            ]
        ]
	
?>