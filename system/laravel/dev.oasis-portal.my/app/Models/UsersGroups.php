<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGroups extends Model {

	public $timestamps = false;

	protected $table = 'usersgroups';

	protected $fillable = ['user_id', 'group_id'];

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeGetGroups($query, $id)
    {
        return $query->where('user_id', '=', $id);
    }
}
