<?php namespace App\Http\Controllers;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Auth;
use Response;
use Input;
use Validator;
use File;
use Storage;

use Illuminate\Database\Eloquent\Model;

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
use App\Models\Examsupervision as Examsupervision;
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
use App\Models\Teach as Teach;

use App\Models\FriendList as FriendList;
use App\Models\Messages as Messages;
use App\Models\Chat as Chat;
use App\Models\UserChat as UserChat;
use App\Models\Notification as Notification;
use App\Models\NotificationUser as NotificationUser;
use App\Models\ConsultationBookings as ConsultationBookings;
 use Illuminate\Support\Facades\DB;

use Hash;
use Redirect;
use Request;

class LecturerController extends Controller {

//ADD SECURITY VALIDATION FOR ID
  public function lecturerGetStudents($id)
  {
    //MODULE LIST & ITS COURSES FOR CURRENT LECTURER
    \DB::setFetchMode(\PDO::FETCH_ASSOC);

    $modules = \DB::table('modules')->where('lecturer_id', '=', $id)->select('id')->get();

    $courses = \DB::table('course_modules')->whereIn('course_modules.module_id', $modules)->select('course_modules.course_id')->distinct()->get();

    \DB::setFetchMode(\PDO::FETCH_CLASS);

    //LECTURER STUDENTS
    $students = User::join('students', 'students.user_id', '=', 'users.id')->
    join('courses', 'courses.id', '=', 'students.course_id')->
    //join('course_modules', 'courses.id', '=', 'course_modules.course_id')->
    //join('modules', 'course_modules.module_id', '=', 'modules.id')->
    select('users.id', 'users.name', 'users.status', 'courses.name as coursename', 'courses.id as courseid')->
    whereIn('courses.id', $courses)->
    where('users.type', '=', 'Student')->distinct()->get();

    return json_encode($students);
  }

  public function getModuleLectCount(){

      $user=view()->share('user',Auth::user());

      $count=array();
      
      $count[0]=Module::select('name')->where('lecturer_id', $user["id"])->count();
      
      $count[1]=Teach::select('student_id')->where('lecturer_id', $user["id"])->count();

    

      return $count;


  }
  public function lecturerGetModules($id)
  {
    if (isset($id) || !empty($id)) {

      $modules = Module::where('lecturer_id', $id)->get();

      return json_encode($modules);

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerGetAssessment()
  {
    $module_id = Input::get('module_id');
    $student_id = Input::get('id');

    $assessment = Assessment::join('modules', 'modules.id', '=','assessment.module_id')->where('student_id','=', $student_id)->where('module_id','=', $module_id)->get();

    return json_encode($assessment);
  }


  public function studentGetName($id)
  {
    $student = User::find($id);

    return json_encode($student);
  }


  public function studentGetInfo($id, $module)
  {
    $student = User::find($id);
    $module = Module::find($module);

    return json_encode(array('module' => $module, 'student' => $student));//, 'module' => $module));
  }

  public function submitAssessment()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'student_id' => 'required',
      'module_id' => 'required',
      'credit_points' => 'required',
      'mark' => 'required',
      'grade' => 'required',
    ]);

    if ($validator->passes()) {

      $assessment = new Assessment;
      $assessment->fill($data);

      if($assessment->save()) {

        //Notification
        $notification = new Notification;
        $module = Module::where('id', $data["module_id"])->first();

        $text = "Assessment for module ".$module->code." has been updated. Please check assessment section for more information.";
        $n_class = "notification-success";
        $n_icon = "glyphicon glyphicon-ok";

        $array = array(
                'text' => $text,
                'n_class' => $n_class,
                'n_icon' => $n_icon,
                'user_id' => $data["student_id"]
                );

        $notification->fill($array);
        $notification->save();

      } else {

        return json_encode(array('success' => false, 'errors' => "Unable to update assessment."));
      }

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }


  public function editAssessment()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'student_id' => 'required',
      'module_id' => 'required',
      'credit_points' => 'required',
      'mark' => 'required',
      'grade' => 'required',
    ]);

    if ($validator->passes()) {

      $assessment = Assessment::find($data["id"]);

      $assessment->fill($data);
      $assessment->save();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function studentGetAssessment($id, $module)
  {
    $record = Assessment::where('student_id', '=', $id)->
    where('module_id', '=', $module)->get();

    return json_encode($record);
  }

  public function lecturerCreateSlot()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'lecturer_id' => 'required',
      'module_id' => 'required',
      'date' => 'required',
    ]);

    if ($validator->passes()) {

      $data["date"] = new \DateTime($data["date"]);
      $data["date"] = $data["date"]->sub(new \DateInterval('PT7H'));
      $data["date"] = $data["date"];

      $slot = new Consultation;
      $slot->fill($data);
      $slot->save();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerGetConsultations($id)
  {
    $consultations = Consultation::leftJoin('users', 'users.id', '=', 'consultations.student_id')->
    join('modules', 'modules.id', '=', 'consultations.module_id')->
    select('consultations.id', 'users.name as studentname', 'modules.name', 'consultations.date', 'consultations.student_id as student_id')->
    where('consultations.lecturer_id', '=', $id)->
    get();


    foreach ($consultations as $consultation) {

      $t = strtotime($consultation["date"]);
      $consultation["date"] = date('l jS \of F Y h:i:s A',$t);
    }

    return json_encode($consultations);
  }

  public function lecturerUploadMaterials()
  {

    $name = Input::get('name');
    $ext = Input::get('ext');
    $module_id = Input::get('module_id');
    $category = Input::get('category');

    $file = $name.'.'.$ext; //str_random(12);
    $path = str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\'.$module_id.'\\'.$file;

  

    $data = request::get('file');

  

    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);

    $data = base64_decode($data);

    if (!is_dir(str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\'.$module_id)) {

      File::makeDirectory($path,0777,true);
    }

    //Write to File
    $check = file_put_contents($path, $data);


  

    $fileinformation = array('module_id' => $module_id, 'name' => $name, 'file' => $file, 
      'category' => $category, 'ext' => $ext, 'size'=> strlen($data) );

    if($check) {

      $record = new ModuleMaterials;
      $record->fill($fileinformation);

      if($record->save()) {

        //Creating Notification
        $notification = new Notification;

        $course = CourseModules::where('module_id', $module_id)->
        select('course_id')->first();

        $module = Module::where('id', $module_id)->first();

        $text = "Materials for module ".$module->code." has been updated. Please check module section.";
        $n_class = "notification-success";
        $n_icon = "glyphicon glyphicon-ok";

        $array = array(
                'text' => $text,
                'n_class' => $n_class,
                'n_icon' => $n_icon,
                'course_id' => $course["course_id"]
                );

        $notification->fill($array);
        $notification->save();

        return json_encode(array('success' => true, 'data' => $course["course_id"]));

      } else {

        return json_encode(array('success' => false));
        return (base_path());
      }

    } else {

      return json_encode(array('success' => false));

    }

    //return ($fileinformation);
    return json_encode(array('success' => true));


  }

  public function lecturerGetFiles($id)
  {
    $results = Module::join('module_materials', 'module_materials.module_id', '=', 'modules.id')->
    select('modules.id', 'modules.name', 'module_materials.id as item_id', 'module_materials.name as filename', 'module_materials.file', 'module_materials.category')->
    where('module_id', '=', $id)->orderBy('category', 'ASC')->get();

    return json_encode($results);
  }

  public function lecturerCreateExamination()
  {

    $data = Input::all();
    $data["status"] = 0;

    $validator = Validator::make($data, [
      'name' => 'required|min:4',
      'module_id' => 'required',
      'startdate' => 'required',
      'enddate' => 'required',
      'duration' => 'required',
      'type' => 'required',
      'code' => 'required',
    ]);

    if ($validator->passes()) {

      $enddate = new \DateTime($data["enddate"]);
      $enddate = $enddate->sub(new \DateInterval('PT7H'));
      $data["enddate"] = $enddate;
      //$date->format('Y-m-d H:i:s');

      $exam = new Examination;
      $exam->fill($data);
      if($exam->save()) {

        return json_encode(array('success' => true, 'id' => $exam->id));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerViewExaminations($id)
  {
    
    
      $user=view()->share('user',Auth::user());
      $lecturer=DB::table('lecturers')->where('user_id', $user["id"])->first();
     // $exam_lect=DB::table('exam_supervision')->where('lecturer_id', $lecturer->id)->select(['exam_id']);
      $exam_lect=Examsupervision::select('exam_id')->where('lecturer_id', $lecturer->id)->get();

      $examinations=DB::table('examination')->whereIN('id',$exam_lect)->get();



    return json_encode($examinations);
  }

  public function getExamById($id)
  {
    $exam = Examination::find($id);

    return json_encode($exam);
  }

  public function postMultipleChoice()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'question' => 'required|min:4',
      'exam_id' => 'required'
    ]);

    if ($validator->passes()) {

      $question = new MultipleChoice;
      $question->fill($data);
      if($question->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getExamMCQuestions($id)
  {
    $questions = MultipleChoice::where('exam_id', '=', $id)->get();

    return json_encode($questions);
  }

  public function lecturerViewConsultation($id)
  {
    $exist = Consultation::whereNotNull('student_id')->find($id);

    if($exist) {

      $consultation = Consultation::join('modules', 'modules.id', '=', 'consultations.module_id')->
      join('users', 'users.id', '=', 'consultations.student_id')->
      select('users.name as student', 'modules.name as module', 'modules.code', 'consultations.date', 'consultations.status', 'consultations.student_id')->
      find($id);

    } else {

      $consultation = Consultation::join('modules', 'modules.id', '=', 'consultations.module_id')->
      select('modules.name as module', 'modules.code', 'consultations.date', 'consultations.status', 'consultations.student_id')->
      find($id);
    }

    return json_encode($consultation);
  }

  public function approveConsultation()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required',
      'status' => 'required',
      'student_id' => 'required'
    ]);

    if ($validator->passes()) {

      $consultation = Consultation::find($data["id"]);
      $consultation->fill($data);

      if($consultation->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerGetResultsMC($id)
  {
    $results = ResultsMC::join('users', 'users.id', '=', 'student_multiplechoice.student_id')->
    select('users.name as student', 'student_multiplechoice.started_time', 'student_multiplechoice.results')->
    where('exam_id', '=', $id)->get();

    return json_encode($results);
  }

  public function lecturerCreateTest()
  {
    $data = Input::all();
    $data["status"] = 0;

    $validator = Validator::make($data, [
      'name' => 'required|min:4',
      'module_id' => 'required',
      'startdate' => 'required',
      'enddate' => 'required',
      'duration' => 'required',
      'code' => 'required',
    ]);

    if ($validator->passes()) {

      $enddate = new \DateTime($data["enddate"]);
      $enddate = $enddate->sub(new \DateInterval('PT7H'));
      $data["enddate"] = $enddate;
      //$date->format('Y-m-d H:i:s');

      $test = new Tests;
      $test->fill($data);
      if($test->save()) {

        return json_encode(array('success' => true, 'id' => $test->id));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function delete_test_question($test_id){


       $data = Input::all();
       
     
       if(DB::table('test_questions')->where('test_id', $test_id)->where('question', $data['q'])->delete())

        return json_encode(array('success' => true));

      else

        return json_encode(array('success' => false));



  }


  public function delete_test($modulecode){


        $module=DB::table('modules')->where('code', $modulecode)->first();
        $test=DB::table('tests')->where('module_id', $module->id)->first();

        if(DB::table('tests')->where('module_id', $module->id)->delete())

         return json_encode(array('success' => true));

      else

        return json_encode(array('success' => false));



    }

  public function lecturerViewTests($id)
  {
    $tests = Module::join('tests', 'modules.id', '=', 'tests.module_id')->
    select('modules.name as modulename', 'modules.code as modulecode', 'tests.id', 'tests.name', 'tests.startdate', 'tests.enddate', 'tests.duration', 'tests.code', 'tests.status', 'tests.id')->
    where('modules.lecturer_id', '=', $id)->get();

    return json_encode($tests);
  }

  public function getTestById($id)
  {
    $test = Tests::find($id);

    return json_encode($test);
  }

  public function getTestQuestions($id)
  {
    $questions = TestQuestions::where('test_id', $id)->get();

    return json_encode($questions);
  }

  public function postTestQuestions()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'question' => 'required|min:4',
      'test_id' => 'required'
    ]);

    if ($validator->passes()) {

      $question = new TestQuestions;
      $question->fill($data);
      if($question->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function lecturerGetTestResults($id)
  {
    $results = TestResults::join('users', 'users.id', '=', 'test_results.student_id')->
    select('users.name as student', 'test_results.started_time', 'test_results.results')->
    where('test_id', '=', $id)->get();

    return json_encode($results);
  }

  public function lecturerGetStudentFullDetails($id)
  {
    $personalinfo = Students::where('user_id', '=', $id)->get();
    $course = null;

    if($personalinfo[0]["course_id"] != null) {
      $course = Course::find($personalinfo[0]["course_id"]);
    }


    return json_encode(array('personalinfo' => $course, 'course' => $course));
  }

  public function lecturerGetModuleAssignments($id)
  {
    $assignments = Assignment::join('users', 'users.id', '=', 'assignments.student_id')->
    join('modules', 'modules.id', '=', 'assignments.module_id')->
    select('assignments.id', 'assignments.module_id', 'assignments.student_id', 'assignments.name', 'assignments.file', 'assignments.ext', 'assignments.size', 'modules.code', 'modules.name as module', 'users.name as student', 'assignments.created_at', 'assignments.updated_at')->
    where('module_id', '=', $id)->get();

    return json_encode($assignments);
  }


  public function postFillUp()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'question' => 'required|min:4',
      'exam_id' => 'required'
    ]);

    if ($validator->passes()) {

      $question = new FillUpQuestions;
      $question->fill($data);
      if($question->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getExamFillUpQuestions($id)
  {
    $questions = FillUpQuestions::where('exam_id', '=', $id)->get();

    return json_encode($questions);
  }

  public function getStudentsFillup($id)
  {
    $students = ResultsFillUp::join('users', 'users.id', '=', 'student_fillup.student_id')->
    select('users.id', 'users.name as student', 'student_fillup.started_time')->
    where('student_fillup.exam_id', '=', $id)->
    orWhere('student_fillup.submited', '=', 1)->get();

    return json_encode($students);
  }


  public function examFillUpResults($id, $exam_id)
  {
    $questions = FillUpQuestions::where('exam_id', '=', $exam_id)->get();

    $results = ResultsFillUp::select('results')->where('student_id', '=', $id)->
    orWhere('exam_id', '=', $exam_id)->get();

    return json_encode(array('questions' => $questions, 'answers' => $results));
  }

  public function getExamEssayQuestions($id)
  {
    $questions = EssayQuestions::where('exam_id', '=', $id)->get();

    return json_encode($questions);
  }

  public function postEssay()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'question' => 'required|min:4',
      'exam_id' => 'required'
    ]);

    if ($validator->passes()) {

      $question = new EssayQuestions;
      $question->fill($data);
      if($question->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getStudentsEssay($id)
  {
    $students = ResultsEssay::join('users', 'users.id', '=', 'student_essay.student_id')->
    select('users.id', 'users.name as student', 'student_essay.started_time')->
    where('student_essay.exam_id', '=', $id)->
    orWhere('student_essay.submited', '=', 1)->get();

    return json_encode($students);
  }

  public function examEssayResults($id, $exam_id)
  {
    $questions = EssayQuestions::where('exam_id', '=', $exam_id)->get();

    $results = ResultsEssay::select('results')->where('student_id', '=', $id)->
    orWhere('exam_id', '=', $exam_id)->get();

    return json_encode(array('questions' => $questions, 'answers' => $results));
  }

  public function moduleMaterialsDestroy()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      $file = ModuleMaterials::find($data["id"]);
      $path = str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'/files/'.$file["module_id"].'/'.$file["file"];

      unlink($path);

      if(ModuleMaterials::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function assignmentsDestroy()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      $file = Assignment::find($data["id"]);
      $path = str_replace("/laravel","",base_path()).'/files/assignments/'.$file["student_id"].'/'.$file["file"];

      unlink($path);

      if(Assignment::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function examinationChangeStatus()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      $update = array('status' => 1);

      if(Examination::find($data["id"])->update($update)) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function createAnnouncement()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'type' => 'required',
      'value' => 'required|min:4',
      'submitted_by' => 'required',
      'user_group' => 'required'
    ]);

    if ($validator->passes()) {

      $data["datetime"] = new \DateTime();
      $data["datetime"] = $data["datetime"]->sub(new \DateInterval('PT7H'));

      $query = new Announcement;
      $query->fill($data);

      if($query->save()) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getAllAnnouncements()
  {
    $results = Announcement::leftJoin('usergroup', 'usergroup.id', '=', 'announcements.user_group')->
    select('announcements.id', 'announcements.datetime', 'announcements.type', 'announcements.value', 'announcements.submitted_by', 'usergroup.name')->
    get();

    return json_encode($results);
  }

  public function destroyAnnouncement()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      if(Announcement::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function deleteConsultation($id)
  {
    $data = array('id' => $id);

    $validator = Validator::make($data, [
      'id' => 'required'
    ]);

    if ($validator->passes()) {

      if(Consultation::destroy($data["id"])) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }


public function lecturerDeleteExamination()
  {
    $data = Input::all();
    $user=view()->share('user',Auth::user());

    $exam1 = Examination::where('name', '=', $data["id"]);
    //$exam2=Examsupervision::where('lecturer_id', '=', $user->id);

    if($exam1->delete()) {

      //User::find($data["user_id"])->delete();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => "Unable to remove exam."));
    }
  }

  public function getLecturerMaterials($id)
  {
    $results = LecturerMaterials::where('module_id', '=', $id)->get();

    return json_encode($results);
  }

  public function createTask()
  {

    
    $title = Input::get('title');
    $description = Input::get('description');
    $group_id = Input::get('group_id');
    $date = Input::get('duedate');
    $filename=Input::get('filename');
    $lecturer_id = Input::get('lecturer_id');

    $timestamps = new \DateTime();

    $ext = Input::get('ext');
    $file =$filename.'.'.$ext;
    //$path = str_replace("/laravel","",base_path()).'/files/tasks/'.$file;

     $path = str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\tasks\\'.$file;

    $data = Request::get('file');

   

    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);

    $data = base64_decode($data);

    

    if (!is_dir(str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\tasks\\')) {

      File::makeDirectory($path,0777,true);
    }

    //Write to File
    $check = file_put_contents($path, $data);

     


    $fileinformation = array('title' => $title, 'description'=> $description, 'duedate'=>$date, 
      'lecturer_id'=>$lecturer_id, 'file' => $file, 'group_id' => $group_id, 'created_at'=>$timestamps, 'updated_at'=>NULL);

    if($check) {

      $record = new Tasks;
      $record->fill($fileinformation);

      if($record->save()) {

        //Notification
        $notification = new Notification;

        $text = "You have new incomplete task. Please check your task list for more information.";
        $n_class = "notification-success";
        $n_icon = "glyphicon glyphicon-ok";

        $array = array(
                'text' => $text,
                'n_class' => $n_class,
                'n_icon' => $n_icon,
                'group_id' => $group_id
                );

        $notification->fill($array);
        $notification->save();

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false));
      }

    } else {

      return json_encode(array('success' => false));
    }

    return (json_encode(array('success' => $path)));

    //return json_encode(array('success'=>$title));
    
  }


  public function deleteLecturerTasks($id){

    
  if( Tasks::find($id)->delete()) {

     //Course::find($data["id"])->delete();

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => "Unable to remove course."), $course->error_log());
    }

  }

  public function getLecturerTasks($id)
  {
    $tasks = Tasks::where('lecturer_id', '=', $id)->get();

    return json_encode($tasks);
  }

  public function getStudentTasks($id)
  {
    $tasks = TasksUpload::join('users', 'users.id', '=', 'tasks_upload.user_id')->
    select('users.name', 'tasks_upload.datetime', 'tasks_upload.id', 'tasks_upload.file')->
    where('task_id', '=', $id)->get();

    return json_encode($tasks);
  }

  public function lecturerGetTaskById($id)
  {
    $task = Tasks::find($id);

    return json_encode($task);
  }

  public function getLecturerAnnouncements()
  {
    $user = Auth::user()->id;

    $results = \DB::table('announcements')->take(6)->
    orderBy('datetime', 'DESC')->get();



    return json_encode($results);
  }

  public function lecturerGetConsultationBookings($id)
  {
    $bookings = ConsultationBookings::join('users', 'users.id', '=', 'consultation_bookings.user_id')->
    select('users.name', 'consultation_bookings.consultation_id', 'consultation_bookings.user_id', 'consultation_bookings.reason', 'consultation_bookings.type')->
    where('consultation_id', $id)->get();

    return json_encode($bookings);
  }

  public function lecturerAddFriend()
  {
    $data = Input::all();
    $user_id = Auth::user()->id;

    $array = array(
        'user_id' => $user_id,
        'friend_id' => $data["user_id"]
        );

    $check = FriendList::where('user_id', $user_id)->where('friend_id', $data["user_id"])->get();

    if($check->isEmpty()) {

      if(FriendList::create($array)) {

        $array = array(
            'user_id' => $data["user_id"],
            'friend_id' => $user_id
            );

            if(FriendList::create($array)) {

              return json_encode(array('success' => true, 'message' => 'Student successfully added to your friend list.'));

            } else {

              return json_encode(array('success' => false, 'message' => 'Unable to add user to the friend list.'));
            }

      } else {

        return json_encode(array('success' => false, 'message' => 'Unable to add user to the friend list.'));
      }

    } else {

      return json_encode(array('success' => false, 'message' => 'User already in your friend list.'));

    }
  }



}