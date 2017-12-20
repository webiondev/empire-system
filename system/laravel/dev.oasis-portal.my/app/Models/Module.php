<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

	public $timestamps = false;

	protected $table = 'modules';

	protected $fillable = ['code', 'semester', 'name', 'description', 'lecturer_id'];


	

	public function getStudentModules($id) {

		$student = Students::where('user_id', $id)->get();

		\DB::setFetchMode(\PDO::FETCH_ASSOC);

		$modules = \DB::table('course_modules')->
		where('course_id', '=', $student[0]->course_id)->
		select('module_id')->
		get();

		\DB::setFetchMode(\PDO::FETCH_CLASS);

		$results =   Module::join('users', 'modules.lecturer_id', '=', 'users.id')->
		select('users.email', 'modules.id', 'modules.lecturer_id', 'modules.name', 'modules.code')->
		where('modules.semester', '=', $student[0]->semester)->
		whereIn('modules.id', $modules)->get();

		return $results;
	}

	public function getCourseModules($id, $student_id) {

		\DB::setFetchMode(\PDO::FETCH_ASSOC);

		$modules = \DB::table('course_modules')->
		where('course_id', $id)->
		select('module_id')->
		get(); 

		\DB::setFetchMode(\PDO::FETCH_CLASS);

		$results = Module::whereIn('modules.id', $modules)->
		leftJoin('assessment', 'modules.id', '=', 'assessment.module_id')->
		
		where('assessment.student_id', $student_id)->
		//orWhere('assessment.student_id', null)->

		get();

		return $results;
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }


}
