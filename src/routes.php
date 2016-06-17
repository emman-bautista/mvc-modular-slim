<?php

$app->get('/', function($request, $response, $args) {
	$this->view->render($response, 'home.phtml', ['title' => 'Home']);
})->setName('home');

$app->get('/create_data', function($request, $response, $args) {
	$data = new App\Models\Data('Content', ['title'=>'TEST', 'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore laudantium architecto quo maxime perferendis quidem fuga sed corporis eaque distinctio.']);
	$data->save();
	
})->setName('create_data');

$app->map(['GET', 'POST'], '/login', "\App\Controllers\UserController:login")->setName('login')->add($app->getContainer()->get('loginValidation'));

$app->map(['GET', 'POST'], '/register', "\App\Controllers\UserController:register")->setName('register')->add($app->getContainer()->get('registerValidation'));

$app->get('/profile', "\App\Controllers\UserController:profile")->setName('profile');

$app->get('/logout', "\App\Controllers\UserController:logout")->setName('logout');