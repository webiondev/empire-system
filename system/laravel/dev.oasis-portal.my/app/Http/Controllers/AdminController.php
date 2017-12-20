<?php namespace App\Http\Controllers;

use Closure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\Module as Module;
use App\Models\Course as Course;
use App\Models\CourseModules as CourseModules;
use App\Models\Students as Students;
use App\Models\Fees as Fees;
use App\Models\Assessment as Assessment;
use App\Models\Consultation as Consultation;
use App\Models\ModuleMaterials as ModuleMaterials;
use App\Models\Examination as Examination;
use App\Models\MultipleChoice as MultipleChoice;
use App\Models\ResultsMC as ResultsMC;
use App\Models\Tests as Tests;
use App\Models\TestQuestions as TestQuestions;
use App\Models\TestResults as TestResults;
use App\Models\Assignment as Assignment;
use App\Models\Lecturers as Lecturers;
use App\Models\FillUpQuestions as FillUpQuestions;
use App\Models\ResultsFillUp as ResultsFillUp;
use App\Models\EssayQuestions as EssayQuestions;
use App\Models\ResultsEssay as ResultsEssay;
use App\Models\Announcement as Announcement;
use App\Models\UserGroup as UserGroup;
use App\Models\UsersGroups as UsersGroups;
use App\Models\LecturerMaterials as LecturerMaterials;
use App\Models\Tasks as Tasks;
use App\Models\TasksUpload as TasksUpload;
use App\Models\CalendarTemplate as CalendarTemplate;
use App\Models\CalendarEvents as CalendarEvents;
use App\Models\UsergroupSchedule as UsergroupSchedule;
use App\Models\UserPopups as UserPopups;


use Validator;
use Input;
use Redirect;
use Auth;
use Hash;
use Request;

class AdminController extends Controller {

  public function courseRegister()
  {
    $data = Input::all();

    $validator = Validator::make($data, [

      'name' => 'required|min:4|max:255',
      'description' => 'max:255',

    ]);

    if($validator->passes())
    {

      $course = new Course;
      $course->fill($data);

      if($course->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $course->errors()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->errors()->all()));
    }
  }

 public function courseDelete()
  {
    $data = Input::all();

    $course = Course::where('name', '=', $data["id"])->first();
    $enroll= Students::where('course_id', '=', $course->id)->get();
   
      if (!($enroll->isEmpty()))

           return json_encode(array('success' => false, 'errors' => "Please remove enrolled students first."));


    if($course->delete() ) {

     //Course::find($data["id"])->delete();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => "Unable to remove course."), $course->error_log());
    }
  }

  public function updateCourses()
  {
    $data = Input::all();

    $validator = Validator::make($data,[
      'course_id' => 'required',
      'course_name' => 'required|min:4|max:255',
      'course_description' => 'max:255'
    ]);

    if($validator->passes()){
      //update table
      DB::table('courses')->where('id','=',$data['course_id'])->update(['name'=>$data['course_name'],'description' => $data['course_description']]);
      return json_encode(array('success' => true));
    }else{
      return json_encode(array('success' => false));
    }  
  }

  public function createPopUpNotification()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'user_id' => 'required',
      'title' => 'min:4|required',
      'body' => 'required'
    ]);

    if($validator->passes())
    {

      $record = new UserPopups;
      $record->fill($data);

      if($record->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $module->errors()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->errors()->all()));
    }

    return json_encode(array('success' => false, 'data' => $data));
  }

  public function lockUserById()
  {
    
    $data = Input::all();

    $user = User::where('id', '=', $data["user_id"])->first();//->update((array('status'=>'lock')));
    
    // $lock= $User->update();
   
          if (User::where('id', '=', $data["user_id"])->where('status', 'lock')->first()){

             User::where('id', '=', $data["user_id"])->update((array('status'=>'unlock')));
              return json_encode(array('success' => true, 'stat'=>'unlock'));
           }
          else if(User::where('id', '=', $data["user_id"])->where('status', 'unlock')->orWhere('status', null) ->first()){
           
              User::where('id', '=', $data["user_id"])->update((array('status'=>'lock')));
               return json_encode(array('success' => true, 'stat'=>'lock'));

           }

    return json_encode(array('success' => false));
  }



  public function moduleRegister()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'lecturer_id' => 'required',
      'code' => 'min:4|required',
      'semester' => 'required',
      'name' => 'required|min:4|max:255',
      'description' => 'max:255',
    ]);

    if($validator->passes())
    {

      $module = new Module;
      $module->fill($data);

      if($module->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $module->errors()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->errors()->all()));
    }
  }

public function moduleUpdate()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'lecturer_id' => 'required',
      'code' => 'min:4|required',
      'semester' => 'required',
      'name' => 'required|min:4|max:255',
      'description' => 'max:255',
    ]);

    if($validator->passes())
    {
      $module = Module::find($data["id"]);
      $module->fill($data);

      if($module->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $module->errors()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->errors()->all()));
    }
  }

 public function moduleUpdateInstructional()
{

  $data = Input::all();

  $validator = Validator::make($data,[
    'lecturerTimes' => 'numeric',
    'projectTimes' => 'numeric',
    'privateStudy' => 'numeric',
    'creditValue' => 'numeric'
  ]);

  if($validator->passes()){

      $modules = Module::find($data['id']);
      $modules->lecturer_times = $data['lecturerTimes'];
      $modules->project_times = $data['projectTimes'];
      $modules->private_study_time = $data['privateStudy'];
      $modules->credit_value = $data['creditValue'];
      $modules->save();

    return json_encode(array('success' => true,'_data' => $data));
  }else{
    return json_encode(array('success' => false));
  }

}


public function moduleUpdateSynoObj()
{
  $data = Input::all();

  $validator = Validator::make($data,[
    'synopsis' => 'required|min:4',
    'objectives' => 'required|min:4'
  ]);

  if($validator->passes()){

    $modules = Module::find($data['id']);
    $modules->synopsis = $data['synopsis'];
    $modules->objectives = $data['objectives'];
    $modules->save();

    return json_encode(array('success' => true));
  }else{
    return json_encode(array('success' => false));
  }
}

public function updateLearningOutcome()
{
    $data = Input::all();

    $validator = Validator::make($data,[
      'learning_outcome' => 'required|min:4'
    ]);

    if ($validator->passes()) {
     
      $modules = Module::find($data['id']);
      $modules->outcomes = $data['learning_outcome'];
      $modules->save();

      return json_encode(array('success' => true));
    }else{
      return json_encode(array('success' => false));
    }
}

public function getLearningOutcomes($moduleId)
{
  $data = DB::table('outcomes')
          ->select('id','module_id','outcome','assessment','indicative')
          ->where('module_id',$moduleId)
          ->get();

  return json_encode(array('success' => true,'_data' => $data));
}

public function getAssessmentComponent($moduleId)
{
  $data = DB::table('assessment_modules')
          ->select('id','module_id','component','weightage','due_date')
          ->where('module_id',$moduleId)
          ->get();
  return json_encode(array('success' => true,'_data' => $data));
}

public function updateTableAssessment()
{
  $data = Input::all();

  $validator = Validator::make($data,[
    'component' => 'required',
    'weightage' => 'required',
    'dueDate' => 'required'
  ]);

  if($validator->passes()){

    DB::table('assessment_modules')
        ->insert(['module_id'=>$data['module_id'],'component' => $data['component'],'weightage' => $data['weightage'],'due_date' => $data['dueDate']]);

    return json_encode(array('success' => true));
  }else{

    return json_encode(array('success' => false));
  }
}


public function updateTableOutcome()
{
  $data = Input::all();

  $validator = Validator::make($data,[
    'module_id' => 'required',
    'assessment_criteria' => 'required|min:4',
    'learning_outcome' => 'required|min:4'
  ]);

  if($validator->passes()){

    //insert into the database
    DB::table('outcomes')
        ->insert(['module_id' => $data['module_id'],'outcome' => $data['learning_outcome'],'assessment' => $data['assessment_criteria'],'indicative' => $data['indicative_content']]);
    return json_encode(array('success' => true));
  }else{
    return json_encode(array('success' => false));
  }

}

public function updateTeachingStrategies()
{
    $data = Input::all();

    $validator = Validator::make($data,[
      'teachingStrategy' => 'required|min:4'
    ]);

    if($validator->passes()){

      $modules = Module::find($data['id']);
      $modules->teaching_strategies = $data['teachingStrategy'];
      $modules->save();
      return json_encode(array('success' => true));
    }else{

      return json_encode(array('success' => false));
    } 
}

 public function moduleDelete(){

    $data = Input::all();

    $module = Module::where('code', '=', $data["id"])->first();
    //$lecturer=Lecturers::where('user_id', '=', $module->lecturer_id)->get();
   
      // if (!($lecturer->isEmpty()))

      //      return json_encode(array('success' => false, 'errors' => "Please remove lecturer assigned first."));

    
    if($module->delete()) {

     //Course::find($data["id"])->delete();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => "Unable to remove module."), $module->error_log());
    }
  }


  public function removeModuleFromCourse()
  {
    $data = Input::all();
    $validator = Validator::make($data,[
      'course_id' => 'required'
    ]);

    if ($validator->passes()) {
      
      foreach ($data['module_id'] as $moduleID) {
        DB::table('course_modules')->where('course_id','=',$data['course_id'])->where('module_id','=',$moduleID)->delete();
      }

      return json_encode(array('success' => true));
    }else{
      return json_encode(array('success' => false,'errors'=>$validator->errors()->all()));
    }
  }

  public function getCourses()
  {
    $courses = Course::all();

    return json_encode($courses);
  }

  public function getLecturers()
  {
    $lecturers = User::where('type', '=', 'Lecturer')->select('id','name','type')->get();

    return json_encode($lecturers);
  }

  public function getModules()
  {
    $modules = Module::join('users', 'users.id', '=', 'modules.lecturer_id')->
    select('modules.code', 'modules.name', 'modules.id', 'users.name as lecturer', 'modules.description')->
    get();

    return json_encode($modules);
  }

  public function getCourseDetails($id)
  {
    $course = Course::find($id);

    return json_encode($course);
  }

  public function getCourseModules($id)
  {
    $modules = CourseModules::join('modules', 'modules.id', '=', 'course_modules.module_id')->
    select('modules.id','modules.name','modules.code')->
    where('course_id', '=', $id)->
    get();

    return json_encode($modules);
  }

  public function getEnrollStudent($id)
  {
    $students = DB::table('users')
                    ->select('users.id','users.name','users.email')
                    ->leftJoin('students','users.id','=','students.user_id')
                    ->where('students.course_id','=',$id)
                    ->get();

    return json_encode($students);
  }

  public function removeStudentFromCourses($courseid,$userid)
  {


    DB::table('students')
        ->where('course_id','=',$courseid)
        ->where('user_id','=',$userid)
        ->delete();
    return json_encode(array('success' => true));
  }
  public function courseModuleAssign()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'module_id' => 'required',
      'course_id' => 'required'
    ]);

    if($validator->passes())
    {

      $existingModules = CourseModules::where('course_id','=', $data['course_id'])->
      where('module_id','=', $data['module_id'])->get();

      $existingModules = count($existingModules);

      if(!$existingModules) {

        $module = new CourseModules;
        $module->fill($data);
        $module->save();

        return json_encode(array('success' => true, 'existing' => $existingModules));

      } else {

        return json_encode(array('success' => false, 'existing' => $existingModules, 'errors' => $module->errors()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->errors()->all()));
    }
  }

  public function Authenticate()
  {
    return json_encode(array('user'=>  \Auth::user(), 'id' => \Auth::user()->id, 'type' => \Auth::user()->type));
  }

  public function Logout()
  {
    Auth::logout();
    return redirect('/logout');
    return json_encode(array('success' => true));
  }

  public function authStore()
  {
    return json_encode(array('user'=>  \Auth::user(), 'id' => \Auth::user()->id, 'type' => \Auth::user()->type));
  }

  public function admin_browse_students()
  {
    $users = User::join('students', 'users.id', '=', 'students.user_id')->
    leftJoin('courses', 'students.course_id', '=', 'courses.id')->
    select('users.id', 'users.name', 'users.type', 'courses.name as coursename', 'users.status')->
    where('type', '=', 'Student')->
    get();

      return json_encode($users);
  }

  public function register_student()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6',
      'semester' => 'required',
      'course_id' => 'required'
    ]);

    if ($validator->passes()) {

      $userArray =[
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'type' => 'Student',
      ];

      $user = new User;
      $user->fill($userArray);

      if($user->save()) {

        $info = array('user_id' => $user->id,
        'course_id' => $data["course_id"],
        'semester' => $data["semester"]);

        $personalinfo = new Students;
        $personalinfo->fill($info);
        $personalinfo->save();

        return json_encode(array('success' => true, 'user_id' => $user->id));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function register_lecturer()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6',
    ]);

    if ($validator->passes()) {

      $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
      'type' => 'Lecturer',
      ]);

      $info = array('user_id' => $user->id);

      $personalinfo = new Lecturers;
      $personalinfo->fill($info);
      $personalinfo->save();

      return json_encode(array('success' => true, 'user_id' => $user->id));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function admin_browse_lecturers()
  {
    $users = User::select('users.id', 'users.name', 'users.status')->
    where('type', '=', 'Lecturer')->get();

      return json_encode($users);
  }

  public function studentUpdateDetails()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'user_id' => 'required',
      'course_id' => 'required',
      'semester' => 'required',
      'address' => 'required|max:255|',
      'phone' => 'required|min:3',
    ]);

    if ($validator->passes()) {

      $personalinfo = Students::where('user_id', $data['user_id']);
      $personalinfo->update($data);

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getStudentDetails($id)
  {
    $personalinfo = Students::where('user_id', '=', $id)->get();

    return json_encode($personalinfo);
  }

  public function getStudentFees($id)
  {
    $feedetails = Fees::select('id', 'user_id', 'description', 'duedate', 'amount_payable', 'total_collected', 'outstanding', 'fine')->
    where('user_id','=', $id)->get();

    return json_encode($feedetails);
  }

  public function postStudentFees()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'user_id' => 'required',
      'description' => 'required|max:300',
      'duedate' => 'required',
      'amount_payable' => 'required|min:2',
      'total_collected' => 'required|min:2',
      'outstanding' => 'required',
    ]);

    if ($validator->passes()) {

      $feedetails = new Fees;
      $feedetails->fill($data);
      $feedetails->save();

      return json_encode(array('success' => true, 'id' => $feedetails["id"]));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerUpdateDetails()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'user_id' => 'required',
      'address' => 'required|max:255|',
      'phone' => 'required|min:3',
    ]);

    if ($validator->passes()) {

      $personalinfo = Lecturers::where('user_id', '=', $data['user_id'])->first();

      if(!is_null($personalinfo)) {

        $personalinfo->update($data);

      } else {

        $personalinfo = new Lecturers;
        $personalinfo->fill($data);
        $personalinfo->save();
      }

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerUpdateInfo()
  {
    $data = Input::all();
    
    $validator = Validator::make($data,[
      'user_name' => 'required',
      'user_email' => 'required|email',
      'user_password' => 'required|confirmed',
      'user_password_confirmation' => 'required',
    ]);

    if($validator->passes()){
      
      DB::table('users')
          ->where('id',$data['user_id'])
          ->update(['name'=>$data['user_name'],'email' => $data['user_email'],'password' => Hash::make($data['user_password'])]);

      Db::table('lecturers')
          ->where('id',$data['address_id'])
          ->update(['address'=>$data['user_address'],'phone'=>$data['user_phone_no']]);

      return json_encode(array('success' =>true));
    }else{

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
    
  }

  public function getLecturerDetails($id)
  {
    $personalinfo = Lecturers::where('user_id', $id)->get()->toArray();
    $user = DB::table('users')->select('name','email','type')->where('id',$id)->get();

    array_push($personalinfo, $user);

    return json_encode($personalinfo);
  }

  public function feeDetailsDestroy()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      if(Fees::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }


  public function studentDelete()
  {
    $data = Input::all();

    $student = Students::where('user_id', '=', $data["user_id"]);

    if($student->delete()) {

      User::find($data["user_id"])->delete();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => "Unable to remove student."));
    }
  }

  public function createUserGroup()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'name' => 'required|min:4',
    ]);

    if ($validator->passes()) {

      $usergroup = new UserGroup;
      $usergroup->fill($data);
      $usergroup->save();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getGroupName($groupId)
  {
    $data = DB::table('usergroup')
            ->select('name')
            ->where('id',$groupId)
            ->first();

    return json_encode(array('success'=>true,'groupName' =>$data));
  }

  public function editGroupName()
  {
    $data = Input::all();
    DB::table('usergroup')
        ->where('id',$data['group_id'])
        ->update(['name' => $data['group_name']]);

    return json_encode(array('success'=>true));
  }
  public function getAllUserGroups()
  {
    $usergroups = UserGroup::all();

    return json_encode($usergroups);
  }

  public function getSystemModules()
  {
    $modules = Module::join('users', 'users.id', '=', 'modules.lecturer_id')->
    select('modules.id', 'modules.code', 'modules.name', 'modules.description', 'users.name as lecturer')->get();

    return json_encode($modules);
  }

  public function adminGetFiles($id)
  {
    $results = Module::join('lecturer_materials', 'lecturer_materials.module_id', '=', 'modules.id')->
    select('modules.id', 'modules.name', 'lecturer_materials.id as item_id', 'lecturer_materials.name as filename', 'lecturer_materials.file', 'lecturer_materials.category')->
    where('module_id', '=', $id)->orderBy('category', 'ASC')->get();

    return json_encode($results);
  }

  public function adminUploadMaterials()
  {
    $filename = Input::get('filename');
    $name = Input::get('name');
    $ext = Input::get('ext');
    $module_id = Input::get('module_id');
    $category = Input::get('category');

    $file = $name.'.'.$ext; //str_random(12);
    $path = str_replace("/laravel","",base_path()).'/files/lecturer/'.$module_id.'/'.$filename;

    $data = Request::get('file');

    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);

    $data = base64_decode($data);

    if (!is_dir(str_replace("/laravel","",base_path()).'/files/lecturer/'.$module_id)) {

      mkdir(str_replace("/laravel","",base_path())."/files/lecturer/".$module_id);
    }

    //Write to File
    $check = file_put_contents($path, $data);
    $fileinformation = array('size'=> strlen($data), 'ext' => $ext, 'name' => $name, 'file' => $file, 'module_id' => $module_id, 'category' => $category);

    if($check) {

      $record = new LecturerMaterials;
      $record->fill($fileinformation);

      if($record->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false));
    }
  }

  public function lecturerMaterialsDestroy()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      $file = LecturerMaterials::find($data["id"]);
      $path = str_replace("/laravel","",base_path()).'/files/lecturer/'.$file["module_id"].'/'.$file["file"];

      unlink($path);

      if(LecturerMaterials::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getAllStudents()
  {
    $students = User::where('type', '=', 'Student')->get();

    return json_encode($students);
  }

  public function assignUserGroup()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'user_id' => 'required',
      'group_id' => 'required',
    ]);

    if ($validator->passes()) {


      $group = UsersGroups::where('user_id', '=', $data['user_id'])->where('group_id','=', $data['group_id'])->first();

      if(!is_null($group)) {

        return json_encode(array('success' => false, 'errors' => "The user already assigned for the group."));

      } else {

        $group = new UsersGroups;
        $group->fill($data);
        $group->save();
      }

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getGroupStudents($id)
  {
        $groups = UsersGroups::where('group_id', '=', $id)->
        select('user_id')->get();

        foreach ($groups as $key => $value) {
            $ids[] = $value["user_id"];
        }

        $students = User::join('students', 'students.user_id', '=', 'users.id')->join('courses', 'courses.id', '=', 'students.course_id')->whereIn('users.id', $ids)->
        select('users.id', 'users.name', 'courses.name as course')->get();

        return json_encode($students);
  }

  public function removeUsergroup($groupId)
  {
    DB::table('usergroup')->where('id','=',$groupId)->delete();
    return json_encode(array('success'=>true));  
  }


  public function removeStudentUserGroup()
  {
    $data = Input::all();
    DB::table('usersgroups')
        ->where([
          ['user_id','=',$data['student_id']],
          ['group_id','=',$data['group_id']]
        ])
        ->delete();
    return json_encode(array('success'=>true));
  }

  public function destroyLecturer($id)
  {
    $data = array('id' => $id);

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      if(User::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function createTemplate()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'name' => 'required'
    ]);

    if ($validator->passes()) {

      $template = new CalendarTemplate;
      $template->fill($data);

      if($template->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getTemplatesList()
  {
    $templates = CalendarTemplate::all();

    return json_encode($templates);
  }

  public function loadEventsFor($calendarid)
  {
    $events = CalendarEvents::where('calendar_id', $calendarid)->get(); 

    return json_encode($events);
  }

  public function loadEventsForStudent()
  {
    $user=view()->share('user',Auth::user());
    $templateids = array();
    $calendarid = array();
    $cleanTemplate = array();
    $allEvents = array();
    
    $usergroups = DB::table('usersgroups')->select('group_id')->where('user_id',$user->id)->get();

    
    if(!empty($usergroups[0])){
      foreach ($usergroups[0] as $groupID) {
        $templateid = DB::table('usergroup_schedule')->select('template_id')->where('usergroup_id',$groupID)->get();
        $templateids = array_merge($templateids,$templateid);
      }
    }else{
      return json_encode(array('success' => true,'calendar' => false,'message' => 'you are not belong to any group'));
    }
    
    foreach ($templateids as $tmp) {
      array_push($calendarid,$tmp->template_id);
    }

    $cleanTemplate = array_unique($calendarid);

    foreach ($cleanTemplate as $tmpId) {
      $events = CalendarEvents::where('calendar_id', $tmpId)->get(); 
      array_push($allEvents,$events);
    }
    

    return json_encode(array('success' => true, 'calendar' => true, 'events' => $allEvents));
  }

  public function addEvent()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'title' => 'required',
      'calendar_id' => 'required'
    ]);

    if ($validator->passes()) {

      $template = new CalendarEvents;
      $template->fill($data);

      if($template->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  //quick fix..
  public function addEventQf()
  {
   $data = Input::all();

   $validator = Validator::make($data,[
    'title' => 'required',
    'calendar_id' => 'required'
   ]);

   if($validator->passes()){
    // $data['date'] = 'Wed Nov 01 2017 00:00:00 GMT+0800 (Malay Peninsula Standard Time)';
  $dateStr = substr($data['date'],4,-41); //Nov 01 2017 00:00:00

  // $dateFormat = DateTime::createFromFormat('MMM dd yyyy HH:mm:ss',$dateStr);

    // $date = date_create_from_format('d/M/Y:H:i:s', $s);
    // $date->getTimestamp();

    DB::table('calendar_events')
      ->insert([
        'calendar_id'=>$data['calendar_id'],
        'title'=>$data['title'],
        'start'=>date("Y-m-d H:i:s", strtotime($data['date'])),
        'backgroundColor' => '#3498db'
      ]);
    return json_encode(array('success' => true));
   }else{
    return json_encode(array('success' => false));
   }

  }
  public function assignScheduleUserGroup()
  {
    $data = Input::all();

    //update table usergroup_schedule
    DB::table('usergroup_schedule')
        ->insert([
          ['usergroup_id' => $data['usergroup_id'],'template_id' => $data['template_id']]
        ]);

    return json_encode(array('success' => true));
  }

  public function generateWord()
  {
    // $phpWord = new \PhpOffice\PhpWord\PhpWord();

    // $section = $phpWord->addSection();

    // $section->addText(
    //     '"Learn from yesterday, live for today, hope for tomorrow. '
    //         . 'The important thing is not to stop questioning." '
    //         . '(Albert Einstein)'
    // );

    // $section->addText(
    //     '"Great achievement is usually born of great sacrifice, '
    //         . 'and is never the result of selfishness." '
    //         . '(Napoleon Hill)',
    //     array('name' => 'Tahoma', 'size' => 10)
    // );


    // $fontStyleName = 'oneUserDefinedStyle';
    // $phpWord->addFontStyle(
    //     $fontStyleName,
    //     array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
    // );
    // $section->addText(
    //     '"The greatest accomplishment is not in never falling, '
    //         . 'but in rising again after you fall." '
    //         . '(Vince Lombardi)',
    //     $fontStyleName
    // );

    // $fontStyle = new \PhpOffice\PhpWord\Style\Font();
    // $fontStyle->setBold(true);
    // $fontStyle->setName('Tahoma');
    // $fontStyle->setSize(13);
    // $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
    // $myTextElement->setFontStyle($fontStyle);


    // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    // $objWriter->save(public_path().'/helloWorld.docx');

    // Template processor instance creation
    echo date('H:i:s'), ' Creating new TemplateProcessor instance...';
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path().'/templates/template_bh.docx');


    // $templateProcessor->setValue('weekday', date('l'));
    // $templateProcessor->setValue('time', date('H:i'));
    // $templateProcessor->setValue('serverName', realpath(__DIR__));
    // $templateProcessor->cloneRow('rowValue', 10);
    // $templateProcessor->setValue('rowNumber#10', '10');
    // $templateProcessor->cloneRow('userId', 3);

    $fullName = "John Smith";
    $passportNo = "N1234356234";

    $templateProcessor->setValue('todaysDate', date('j/n/Y'));
    $templateProcessor->setValue('fullName', $fullName);
    $templateProcessor->setValue('passportNo', $passportNo);
    $templateProcessor->setValue('commencingDate', date('j/n/Y'));

    // $templateProcessor->todaysDate
    // $templateProcessor->fullName
    // $templateProcessor->passportNo
    // $templateProcessor->commencingDate



    $templateProcessor->saveAs(public_path().'/templates/'.$fullName.'_'.$passportNo.'.docx');

  }
}