app.register.controller('adminEditModule', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$theme', function($scope, $http, pinesNotifications, $location, $routeParams, $theme){

  var base_url = $("meta[name='base_url']").attr('content');
  $module_id = $routeParams.id;
  $scope.credentials = {};

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  $http({
  method: 'get',
  url: base_url + '/student/getmodulebyid/' + $module_id,
  }).
  success(function(data, status, headers, config) {

      $scope.credentials.lecturer_id = data[0]["lecturer_id"];
      $scope.credentials.name = data[0]["name"];
      $scope.credentials.code = data[0]["code"];
      $scope.credentials.semester = data[0]["semester"];
      $scope.credentials.description = data[0]["description"];
      $scope.credentials.lecturersTime = data[0]["lecturer_times"];
      $scope.credentials.projectTime = data[0]["project_times"];
      $scope.credentials.privateStudy = data[0]["private_study_time"];
      $scope.credentials.creditValue = data[0]["credit_value"];
      $scope.credentials.synopsis = data[0]["synopsis"];
      $scope.credentials.objectives = data[0]["objectives"];
      $scope.credentials.outcomes = data[0]["outcomes"];
      $scope.credentials.teachStrategy = data[0]["teaching_strategies"];
    
      $http({
      method: 'get',
      url: base_url + '/users/getlecturers',
      }).
      success(function(data, status, headers, config) {
        $scope.lecturers = data;
      }).
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      });

  $scope.getLearningOutcomes();
  $scope.getAssessmentComponent();
  }).
  error(function(data, status, headers, config) {

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  $scope.submit = function(credentials) {

    $data = {
      id: $module_id,
      name: $scope.credentials.name,
      code: $scope.credentials.code,
      semester: $scope.credentials.semester,
      description : $scope.credentials.description,
      lecturer_id : $scope.credentials.lecturer_id
    };
    
    $http({
    method: 'post',
    url: base_url + '/module/update',
    data : $data
    }).
    success(function(data, status, headers, config) {

      if(data['success']) {

        $location.path('/manage-modules');
        pinesNotifications.notify({
        
          title: 'Success',
          text: 'Module successfully registered.',
          type: 'success',
          hide: true
        });
      } else {

        pinesNotifications.notify({
            
          title: 'Error',
          text: data["errors"],
          type: 'error',
          hide: true
        });
      }
    }).
    error(function(data, status, headers, config) {

        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });

    
  };
  
  $scope.submitInstructional = function(credentials){
    $data = {
      id:$module_id,
      lecturerTimes:$scope.credentials.lecturersTime,
      projectTimes:$scope.credentials.projectTime,
      privateStudy:$scope.credentials.privateStudy,
      creditValue:$scope.credentials.creditValue
    };

    $http({
      method:'post',
      url:base_url+'/module/updateInstructional',
      data:$data
    }).
    success(function(data,status,headers,config){
      
      if(data['success']){
        $location.path('/manage-modules');
        pinesNotifications.notify({
          title: 'Success',
          text: 'Module successfully updated.',
          type: 'success',
          hide: true
        });
      }else{
        pinesNotifications.notify({
          title: 'Success',
          text: 'Unable to update modules',
          type: 'error',
          hide: true
        });
      }
    }).
    error(function(data,status,headers,config){
      console.log(data);
    });

  };

  $scope.submitSynoObj = function(credentials){
    $data = {
      id:$module_id,
      synopsis:$scope.credentials.synopsis,
      objectives:$scope.credentials.objectives
    };

    $http({
      method:'post',
      url:base_url+'/module/updateSynopsisObjectives',
      data:$data
    }).
    success(function(data,status,headers,config){

      if(data['success']){
        $location.path('/manage-modules');
        pinesNotifications.notify({
          title: 'Success',
          text: 'Module successfully updated.',
          type: 'success',
          hide: true
        });
      }else{
        pinesNotifications.notify({
          title: 'Success',
          text: 'Unable to update module',
          type: 'error',
          hide: true
        });
      }
    }).
    error(function(data,status,headers,config){
      console.log(data);
    });
  };

  $scope.submitOutcome = function(credentials){
    $data = {
      id:$module_id,
      learning_outcome:$scope.credentials.outcomes
    };

    $http({
      method:'post',
      url:base_url+'/module/updateLearningOutcome',
      data:$data
    }).
    success(function(data,status,headers,config){

      if(data['success']){
        $location.path('/manage-modules');
        pinesNotifications.notify({
          title: 'Success',
          text: 'Module successfully updated.',
          type: 'success',
          hide: true
        });
      }else{
        pinesNotifications.notify({
          title: 'Success',
          text: 'Unable to update module',
          type: 'error',
          hide: true
        });
      }

    }).
    error(function(data,status,headers,config){
      console.log("error"+data);
    });
  };

  $scope.submitStrategy = function(credentials){
    $data = {
      id:$module_id,
      teachingStrategy:$scope.credentials.teachStrategy
    };

    $http({
      method:'post',
      url:base_url+'/module/updateTeachingStrategies',
      data:$data
    }).
    success(function(data,status,headers,config){
      if(data['success']){
        $location.path('/manage-modules');

        pinesNotifications.notify({
          title: 'Success',
          text: 'Module successfully updated.',
          type: 'success',
          hide: true
        });

      }else{
        pinesNotifications.notify({
          title: 'Success',
          text: 'Unable to update module.',
          type: 'error',
          hide: true
        });
      }
    }).
    error(function(data,status,headers,config) {
      console.log("error"+data);
    });
  };

  $scope.updateAssessment = function(credentials){
    
    $data = {
      module_id:$module_id,
      component:$scope.credentials.assessmentComponent,
      weightage:$scope.credentials.assessmentWeightage,
      dueDate:$scope.credentials.dueDate
    };

    $http({
      method:'post',
      url:base_url+'/module/updateTableAssessment',
      data:$data
    }).
    success(function(data,status,headers,config){
      console.log(data);
      if (data['success']){
        $location.path('/manage-modules');
        pinesNotifications.notify({
          title: 'Success',
          text: 'Module successfully updated.',
          type: 'success',
          hide: true
        });
      }else{
         pinesNotifications.notify({
          title: 'Success',
          text: 'Unable to update module',
          type: 'error',
          hide: true
        });
      }
    }).
    error(function(data,status,headers,config){
      console.log(data);
    });

  };

  $scope.submitTableOutcome = function(credentials){

    $data = {
      module_id:$module_id,
      learning_outcome:$scope.credentials.learningOutcome,
      assessment_criteria:$scope.credentials.assessmentCriteria,
      indicative_content:$scope.credentials.indicativeContent
    };

    $http({
      method: 'post',
      url:base_url+'/module/updateTableOutcome',
      data:$data
    }).
    success(function(data,status,headers,config){
      if($data['success']){
        $location.path('/manage-modules');
        pinesNotifications.notify({
          title: 'Success',
          text: 'Module successfully updated.',
          type: 'success',
          hide: true
        });
      }else{
        pinesNotifications.notify({
          title: 'Success',
          text: 'Unable to update module.',
          type: 'error',
          hide: true
        });
      }
    }).
    error(function(data,status,headers,config){
      console.log(data);
    });
  }

   $scope.getLearningOutcomes = function(){
    $http({
      method: 'get',
      url:base_url+'/module/getLearningOutcomes/'+$module_id
    })
    .success(function(data,status,headers,config){
      console.log(JSON.stringify(data));
      $scope.learningOutcomes = data['_data'];
    })
    .error(function(data,status,headers,config){
      console.log(data);
    });
   }

  $scope.getAssessmentComponent = function(){
    $http({
      method:'get',
      url:base_url+'/module/getAssessmentComponent/'+$module_id
    })
    .success(function(data,status,headers,config){
      console.log(JSON.stringify(data));
      $scope.assessments = data['_data'];
    })
    .error(function(data,status,headers,config){
      console.log(data);
    });
  }

}]);