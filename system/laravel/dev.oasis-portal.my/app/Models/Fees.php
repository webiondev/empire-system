<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model {

	public $timestamps = false;

	protected $table = 'fees';

	protected $fillable = ['user_id', 'description', 'duedate', 'amount_payable', 'total_collected', 'outstanding', 'fine'];

}
