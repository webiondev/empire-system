app.register.controller('addCourseModule', ['$scope', '$http', '$routeParams', 'pinesNotifications', '$location', function($scope, $http, $routeParams, pinesNotifications, $location){

  $scope.course_id = ($routeParams.course_id || "");

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var course_id = $scope.course_id;
  var base_url = $("meta[name='base_url']").attr('content');

  if($scope.course_id != "") {
      
      $http({
      method: 'get',
      url: base_url + '/module/getmodules'
      }).success(function(data, status, headers, config) {
      
        $scope.modules = data;
      
      }).error(function(data, status){
        console.log("ERROR: " + status);
      });
  }


  $scope.submit = function(credentials) {

        $scope.course_id = ($routeParams.course_id || "");
        var base_url = $("meta[name='base_url']").attr('content');

        $data = {
          module_id: $scope.credentials.module_id,
          course_id: $scope.course_id
        };

        $http({
        method: 'post',
        url: base_url + '/course/assignmodule',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/view-course/' + $scope.course_id);
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Module successfully assigned for the course.',
              type: 'success',
              hide: true
            });
          } else {

            alert(data['errors']);
          } 
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });
      };

}]);