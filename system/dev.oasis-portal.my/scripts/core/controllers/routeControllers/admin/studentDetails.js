app.register.controller('studentDetails', ['$scope', '$http', '$window', 'pinesNotifications', '$routeParams', '$location', function($scope, $http, $window, pinesNotifications, $routeParams, $location){

    var base_url = $("meta[name='base_url']").attr('content');
    var student_id = ($routeParams.student_id || "");

    $scope.credentials = {};

    $scope.credentials.address = "N/A";
    $scope.credentials.phone = "N/A";

    $http({
    method: 'get',
    url: base_url + '/course/getcourses'
    }).success(function(data, status, headers, config) {
    
      $scope.courses = data;

      $http({
      method: 'get',
      url: base_url + '/student/getdetails/' + student_id,
      }).success(function(data, status, headers, config) {
      
        $scope.student = data;

        $scope.credentials.course_id = $scope.student[0].course_id;
        $scope.credentials.semester = $scope.student[0].semester;
        $scope.credentials.address = $scope.student[0].address;
        $scope.credentials.phone = $scope.student[0].phone;

        $scope.credentials.user_id = $scope.student[0].user_id;

      }).error(function(data, status){
        
        $('#error').html('code: ' + status + ' unable to load data.');
        $('#alert').fadeIn(1000).removeClass('hide');
      });
    
    }).error(function(data, status){
      
      $('#error').html('code: ' + status + ' unable to load data.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.submit = function(credentials) {

        var base_url = $("meta[name='base_url']").attr('content');

        $data = {
          
          user_id: student_id,
          course_id: $scope.credentials.course_id,
          semester: $scope.credentials.semester,
          address: $scope.credentials.address,
          phone: $scope.credentials.phone

        };

        console.log($data);

        $http({
        method: 'post',
        url: base_url + '/student/update',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/admin-browse-users');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Student information successfully updated.',
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

            $('#error').html('code: ' + status + ' unable to save data.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });
      };
}]);