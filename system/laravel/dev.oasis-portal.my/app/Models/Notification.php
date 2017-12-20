<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

	public $timestamps = true;

	protected $table = 'notification';

	protected $fillable = ['text', 'course_id', 'group_id', 'user_id', 'n_class', 'n_icon'];

	public function loadStudentCourseNotifications($id) {

		$course = Students::getCourseId($id)->first();
		$notifications = Notification::forCourse($course["course_id"])->get();

		return $notifications;
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeForCourse($query, $course_id)
    {
        return $query->where('course_id', $course_id)->orderBy('id', 'DESC')->limit(6);
    }
}
