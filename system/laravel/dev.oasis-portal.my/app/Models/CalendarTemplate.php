<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarTemplate extends Model {

	public $timestamps = false;

	protected $table = 'calendar_template';

	protected $fillable = ['name'];
}
