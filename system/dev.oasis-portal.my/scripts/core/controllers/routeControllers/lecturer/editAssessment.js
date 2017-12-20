app.register.controller('editAssessment', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'studentGrades', function($scope, $http, pinesNotifications, $location, $routeParams, studentGrades){


  $scope.shared = studentGrades;
  var student = ($routeParams.student_id || "");
  var module = $scope.shared.module_id;
  var base_url = $("meta[name='base_url']").attr('content');
  
  $http({
    method: 'get',
    url: base_url + '/student/personalinfo/' + student + '/' + module
    }).success(function(data, status, headers, config) {

      $scope.studentinfo = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch student information.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/student/getassessment/' + student + '/' + module
    }).success(function(data, status, headers, config) {

      $scope.grades = data;
      $scope.credentials.credit_points = $scope.grades[0].credit_points;
      $scope.credentials.mark = $scope.grades[0].mark;
      $scope.credentials.grade = $scope.grades[0].grade;
      $scope.credentials.id = $scope.grades[0].id;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch student assessment.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.edit = function(credentials) {

    if(module && student) {

    $data = {

      id: $scope.credentials.id,
      student_id: student,
      module_id: module,
      credit_points: $scope.credentials.credit_points,
      mark: $scope.credentials.mark,
      grade: $scope.credentials.grade,
      _token: $scope.credentials.token,

    }; 
    
    var base_url = $("meta[name='base_url']").attr('content');
    
    $http({
        method: 'post',
        url: base_url + '/student/editassessment',
        data: $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/student-list');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Student assessment successfully updated.',
              type: 'success',
              hide: true
            });

          } else {

            pinesNotifications.notify({
                
                  title: 'Error',
                  text: data['errors'],
                  type: 'error',
                  hide: true
            });
          } 
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' the student assessment already exists.');
            $('#alert').fadeIn(1000).removeClass('hide');
        }); 

  } else {

    alert('module && student:' + module + ' ' + student);
  }

  };

}]);