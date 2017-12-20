<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultsFillUp extends Model {

	public $timestamps = false;

	protected $table = 'student_fillup';

	protected $fillable = ['exam_id', 'student_id', 'started_time', 'submited', 'results'];

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeFillUpExamResultsForStudent($query, $id, $exam_id)
    {
        return $query->where('exam_id', '=', $exam_id)->where('student_id', '=', $id);
    }
}