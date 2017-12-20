<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FillUpQuestions extends Model {

	public $timestamps = false;

	protected $table = 'fillup';

	protected $fillable = ['exam_id', 'question', 'mark'];
}
