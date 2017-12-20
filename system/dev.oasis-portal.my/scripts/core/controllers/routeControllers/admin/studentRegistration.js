app.register.controller('studentRegistration', ['$scope', '$http', '$location', 'pinesNotifications', '$window', function($scope, $http, $location, pinesNotifications, $window){

    //var student_id = ($routeParams.student_id || "");
    var base_url = $("meta[name='base_url']").attr('content');

    $scope.credentials = {};

    $scope.credentials.address = "N/A";
    $scope.credentials.phone = "N/A";
    $scope.credentials.semester = "1";

    $scope.submitted = false;

    var password = Math.random().toString(36).slice(-8);
    var random_username = Math.floor(Math.random() * (9999999 - 1000000 + 1)) + 1000000;//Math.random();

    $scope.credentials.email = "R" + random_username + "@oasis-portal.my";
    $scope.credentials.password = password;

    $http({
    method: 'get',
    url: base_url + '/course/getcourses'
    }).success(function(data, status, headers, config) {
    
      $scope.courses = data;
  
    }).error(function(data, status){
      
      $('#error').html('code: ' + status + ' unable to load data.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });


    $scope.submit = function(credentials) {

            var base_url = $("meta[name='base_url']").attr('content');

            $data = {
              
              name: $scope.credentials.name,
              email: $scope.credentials.email,
              password: $scope.credentials.password,
              password_confirmation: $scope.credentials.password,
              _token: $scope.credentials.token,

              course_id: $scope.credentials.course_id,
              semester: $scope.credentials.semester,
              address: $scope.credentials.address,
              phone: $scope.credentials.phone
            };

            $http({
            method: 'post',
            url: base_url + '/student/register',
            data : $data
            }).
            success(function(data, status, headers, config) {
              
              if(data['success']) {
                
                //$window.location.href = "/#/student-details/" + data['user_id'];

                $scope.submitted = true;

                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Student successfully registered in a system.',
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

                $('#error').html('code: ' + status + data + headers);
                $('#alert').fadeIn(1000).removeClass('hide');
            });
        };
}]);