<?php

namespace App\Modules\EventsModule\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	protected $table = "event_sessions";

	function getEvent() {

		return $this->belongsTo('App\Modules\EventsModule\Models\Event');
	}
}