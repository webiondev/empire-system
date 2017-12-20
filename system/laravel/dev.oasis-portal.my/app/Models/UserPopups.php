<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPopups extends Model {

	public $timestamps = true;

	protected $table = 'user_popups';

	protected $fillable = ['user_id', 'title', 'body', 'read'];
}
