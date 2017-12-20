<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationBookings extends Model {

	public $timestamps = false;

	protected $table = 'consultation_bookings';

	protected $fillable = ['consultation_id', 'user_id', 'reason', 'type'];

	public function getUserConsultationBookings($id) {

		$array = [];

		$consultation_bookings = ConsultationBookings::where('user_id', $id)->
		select('consultation_id')->get();

		foreach ($consultation_bookings as $key => $value) {
			$array[] = $value["consultation_id"];
		}

		return $array;
	}
}