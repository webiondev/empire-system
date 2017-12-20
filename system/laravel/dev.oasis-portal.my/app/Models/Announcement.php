<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {

	public $timestamps = false;

	protected $table = 'announcements';

	protected $fillable = ['datetime', 'type', 'value', 'submitted_by', 'user_group'];

	public function getStudentAnnouncements($id) {

		$ids=[];	
		$groups = UsersGroups::where('user_id', '=', $id)->
        select('group_id')->get();

        $ids = array();
        foreach ($groups as $key => $value) {
            $ids[] = $value["group_id"];
        }

        $results = \DB::table('announcements')->whereIn('user_group', $ids)->orWhere('user_group', '=', 0)->take(6)->
		orderBy('datetime', 'DESC')->get();

		return $results;
		
	}
}
