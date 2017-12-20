<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturers extends Model {

	public $timestamps = false;

	protected $table = 'lecturers';

	protected $fillable = ['user_id', 'address', 'phone'];


public function exams_supervised()
{
    return $this->belongsToMany(Examination::class, 'Examsupervision', 'lecturer_id', 
    	'exam_id');
}



}