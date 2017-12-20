<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EssayQuestions extends Model {

	public $timestamps = false;

	protected $table = 'essay';

	protected $fillable = ['exam_id', 'question', 'mark'];
}
