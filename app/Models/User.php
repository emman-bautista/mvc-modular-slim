<?php 
	namespace App\Models;

	class User extends \Illuminate\Database\Eloquent\Model {
		protected $table = 'users';
		

		function profile() {
			return $this->hasOne(UserProfile::class);
		}

		
		public static function boot()
	    {
	        parent::boot();

	        // Do the event listener here
	        $callbacks = [
				'saved' => function($user){
					$app = \App\Container\AppContainer::getInstance();
		           	$logger = $app->getContainer()->logger;
		   			$logger->info('user saved event FIRED!');
		   			$logger->info($user);
			    },
			    'updated' => function($user) {
			    	$app = \App\Container\AppContainer::getInstance();
		           	$logger = $app->getContainer()->logger;
		   			$logger->info('user updated event FIRED!');
		   			$logger->info($user);
			    } //add more below if needed
			];

			foreach ($callbacks as $key => $value) {
				User::$key($value);
			}
	        
	    }

	    
	}

