app.register.controller('createAnnouncement', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};
  $scope.credentials.usergroups = [];

  $http({
    method: 'get',
    url: base_url + '/usergroup/all',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.usergroups = data;
      $scope.credentials.usergroups.unshift({id: 0, name: "All"});

    }).error(function(data, status){

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.submit = function(credentials) {

        $data = { 
          type: $scope.credentials.type,
          value: $scope.credentials.value,
          submitted_by: _config.id,
          user_group: $scope.credentials.user_group
        };

        $http({
        method: 'post',
        url: base_url + '/announcement/create',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/view-announcements');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Announcement successfully created.',
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