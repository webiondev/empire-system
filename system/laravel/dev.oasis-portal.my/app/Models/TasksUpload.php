<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksUpload extends Model {

	public $timestamps = false;

	protected $table = 'tasks_upload';

	protected $fillable = ['task_id', 'datetime', 'user_id', 'file'];

}
