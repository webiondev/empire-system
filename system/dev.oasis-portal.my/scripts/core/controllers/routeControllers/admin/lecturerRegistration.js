app.register.controller('lecturerRegistration', ['$scope', '$http', '$location', 'pinesNotifications', '$window', function($scope, $http, $location, pinesNotifications, $window){

    $scope.submit = function(credentials) {

            var base_url = $("meta[name='base_url']").attr('content');

            $data = {
              name: $scope.credentials.name,
              email: $scope.credentials.email,
              password: $scope.credentials.password,
              password_confirmation: $scope.credentials.password_confirmation,
              _token: $scope.credentials.token,
            };

            $http({
            method: 'post',
            url: base_url + '/lecturer/register',
            data : $data
            }).
            success(function(data, status, headers, config) {
              
              if(data['success']) {
                
                $window.location.href = "/#/lecturer-details/" + data['user_id'];
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Lecturer successfully registered in a system.',
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