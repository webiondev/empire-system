<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model {

	public $timestamps = true;

	protected $table = 'tasks';

	

	protected $fillable = ['title', 'description', 'duedate', 'lecturer_id', 'file', 'group_id'];
	//['title', 'description', 'duedate', 'lecturer_id', 'file', 'group_id', 'created_at', 
	//'updated_at'];
	public function getStudentTasks($id) {

		$group_ids=[];

		$groups = UsersGroups::getGroups($id)->get();

		foreach ($groups as $key => $value) {
			$group_ids[] = $value["group_id"];
		}

		$tasks = Tasks::forGroups($group_ids)->get();

		return $tasks;
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeforGroups($query, $group_ids)
    {
        return $query->whereIn('group_id', $group_ids);
    }

}
