<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultsMC extends Model {

	public $timestamps = false;

	protected $table = 'student_multiplechoice';

	protected $fillable = ['exam_id', 'student_id', 'started_time', 'submited', 'results'];

	public function getStudentResults($exam_id, $id) {

		$results = ResultsMC::where('exam_id', '=', $exam_id)->where('student_id', '=', $id)->get();

		$results["current_time"] = new \DateTime();
		$results["current_time"] = $results["current_time"]->sub(new \DateInterval('PT7H'));
		$results["current_time"] = $results["current_time"]->format('Y-m-d H:i:s');

		return $results;
	}
}
