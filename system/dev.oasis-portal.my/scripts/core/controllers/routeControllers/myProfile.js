app.register.controller('myProfile', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};
  $scope.credentials.avatar = {};

  $http({
    method: 'get',
    url: base_url + '/getProfile'
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.user = data;
    
    }).error(function(data, status){

        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });

  $scope.submit = function(credentials){

    if($scope.credentials.password != $scope.credentials.password_confirmation) {

      pinesNotifications.notify({
          
            title: 'Error',
            text: "Password and password confirmation doesn't match.",
            type: 'error',
            hide: true
      });

    } else {

      $data = {
        id: $scope.credentials.user.id,
        password : $scope.credentials.password
      };

      $http({
      method: 'post',
      url: base_url + '/profile-update',
      data : $data
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          $location.path('/');
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Profile successfully updated.',
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

  }

}]);