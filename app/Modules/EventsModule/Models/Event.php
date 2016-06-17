<?php

namespace App\Modules\EventsModule\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\EventsModule\Models\Session;
use App\Modules\EventsModule\Models\Organizer;
class Event extends Model
{
	protected $table = "events";

	function addSession(Session $session) {
		$session->event_id = $this->id;
		$session->save();

		return $session;
	}

	function sessions() {
		return $this->hasMany(Session::class);
	}

	function addOrganizer($user, $leader = false) {
		
		if(!$this->organizerExistsByUserId($user['id'])) {
			$organizer = new Organizer;
			$organizer->user_id = $user['id'];
			$organizer->event_id = $this->id;
			$organizer->leader = $leader;

			$organizer->save();

			return $organizer;
		}
		
		return false;
	}

	function organizers() {
		return $this->hasMany(Organizer::class);
	}


	function organizerExistsByUserId($user_id) {
		$organizer = $this->organizers->where('user_id', $user_id)->all();
		if($organizer) return true; 
		
		return false;
		
	}
}