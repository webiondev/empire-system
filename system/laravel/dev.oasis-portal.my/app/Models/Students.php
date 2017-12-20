<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model {

	public $timestamps = false;

	protected $table = 'students';

	protected $fillable = ['user_id', 'course_id', 'semester', 'address', 'phone'];

	public function getStudentCourse($id) {

		$course = Students::join('courses', 'courses.id', '=', 'students.course_id')->where('user_id', '=', $id)->select('course_id', 'name')->first();
		
		return $course;
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeGetCourseId($query, $user_id)
    {
        return $query->where('user_id', $user_id)->
		select('course_id');
    }
}
