<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model {

	public $timestamps = true;

	protected $table = 'assignments';

	protected $fillable = ['module_id', 'student_id', 'file', 'name', 'ext', 'size'];
}
