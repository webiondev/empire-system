<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMaterials extends Model {

	public $timestamps = false;

	protected $table = 'module_materials';




	protected $fillable = ['module_id', 'name', 'file', 'category',  'ext', 'size'];   //['module_id', 'file', 'category', 'name', 'ext', 'size'];

	/*
	|--------------------------------------------------------------------------
	| SCOPE SECTION
	|--------------------------------------------------------------------------
	*/

	public function scopeForModule($query, $id)
    {
        return $query->where('module_id', $id);
    }

}
