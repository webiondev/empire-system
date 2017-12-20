app.register.controller('courseRegistration', ['$scope', '$http', '$location', 'pinesNotifications', function($scope, $http, $location, pinesNotifications) {
      
      $scope.submit = function(credentials) {

        var base_url = $("meta[name='base_url']").attr('content');

        $data = {
          name: $scope.credentials.name,
          description : $scope.credentials.description
        };

        $http({
        method: 'post',
        url: base_url + '/course/register',
        data : $data
        }).
        success(function(data, status, headers, config) {

          if(data['success']) {

            $location.path('/');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Course successfully registered.',
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
}]);