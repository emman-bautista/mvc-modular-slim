<?php 
	use JeremyKendall\Password\PasswordValidator;
	use JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter;
	use JeremyKendall\Slim\Auth\Exception\HttpUnauthorizedException;

	$container = $app->getContainer();

	$container['authAdapter'] = function ($c) use ($capsule){ // Use capsule from database.php
	    $pdo = $capsule->getConnection()->getPDO();

		$adapter = new PdoAdapter(
		    $pdo, 
		    "users", 
		    "email", 
		    "password", 
		    new PasswordValidator()
		);

	    return $adapter;
	};
	
	$acl = $container['settings']['acl'];
	$container['acl'] = function ($c) use($acl){
	    return new \App\Utilities\Acl($acl);
	};

	$container->register(new \JeremyKendall\Slim\Auth\ServiceProvider\SlimAuthProvider());

	$app->add($container->get('slimAuthRedirectMiddleware'));

	
 ?>