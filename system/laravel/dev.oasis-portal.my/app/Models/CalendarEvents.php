<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvents extends Model {

	public $timestamps = true;

	protected $table = 'calendar_events';

	protected $fillable = ['calendar_id', 'title', 'start', 'end', 'allDay', 'backgroundColor'];
}
