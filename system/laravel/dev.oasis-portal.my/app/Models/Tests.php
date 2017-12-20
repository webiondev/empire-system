<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tests extends Model {

	public $timestamps = false;

	protected $table = 'tests';

	protected $fillable = ['name', 'module_id', 'startdate', 'enddate', 'duration', 'code', 'status'];

	public function getStudentTests($id) {

		\DB::setFetchMode(\PDO::FETCH_ASSOC);

		$modules = \DB::table('course_modules')->
		where('course_id', '=', $id)->
		select('module_id')->
		get(); 

		\DB::setFetchMode(\PDO::FETCH_CLASS);

		$results = Tests::join('modules', 'modules.id', '=', 'tests.module_id')->
		select('tests.id', 'modules.name as modulename', 'tests.name as test', 'modules.code')->
		whereIn('module_id', $modules)->get();

		return $results;
	}

}
