<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teach extends Model {

	public $timestamps = false;

	protected $table = 'teaches';

	protected $fillable = ['student_id', 'lecturer_id'];
}
