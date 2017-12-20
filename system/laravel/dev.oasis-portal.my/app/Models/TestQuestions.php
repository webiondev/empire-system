<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestions extends Model {

	public $timestamps = false;

	protected $table = 'test_questions';

	protected $fillable = ['test_id', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'correct_answer', 'mark'];

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeQuestionsForTest($query, $id)
    {
        return $query->select('test_id', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'mark')->
		where('test_id', '=', $id);
    }
}
