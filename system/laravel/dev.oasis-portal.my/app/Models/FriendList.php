<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendList extends Model {

	public $timestamps = false;

	protected $table = 'friend_list';

	protected $fillable = ['user_id', 'friend_id'];
}
