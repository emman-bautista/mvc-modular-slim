<?php 
	namespace App\Models;

	class User extends \Illuminate\Database\Eloquent\Model {
		protected $table = 'users';

		function profile() {
			return $this->hasOne(UserProfile::class);
		}

	}