<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResults extends Model {

	public $timestamps = false;

	protected $table = 'test_results';

	protected $fillable = ['test_id', 'student_id', 'started_time', 'submited', 'results'];

	public function getMyTestResults($test_id, $id) {

		$results = TestResults::where('test_id', '=', $test_id)->where('student_id', '=', $id)->get();

		$results["current_time"] = new \DateTime();
		$results["current_time"] = $results["current_time"]->sub(new \DateInterval('PT7H'));
		$results["current_time"] = $results["current_time"]->format('Y-m-d H:i:s');

		return $results;
	}
}
