<?php 

use Illuminate\Database\Capsule\Manager as Capsule;

$logger = $this->app->getContainer()->logger;
$schema = Capsule::schema();

// CMS schema builder (Sample schema)
/*if(!$schema->hasTable('cms')){

	$schema->create('cms', function($table)
	{
	    $table->increments('id');
	   	$table->string('title')->unique();
	   	$table->string('description');
	    $table->timestamps();
	    $table->softDeletes();
	});
	$logger->info('cms schema created.');

}else{
	$logger->info('cms schema already exist.');
}*/