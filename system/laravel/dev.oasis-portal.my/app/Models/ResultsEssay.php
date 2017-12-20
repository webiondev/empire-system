<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultsEssay extends Model {

	public $timestamps = false;

	protected $table = 'student_essay';

	protected $fillable = ['exam_id', 'student_id', 'started_time', 'submited', 'results'];

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeEssayExamResultsForStudent($query, $id, $exam_id)
    {
        return $query->where('exam_id', '=', $exam_id)->where('student_id', '=', $id);
    }
}