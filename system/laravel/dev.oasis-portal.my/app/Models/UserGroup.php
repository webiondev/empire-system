<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model {

	public $timestamps = false;

	protected $table = 'usergroup';

	protected $fillable = ['name'];
}
