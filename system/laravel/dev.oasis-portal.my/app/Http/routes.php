<?php

use Illuminate\support\Facades\Auth;

Blade::setContentTags('<%', '%>');        // for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>');   // for escaped data

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);

Route::get('/generateWord', 'AdminController@generateWord');

Route::group(['middleware' => ['web']], function () {



});

Route::group(['middleware' => 'web'], function () {
    
	Route::auth();
	Route::get('/api/login/deauth', 'AdminController@Logout');

	//Obtain current user for $localStorage
	Route::get('/auth/login/store', 'AdminController@authStore');
	Route::get('auth/login', function () {	


		return view('login');
	});

	// Route::get('lock', function(){

	// 	return view('lock');

	// });



	Route::get('/', array('as' => 'home', 'before' => 'auth', 'uses' => 'HomeController@index'));
	Route::get('/logout', 'HomeController@getLogout');

	Route::get('/getProfile', 'UserController@getProfile');
	Route::post('/profile-update', 'UserController@updateProfile');
	Route::get('/user/get-friends', 'UserController@getFriendList');
	Route::get('/chat/get-messages/{id}', 'UserController@getChatMessages')->where('id', '[1-9][0-9]*');
	Route::post('/chat/post-message', 'UserController@postChatMessage');
	Route::get('/chat/get-updates/{messageId}/{recipientId}', 'UserController@getChatUpdates')->where('messageId', '[1-9][0-9]*')->where('recipientId', '[1-9][0-9]*');
	Route::post('/user/upload-avatar', 'UserController@postProfilePicture');
	Route::get('/user/get-task-progress', 'UserController@getUserTaskProgress');


	/*
	|--------------------------------------------------------------------------
	| ADMIN ROUTES
	|--------------------------------------------------------------------------
	*/

	

	Route::get('/student-notifications/{id}', 'AdminController@getStudentPersonalNotifications');
	Route::post('/admin/lockstudent', 'AdminController@lockUserById');

	Route::get('/browseStudents', 'AdminController@admin_browse_students');
	Route::post('/popup/create', 'AdminController@createPopUpNotification');
	Route::post('/student/register', 'AdminController@register_student');
	Route::post('/course/register', 'AdminController@courseRegister');
	Route::get('/course/getcourses', 'AdminController@getCourses');
	Route::post('/course/update','AdminController@updateCourses');
	Route::post('/module/register', 'AdminController@moduleRegister');
	Route::post('/course/delete', 'AdminController@courseDelete');
	

	Route::post('/module/update', 'AdminController@moduleUpdate');
	Route::post('/module/updateInstructional','AdminController@moduleUpdateInstructional');
	Route::post('/module/updateSynopsisObjectives','AdminController@moduleUpdateSynoObj');
	Route::post('/module/updateLearningOutcome','AdminController@updateLearningOutcome');
	Route::post('/module/updateTeachingStrategies', 'AdminController@updateTeachingStrategies');
	Route::post('/module/updateTableAssessment','AdminController@updateTableAssessment');
	Route::post('/module/updateTableOutcome','AdminController@updateTableOutcome');

	Route::get('/module/getLearningOutcomes/{moduleId}','AdminController@getLearningOutcomes')->where('moduleId','[1-9][0-9]*');
	Route::get('/module/getAssessmentComponent/{moduleId}','AdminController@getAssessmentComponent')->where('moduleId','[1-9][0-9]*');

	Route::post('/module/delete', 'AdminController@moduleDelete');
	Route::get('/module/getmodules', 'AdminController@getModules');
	Route::post('/module/removeFromCourses','AdminController@removeModuleFromCourse');
	Route::post('/lecturer/register', 'AdminController@register_lecturer');
	Route::get('/browseLecturers', 'AdminController@admin_browse_lecturers');
	Route::get('/users/getlecturers', 'AdminController@getLecturers');
	Route::get('/course/getdetails/{id}', array('as' => 'admin.course.details', 'uses' => 'AdminController@getCourseDetails'))->where('id', '[1-9][0-9]*');
	Route::get('/course/getmodules/{id}', array('as' => 'admin.course.modules', 'uses' => 'AdminController@getCourseModules'))->where('id', '[1-9][0-9]*');
	Route::get('/course/getStudent/{id}','AdminController@getEnrollStudent')->where('id','[1-9][0-9]*');
	Route::get('/course/removeStudent/{courseid}/{userid}','AdminController@removeStudentFromCourses')->where('courseid','[1-9][0-9]*')->where('userid','[1-9][0-9]*');

	Route::post('/course/assignmodule', 'AdminController@courseModuleAssign');
	Route::post('/student/update', 'AdminController@studentUpdateDetails');
	Route::get('/student/getdetails/{id}', 'AdminController@getStudentDetails')->where('id', '[1-9][0-9]*');
	Route::get('/student/feedetails/{id}', 'AdminController@getStudentFees')->where('id', '[1-9][0-9]*');
	Route::post('/student/postfees', 'AdminController@postStudentFees');
	Route::post('/lecturer/update', 'AdminController@lecturerUpdateDetails');
	Route::post('/lecturer/updateInfo','AdminController@lecturerUpdateInfo');

	Route::get('/lecturer/getdetails/{id}', 'AdminController@getLecturerDetails')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/getmodulecount', 'LecturerController@getModuleLectCount');
	Route::post('/feedetails/destroy', 'AdminController@feeDetailsDestroy');
	Route::post('/student/delete', 'AdminController@studentDelete');
	Route::post('/usergroup/create', 'AdminController@createUserGroup');
	Route::get('/usergroup/all', 'AdminController@getAllUserGroups');
	Route::get('/system/getmodules', 'AdminController@getSystemModules');
	Route::get('/admin/getfiles/{id}', 'AdminController@adminGetFiles')->where('id', '[1-9][0-9]*');
	Route::post('/admin/upload-materials', 'AdminController@adminUploadMaterials');
	Route::post('/lecturer-materials/destroy', 'AdminController@lecturerMaterialsDestroy');
	Route::get('/usergroup/students', 'AdminController@getAllStudents');
	Route::post('/usergroup/assign', 'AdminController@assignUserGroup');
	Route::get('/usergroup/delete/{groupId}','AdminController@removeUsergroup')->where('groupId','[1-9][0-9]*');
	Route::get('/usergroup/group-students/{id}', 'AdminController@getGroupStudents')->where('id', '[1-9][0-9]*');
	Route::post('/usergroup/remove-student','AdminController@removeStudentUserGroup');
	Route::get('/usergroup/getName/{groupId}','AdminController@getGroupName')->where('groupId','[1-9][0-9]*');
	Route::post('/usergroup/changeName','AdminController@editGroupName');

	Route::get('/lecturer/delete/{id}', 'AdminController@destroyLecturer')->where('id', '[1-9][0-9]*');

	Route::post('/student/createTemplate', 'AdminController@createTemplate');
	Route::get('/schedule/getTemplatesList', 'AdminController@getTemplatesList');
	Route::get('/schedule/loadEventsFor/{calendarid}', 'AdminController@loadEventsFor')->where('calendarid','[1-9][0-9]*');
	Route::get('/schedule/loadEventsForStudent/', 'AdminController@loadEventsForStudent');

	Route::post('/student/addEvent', 'AdminController@addEvent');
	Route::post('/admin/assign-usergroup-schedule', 'AdminController@assignScheduleUserGroup');

	Route::post('/admin/addSchedule','AdminController@addEventQf');
	/*
	|--------------------------------------------------------------------------
	| LECTURER ROUTES
	|--------------------------------------------------------------------------
	*/

	Route::get('/lecturer/getstudents/{id}', 'LecturerController@lecturerGetStudents')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/getmodules/{id}', 'LecturerController@lecturerGetModules')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/getassessment', 'LecturerController@lecturerGetAssessment');
	Route::get('/student/getname/{id}', 'LecturerController@studentGetName')->where('id', '[1-9][0-9]*');
	Route::get('/student/personalinfo/{id}/{module}', 'LecturerController@studentGetInfo')->where('id', '[1-9][0-9]*')->where('module', '[1-9][0-9]*');
	Route::post('/student/submitassessment', 'LecturerController@submitAssessment');
	Route::post('/student/editassessment', 'LecturerController@editAssessment');
	Route::get('/student/getassessment/{id}/{module}', 'LecturerController@studentGetAssessment')->where('id', '[1-9][0-9]*')->where('module', '[1-9][0-9]*');
	Route::post('/lecturer/createslot', 'LecturerController@lecturerCreateSlot');
	Route::get('/lecturer/getconsultations/{id}', 'LecturerController@lecturerGetConsultations')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/upload-materials', 'LecturerController@lecturerUploadMaterials');
	Route::get('/lecturer/getfiles/{id}', 'LecturerController@lecturerGetFiles')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/create-examination', 'LecturerController@lecturerCreateExamination');

	Route::post('/lecturer/delete-examination', 'LecturerController@lecturerDeleteExamination');
	Route::get('/lecturer/viewexaminations/{id}', 'LecturerController@lecturerViewExaminations')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/getexambyid/{id}', 'LecturerController@getExamById')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/examination-postmultiplechoice', 'LecturerController@postMultipleChoice');
	Route::get('/lecturer/getmultiplechoicequestions/{id}', 'LecturerController@getExamMCQuestions')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/view-consultation/{id}', 'LecturerController@lecturerViewConsultation')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/approve-consultation', 'LecturerController@approveConsultation');
	Route::get('/student/get-mcresults/{id}', 'LecturerController@lecturerGetResultsMC')->where('id', '[1-9][0-9]*');
	
	
	Route::get('/student/getmodulecount', 'StudentController@getModuleStudCount');

	Route::post('/lecturer/create-test', 'LecturerController@lecturerCreateTest');
	Route::get('/lecturer/viewtests/{id}', 'LecturerController@lecturerViewTests')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/gettestbyid/{id}', 'LecturerController@getTestById')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/gettestquestions/{id}', 'LecturerController@getTestQuestions')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/delete_test_q/{test_id}', 'LecturerController@delete_test_question')->where('id', '[1-9][0-9]*');

	Route::post('/lecturer/delete_test/{modulecode}', 'LecturerController@delete_test')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/test-postquestions', 'LecturerController@postTestQuestions');
	Route::get('/student/get-testresults/{id}', 'LecturerController@lecturerGetTestResults')->where('id', '[1-9][0-9]*');
	Route::get('/student/getfulldetails/{id}', 'LecturerController@lecturerGetStudentFullDetails')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/getmoduleassignments/{id}', 'LecturerController@lecturerGetModuleAssignments')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/examination-postfillup', 'LecturerController@postFillUp');
	Route::get('/lecturer/getfillupquestions/{id}', 'LecturerController@getExamFillUpQuestions')->where('id', '[1-9][0-9]*');
	Route::get('/student/get-fillupstudents/{id}', 'LecturerController@getStudentsFillup')->where('id', '[1-9][0-9]*');
	Route::get('/exam/fillupresults/{id}/{exam_id}', 'LecturerController@examFillUpResults')->where('id', '[1-9][0-9]*')->where('exam_id', '[1-9][0-9]*');
	Route::get('/lecturer/getessayquestions/{id}', 'LecturerController@getExamEssayQuestions')->where('id', '[1-9][0-9]*');
	Route::post('/lecturer/examination-postessay', 'LecturerController@postEssay');
	Route::get('/student/get-essaystudents/{id}', 'LecturerController@getStudentsEssay')->where('id', '[1-9][0-9]*');
	Route::get('/exam/essayresults/{id}/{exam_id}', 'LecturerController@examEssayResults')->where('id', '[1-9][0-9]*')->where('exam_id', '[1-9][0-9]*');
	Route::post('/module-materials/destroy', 'LecturerController@moduleMaterialsDestroy');
	Route::post('/assignments/destroy', 'LecturerController@assignmentsDestroy');
	Route::post('/examinations/change-status', 'LecturerController@examinationChangeStatus');
	Route::post('/announcement/create', 'LecturerController@createAnnouncement');
	Route::get('/announcement/getall', 'LecturerController@getAllAnnouncements');
	Route::post('/announcements/destroy', 'LecturerController@destroyAnnouncement');
	Route::get('/delete-consultation/{id}', 'LecturerController@deleteConsultation')->where('id', '[1-9][0-9]*');
	Route::get('/lecturer/learning-materials/{id}', 'LecturerController@getLecturerMaterials')->where('id', '[1-9][0-9]*');
	Route::post('/task/post-task', 'LecturerController@createTask');
	Route::get('/tasks/lecturer-tasks/{id}', 'LecturerController@getLecturerTasks')->where('id', '[1-9][0-9]*');
	Route::get('/tasks/get-student-tasks/{id}', 'LecturerController@getStudentTasks')->where('id', '[1-9][0-9]*');
	Route::get('/tasks/get-by-id/{id}', 'LecturerController@lecturerGetTaskById')->where('id', '[1-9][0-9]*');
	Route::get('/tasks/delete-lecturer-tasks/{id}', 'LecturerController@deleteLecturerTasks')->where('id', '[1-9][0-9]*');
	Route::get('/announcement/lecturer-get', 'LecturerController@getLecturerAnnouncements');
	
	Route::get('/lecturer/consultation-bookings/{id}', 'LecturerController@lecturerGetConsultationBookings')->where('id', '[1-9][0-9]*');
	Route::post('/user/add-friend', 'LecturerController@lecturerAddFriend');


	/*
	|--------------------------------------------------------------------------
	| STUDENT ROUTES
	|--------------------------------------------------------------------------
	*/
	Route::get('/user/get-pnotifications', 'StudentController@getPersonalNotifications');
	Route::get('/student/webresults/{id}', 'StudentController@studentWebresults')->where('id', '[1-9][0-9]*');
	Route::get('/student/getmodules/{id}', 'StudentController@studentGetModules')->where('id', '[1-9][0-9]*');
	Route::get('/student/getmodulebyid/{id}', 'StudentController@getModuleById')->where('id', '[1-9][0-9]*');
	Route::get('/student/learning-materials/{id}', 'StudentController@getLearningMaterials')->where('id', '[1-9][0-9]*');
	Route::get('/student/get-examinations/{id}', 'StudentController@examinationModules')->where('id', '[1-9][0-9]*');
	Route::get('/student/getexambyid/{id}', 'StudentController@studentGetExamById')->where('id', '[1-9][0-9]*');
	Route::post('/postResultsMC', 'StudentController@postResultsMC');
	Route::get('/student/getconsultations/{id}', 'StudentController@studentGetConsultations')->where('id', '[1-9][0-9]*');
	Route::get('/authenticate/user/{id}', 'StudentController@authenticateUser')->where('id', '(.*)');
	Route::post('/student/book', 'StudentController@studentBookConsultation');
	Route::get('/student/getmyconsultations/{id}', 'StudentController@studentGetMyConsultations')->where('id', '[1-9][0-9]*');
	Route::get('/student/get-mcquestions/{id}', 'StudentController@studentGetQuestionsMC')->where('id', '[1-9][0-9]*');
	Route::post('/student/postResultsMC', 'StudentController@studentResultsMC');
	Route::get('/student/getResultsMCbyId/{id}/{exam_id}', 'StudentController@getMCResultsById')->where('id', '[1-9][0-9]*')->where('exam_id', '[1-9][0-9]*');
	Route::get('/student/get-tests/{id}', 'StudentController@studentGetTests')->where('id', '[1-9][0-9]*');
	Route::get('/student/gettestbyid/{id}', 'StudentController@studentGetTestById')->where('id', '[1-9][0-9]*');
	Route::get('/student/getTestResultsById/{id}/{test_id}', 'StudentController@studentGetTestResultsById')->where('id', '[1-9][0-9]*')->where('test_id', '[1-9][0-9]*');
	Route::post('/postResultsTest', 'StudentController@postResultsTest');
	Route::get('/student/get-testquestions/{id}', 'StudentController@studentGetQuestionsTest')->where('id', '[1-9][0-9]*');
	Route::post('/student/postTestResults', 'StudentController@studentPostTestResults');
	Route::get('/student/getstudentbyid/{id}', 'StudentController@getStudentById')->where('id', '[1-9][0-9]*');
	Route::post('/student/submitAssignment', 'StudentController@studentSubmitAssignment');
	Route::post('/student/postResultsFillUp', 'StudentController@studentPostFillUpResults');
	Route::post('/postFillUp', 'StudentController@postFillUpResults');
	Route::get('/student/getResultsFillUpById/{id}/{exam_id}', 'StudentController@studentGetResultsFillUpById')->where('id', '[1-9][0-9]*')->where('exam_id', '[1-9][0-9]*');
	Route::post('/postEssay', 'StudentController@postEssayResults');
	Route::get('/student/getResultsEssayById/{id}/{exam_id}', 'StudentController@studentGetResultsEssayById')->where('id', '[1-9][0-9]*')->where('exam_id', '[1-9][0-9]*');
	Route::post('/student/postResultsEssay', 'StudentController@studentPostEssayResults');
	Route::get('/student/get-my-tasks/{id}', 'StudentController@studentGetMyTasks')->where('id', '[1-9][0-9]*');
	Route::get('/tasks/get-task-by-id/{id}', 'StudentController@studentGetTaskById')->where('id', '[1-9][0-9]*');
	Route::post('/task/upload-task', 'StudentController@studentPostTask');
	Route::get('/announcement/getdashboard', 'StudentController@getDashboardAnnouncements');
	Route::get('/user/load-notifications', 'StudentController@loadUserCourseNotification');
	Route::get('/user/load-specific', 'StudentController@loadUserNotification');
	Route::get('/user/load-usergroup', 'StudentController@loadUserGroupNotification');
	Route::post('/notification/mark-seen', 'StudentController@notificationMarkSeen');
	Route::post('/notification/mark-unseen', 'StudentController@notificationMarkUnseen');
	Route::get('/user/get-marked', 'StudentController@getMarkedNotifications');
	Route::get('/user/mark-as-read/{id}', 'StudentController@getUserMarkAsRead');
	Route::get('/student/get-private-notifications/{id}', 'StudentController@getUserPrivateNotifications');
	Route::get('/student/delete-private-notifications/{id}', 'StudentController@deleteUserPrivateNotifications');
	Route::get('/student/getSyllabus','StudentController@getSyllabus');
	Route::get('/student/getSyllabusDetail/{module_id}','StudentController@getSyllabusDetail')->where('module_id','[1-9][0-9]*');
});