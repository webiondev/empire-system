<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model {

	public $timestamps = false;

	protected $table = 'assessment';

	protected $fillable = ['student_id', 'module_id', 'credit_points', 'mark', 'grade'];

}
