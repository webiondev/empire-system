<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model {

	public $timestamps = false;

	protected $table = 'consultations';

	protected $fillable = ['student_id', 'module_id', 'lecturer_id', 'date', 'status'];

	public function getConsultationForModule($id) {

		$consultations = Consultation::join('users', 'users.id', '=', 'consultations.lecturer_id')->
		join('modules', 'modules.id', '=', 'consultations.module_id')->
		select('consultations.id', 'users.name', 'consultations.date', 'modules.name as modulename', 'modules.code')->
		where('module_id', '=', $id)->
		where('student_id', '=', null)->get();

		return $consultations;
	}

	public function getConsultationsForStudent($array) {

		$consultations = Consultation::join('modules','modules.id', '=', 'consultations.module_id')->
		join('users', 'users.id', '=', 'consultations.lecturer_id')->
		select('consultations.id', 'modules.code', 'modules.name', 'consultations.date', 'users.name as lecturer', 'consultations.status')->
		whereIn('consultations.id' , $array)->get();

		return $consultations;
	}

}
