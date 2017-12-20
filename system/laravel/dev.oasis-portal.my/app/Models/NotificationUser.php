<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model {

	public $timestamps = false;

	protected $table = 'notification_user';

	protected $fillable = ['user_id', 'notification_id'];
}
