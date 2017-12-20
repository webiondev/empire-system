<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsergroupSchedule extends Model {

	public $timestamps = true;

	protected $table = 'usergroup_schedule';

	protected $fillable = ['usergroup_id', 'template_id'];
}
