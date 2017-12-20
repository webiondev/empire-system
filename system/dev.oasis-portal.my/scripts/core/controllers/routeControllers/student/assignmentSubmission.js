app.register.controller('assignmentSubmission', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.modules = [];
  $scope.student = [];
  $scope.module_id = 0;
  $scope.loaded = false;

  $http({
    
    method: 'get',
    url: base_url + '/student/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {
      
      $scope.modules = data;
      $scope.getStudentInfo();

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch module list.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.getStudentInfo = function() {

    $http({
    
    method: 'get',
    url: base_url + '/student/getstudentbyid/' + _config.id
    }).success(function(data, status, headers, config) {
      
      $scope.student = data;
      $scope.loaded = true;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch module list.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });

  };

  $scope.credentials = {};

  $scope.submit = function(credentials) {

      var module_id = $scope.module.id;
      var fileName = $('#filename').html();
      var ext = fileName.substr(fileName.lastIndexOf('.') + 1);

      $data = {
        student_id: _config.id,
        module_id: module_id,
        file: $scope.credentials.file,
        filename: fileName,
        ext: ext
      };

      $http({
      method: 'post',
      url: base_url + '/student/submitAssignment',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          $location.path('/student-myunits');
          pinesNotifications.notify({
              
            title: 'Success',
            text: "Assignment successfully submitted.",
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

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };

}]);