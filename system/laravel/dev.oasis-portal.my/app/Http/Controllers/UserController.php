<?php namespace App\Http\Controllers;

use Closure;
use Illuminate\Contracts\Auth\Guard;

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


use Hash;
use Redirect;
use Request;

class UserController extends Controller {

  protected $auth;

  public function __construct(Guard $auth)
  {
    $this->auth = $auth;
    $this->middleware('auth');
  }









  public function getProfile()
  {
    $user = User::find(Auth::user()->id);

    return json_encode($user);
  }

  public function updateProfile()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'id' => 'required',
      'password' => 'required|min:6',
    ]);

    if ($validator->passes()) {

      $data["password"] = Hash::make($data["password"]);

      $user = User::where('id', '=', $data['id']);
      $user->update($data);

      return json_encode(array('success' => true));

    } else {

      return json_encode(array('success' => false, 'errors' => $validator->messages()->all()));
    }
  }


  public function getFriendList()
  {
    $id = Auth::user()->id;


    $friendList = FriendList::join('users', 'users.id', '=', 'friend_list.friend_id')->
    select('users.id', 'users.name', 'users.avatar', 'users.status')->
    where('user_id', $id)->get();

    return json_encode($friendList);
  }

  public function getChatMessages($id)
  {

    //SELECT * FROM `user_chat` WHERE `user_id` = 20 OR `user_id` = 2
    $user = Auth::user()->id;
    $ids = [$id, $user];

    $chat = \DB::select('SELECT `chat_id` FROM `user_chat` WHERE `user_id` IN (:id, :id2) GROUP BY `chat_id` HAVING COUNT(*) > 1', ['id' => $user, 'id2' => $id]);

    $chat_id = null;
    $messages = null;

    foreach ($chat as $result) {
        $chat_id = $result->chat_id;
    }

    if($chat == null) {

      return;

    } else {

      $messages = Messages::join('users', 'users.id', '=', 'message.user_id')->
      select('message.id', 'message.text', 'message.chat_id', 'message.user_id', 'message.created_at', 'users.avatar')->
      where('message.chat_id', $chat_id)->
      orderBy('message.created_at', 'ASC')->limit(20)->get();

      return json_encode($messages);
    }
  }

  public function postChatMessage()
  {
    $data = Input::all();

    $validator = Validator::make($data, [
      'text' => 'required',
      'currentUser' => 'required'
    ]);

    if ($validator->passes()) {

      $user = Auth::user()->id;

      //SELECT `chat_id` FROM `user_chat` WHERE `user_id` IN (20,2) GROUP BY `chat_id` HAVING COUNT(*) > 1
      $chat = \DB::select('SELECT `chat_id` FROM `user_chat` WHERE `user_id` IN (:id, :id2) GROUP BY `chat_id` HAVING COUNT(*) > 1', ['id' => $user, 'id2' => $data["currentUser"]]);

      $chat_id = null;
      if($chat == null) {

        $newChat = Chat::create([]);
        $chat_id = $newChat->id;

        $array = array(
                'chat_id' => $chat_id,
                'user_id' => $user
                );

        UserChat::create($array);

        $array = array(
                'chat_id' => $chat_id,
                'user_id' => $data["currentUser"]
                );

        UserChat::create($array);

        $chat = false;

      } else {

        $chat_id = $chat[0]->chat_id;
        $chat = true;
      }

      $message = new Messages;
          $message->text = $data["text"];
          $message->user_id = Auth::user()->id;
          $message->chat_id = $chat_id;

          if($message->save()) {

            return json_encode(array('success' => true, 'id' => $message->id));

          } else {

            return json_encode(array('success' => false));
          }

    } else {

      return json_encode(array('success' => false));
    }
  }

  public function getChatUpdates($messageId, $recipientId)
  {

    $user = Auth::user()->id;
    $chat = \DB::select('SELECT `chat_id` FROM `user_chat` WHERE `user_id` IN (:id, :id2) GROUP BY `chat_id` HAVING COUNT(*) > 1', ['id' => $user, 'id2' => $recipientId]);

    $chat_id = null;
    $messages = null;

    foreach ($chat as $result) {
        $chat_id = $result->chat_id;
    }

    if($chat == null) {

      return;

    } else {

      $names = Messages::join('users', 'users.id', '=', 'message.user_id')->
      select('message.id', 'message.text', 'message.chat_id', 'message.user_id', 'message.created_at', 'users.avatar')->
      where('message.chat_id', $chat_id)->
      where('message.id', '>', $messageId)->
      orderBy('message.created_at', 'ASC')->limit(20)->get();

      return json_encode($names);

    }
  }

  public function postProfilePicture()
  {
    $data = Input::all();
    $user_id = Auth::user()->id;

        $auth_rules = [

            'image' => 'min:3|required'
        ];

        $validator = Validator::make($data, $auth_rules);

        if ($validator->passes())
        {
            $ext = strtok($data["image"], ';');
            $ext = substr($ext, 11, 11);

            $file = str_random(12).'_'.$user_id.'.'.$ext;

            $path = str_replace("/laravel","",base_path()).'/files/avatar/'.$file;

            list($type, $data["image"]) = explode(';', $data["image"]);
            list(, $data["image"])      = explode(',', $data["image"]);

            $data["image"] = base64_decode($data["image"]);
            $check = file_put_contents($path, $data["image"]);

            if($check) {

                $user = User::where('id', $user_id)->first();

                if($user->avatar) {

                    $past = str_replace("/laravel","",base_path()).'/files/avatar/'.$user->avatar;
                    unlink($past);
                }

                $user->avatar = $file;
                $user->save();

                return json_encode(array('success' => true));

            } else {

                return json_encode(array('success' => false));
            }

        } else {

            return json_encode(array('success' => false));
        }
  }

  public function getUserTaskProgress()
  {
    $tasks_upload = TasksUpload::select('task_id')->where('user_id', Auth::user()->id)->get();
    $array = [];

    foreach ($tasks_upload as $key => $value) {
      $array[] = $value->task_id;
    }

    $date = date('Y-m-d H:i:s');

    $user_tasks = Tasks::join('usersgroups', 'usersgroups.group_id', '=', 'tasks.group_id')->
    whereNotIn('tasks.id', $array)->
    where('usersgroups.user_id', Auth::user()->id)->
    where('tasks.duedate', '>=', $date)->
    get();


    return json_encode($user_tasks);
  }

}