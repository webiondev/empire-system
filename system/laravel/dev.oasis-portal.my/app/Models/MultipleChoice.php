<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model {

	public $timestamps = false;

	protected $table = 'multiplechoice';

	protected $fillable = ['exam_id', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'correct_answer', 'mark'];

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeQuestionsForExam($query, $id)
    {
        return $query->select('exam_id', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'mark')->
		where('exam_id', '=', $id);
    }
}
