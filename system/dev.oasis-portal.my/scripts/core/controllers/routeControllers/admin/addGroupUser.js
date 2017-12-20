app.register.controller('addGroupUser', ['$scope', '$http', '$location', 'pinesNotifications', '$window', '$routeParams', function($scope, $http, $location, pinesNotifications, $window, $routeParams){

  var base_url = $("meta[name='base_url']").attr('content');
  var group_id = ($routeParams.group_id || "");

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/usergroup/students',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.students = data;

    }).error(function(data, status){

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  $scope.submit = function(credentials) {

      $data = { 
        user_id: $scope.credentials.student_id,
        group_id: group_id
      };

      $http({
      method: 'post',
      url: base_url + '/usergroup/assign',
      data : $data
      }).
      success(function(data, status, headers, config) {
        
        if(data['success']) {

          $location.path('/admin-browse-groups');
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Student successfully assigned to the group.',
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