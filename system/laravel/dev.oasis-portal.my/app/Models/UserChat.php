<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model {

	public $timestamps = false;

	protected $table = 'user_chat';

	protected $fillable = ['chat_id', 'user_id'];
}
