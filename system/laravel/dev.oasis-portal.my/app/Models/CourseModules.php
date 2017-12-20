<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModules extends Model {

	public $timestamps = false;

	protected $table = 'course_modules';

	protected $fillable = ['course_id', 'module_id'];

}
