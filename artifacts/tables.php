<?php 

use Illuminate\Database\Capsule\Manager as Capsule;

$logger = $app->getContainer()->logger;
$schema = Capsule::schema();

$user = null;
$user_profile = null;

/**
 * Users table
 */
if(!$schema->hasTable('users')){

	$schema->create('users', function($table)
	{
	    $table->increments('id');
	   	$table->string('email')->unique();
	    $table->char('password', 128);
		$table->char('role','16');
	    $table->timestamps();
	    $table->softDeletes();
	});

	$user = new App\Models\User;

	//Insert Record
	$user->email = 'john.doe@gmail.com';
	$user->password = password_hash('123456', PASSWORD_DEFAULT);
	$user->role = 'admin';
	$user->save();

}

if(!$schema->hasTable('user_profile')){
	$schema->create('user_profile', function($table){
		$table->increments('id');
		$table->integer('user_id');
		$table->char('first_name', 128);
		$table->char('last_name', 128);
		$table->integer('age');
		$table->date('birthday');
		$table->char('phone', 24);
		$table->char('address1', 128);
		$table->char('address2', 128);
		$table->char('country', 64);
		$table->char('zipcode', 6);
		$table->timestamps();
		$table->softDeletes();
	});


	$user_profile = new App\Models\UserProfile;
	$user_profile->first_name = "John";
	$user_profile->last_name = "Doe";
	$user_profile->age = 36;
	$user_profile->birthday = 'March 26, 1979';
	$user_profile->user_id = $user->id;
	$user_profile->save();

}

