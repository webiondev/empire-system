<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model {

	public $timestamps = false;

	protected $table = 'examination';

	protected $fillable = ['name', 'module_id', 'startdate', 'enddate', 'duration', 'type', 'code', 'status'];



public function supervisors($id)
{
    return $this->belongsToMany(Lecturers::class, 'Examsupervision', 'exam_id', $id);
}

}