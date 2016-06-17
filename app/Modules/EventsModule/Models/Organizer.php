<?php

namespace App\Modules\EventsModule\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Organizer extends Model
{
	protected $table = "event_organizers";


	function user() {
		return $this->belongsTo(User::class);
	}
}