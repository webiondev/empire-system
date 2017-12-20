<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturerMaterials extends Model {

	public $timestamps = false;

	protected $table = 'lecturer_materials';

	protected $fillable = ['module_id', 'file', 'category', 'name', 'ext', 'size'];
}
