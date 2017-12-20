<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examsupervision extends Model {

	public $timestamps = false;

	protected $table = 'exam_supervision';

	protected $fillable = ['lecturer_id', 'exam_id'];


public function lecturers()
{
    return $this->hasMany('App\Lecturers');
}
public function examinations(){
   return $this->hasMany('App\Examination');
}

}