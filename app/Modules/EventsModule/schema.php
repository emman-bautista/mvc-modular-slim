<?php 

use Illuminate\Database\Capsule\Manager as Capsule;

$logger = $this->app->getContainer()->logger;
$schema = Capsule::schema();
$user = null;
$user_profile = null;
$logger->info('Running Event module Schema.');

/**
 * Event module tables
 */

// Event Invites schema builder
if(!$schema->hasTable('event_invites')){

	$schema->create('event_invites', function($table)
	{
	    $table->increments('id');
	   	$table->string('email')->unique();
	    $table->dateTime('date_invited');
		$table->dateTime('date_accepted');
		$table->integer('accepted');
	    $table->timestamps();
	    $table->softDeletes();
	});
	$logger->info('event_invites schema created.');

}else{
	$logger->info('event_invites schema already exist.');
}

// Event Sessions schema builder
if(!$schema->hasTable('event_sessions')){

	$schema->create('event_sessions', function($table)
	{
	    $table->increments('id');
	   	$table->char('title', 128);
	    $table->string('description');
		$table->date('date');
		$table->time('start');
		$table->time('end');
		$table->char('venue', 128);
		$table->char('country', 64)->nullable();
		$table->integer('event_id');
		$table->integet('trainer_id');
	    $table->timestamps();
	    $table->softDeletes();
	});
	$logger->info('event_sessions schema created.');
}else{
	$logger->info('events schema already exist.');
}

// Events schema builder
if(!$schema->hasTable('events')){

	$schema->create('events', function($table)
	{
	    $table->increments('id');
	   	$table->char('title', 128)->unique();
	    $table->string('description');
		$table->date('date_start');
		$table->date('date_end');
		$table->char('venue', 128);
		$table->char('country', 64)->nullable();
		$table->integer('owner');
	    $table->timestamps();
	    $table->softDeletes();
	});
	$logger->info('events schema created.');
}else{
	$logger->info('events schema already exist.');
}

// Event Organizers schema builder
if(!$schema->hasTable('event_organizers')){

	$schema->create('event_organizers', function($table)
	{
	    $table->increments('id');
	   	$table->integer('event_id');
	    $table->integer('user_id');
	    $table->boolean('leader');
	    $table->timestamps();
	    $table->softDeletes();
	});	
	$logger->info('event_organizers schema created.');
}else{
	$logger->info('events schema already exist.');
}



