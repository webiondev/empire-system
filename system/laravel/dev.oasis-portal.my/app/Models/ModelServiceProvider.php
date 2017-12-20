<?php namespace App\Models;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider {

public function register()
{

    $this->app->booting(function()
    {
        
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        
        $loader->alias('Course', 'App\Models\Course');
        $loader->alias('Module', 'App\Models\Module');
        $loader->alias('CourseModules', 'App\Models\CourseModules');
        $loader->alias('Students', 'App\Models\Students');
        $loader->alias('Fees', 'App\Models\Fees');
        $loader->alias('Assessment', 'App\Models\Assessment');
        $loader->alias('Consultation', 'App\Models\Consultation');
        $loader->alias('ModuleMaterials', 'App\Models\ModuleMaterials');
        $loader->alias('Examination', 'App\Models\Examination');
        $loader->alias('MultipleChoice', 'App\Models\MultipleChoice');
        $loader->alias('ResultsMC', 'App\Models\ResultsMC');
        $loader->alias('Tests', 'App\Models\Tests');
        $loader->alias('TestQuestions', 'App\Models\TestQuestions');
        $loader->alias('TestResults', 'App\Models\TestResults');
        $loader->alias('Assignment', 'App\Models\Assignment');
        $loader->alias('Lecturers', 'App\Models\Lecturers');
        $loader->alias('FillUpQuestions', 'App\Models\FillUpQuestions');
        $loader->alias('ResultsFillUp', 'App\Models\ResultsFillUp');
        $loader->alias('EssayQuestions', 'App\Models\EssayQuestions');
        $loader->alias('ResultsEssay', 'App\Models\ResultsEssay');
        $loader->alias('Announcement', 'App\Models\Announcement');
        $loader->alias('UserGroup', 'App\Models\UserGroup');
        $loader->alias('UsersGroups', 'App\Models\UsersGroups');
        $loader->alias('LecturerMaterials', 'App\Models\LecturerMaterials');
        $loader->alias('Tasks', 'App\Models\Tasks');
        $loader->alias('TasksUpload', 'App\Models\TasksUpload');
        $loader->alias('FriendList', 'App\Models\FriendList');
        $loader->alias('Messages', 'App\Models\Messages');
        $loader->alias('Chat', 'App\Models\Chat');
        $loader->alias('UserChat', 'App\Models\UserChat');
        $loader->alias('Notification', 'App\Models\Notification');
        $loader->alias('NotificationUser', 'App\Models\NotificationUser');
        $loader->alias('ConsultationBookings', 'App\Models\ConsultationBookings');


    });

}


}