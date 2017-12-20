<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model {

	public $timestamps = true;

	protected $table = 'message';

	protected $fillable = ['text', 'chat_id', 'user_id'];
}
