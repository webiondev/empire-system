<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {

	public $timestamps = false;

	protected $table = 'chat';

	protected $fillable = ['topic', 'chat_password'];
}
