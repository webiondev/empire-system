app.register.controller('createUserGroup', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', 'SessionService', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, SessionService){

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.submit = function(credentials) {

        $data = { 
          name: $scope.credentials.name
        };

        $http({
        method: 'post',
        url: base_url + '/usergroup/create',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/admin-browse-groups');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'User Group successfully created.',
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

            $('#error').html('code: ' + status + ' unable to save data.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });
  };

}]);