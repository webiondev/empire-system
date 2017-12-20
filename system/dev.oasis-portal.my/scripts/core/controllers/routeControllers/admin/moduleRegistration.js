app.register.controller('moduleRegistration', ['$scope', '$http', '$location', 'pinesNotifications', function($scope, $http, $location, pinesNotifications) {
      
  var base_url = $("meta[name='base_url']").attr('content');
  
  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  $http({
    method: 'get',
    url: base_url + '/users/getlecturers',
    }).
    success(function(data, status, headers, config) {
      $scope.lecturers = data;
    }).
    error(function(data, status, headers, config) {

        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });

  $scope.submit = function(credentials) {

    $data = {
      name: $scope.credentials.name,
      code: $scope.credentials.code,
      semester: $scope.credentials.semester,
      description : $scope.credentials.description,
      lecturer_id : $scope.credentials.lecturer_id
    };
    
    $http({
    method: 'post',
    url: base_url + '/module/register',
    data : $data
    }).
    success(function(data, status, headers, config) {

      if(data['success']) {

        $location.path('/manage-modules');
        pinesNotifications.notify({
        
          title: 'Success',
          text: 'Module successfully registered.',
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