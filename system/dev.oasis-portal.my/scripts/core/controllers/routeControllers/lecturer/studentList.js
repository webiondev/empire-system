app.register.controller('studentList', ['$scope', '$http', 'pinesNotifications', '$location', 'WebService', function($scope, $http, pinesNotifications, $location, WebService){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  $scope.user_id = _config.id;
  var base_url = $("meta[name='base_url']").attr('content');

  $http({
  method: 'get',
  url: base_url + '/lecturer/getstudents/' + $scope.user_id
  }).success(function(data, status, headers, config) {
  
    $scope.students = data;

  }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch student list.');
        $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.addFriend = function(id)
  {

    $data = {
      user_id: id 
    };

    WebService.post('/user/add-friend', $data).then(function(data, status, headers, config){

      if(data["success"]) {

        pinesNotifications.notify({
              
          title: 'Success',
          text: data["message"],
          type: 'success',
          hide: true
        });

      } else {

        pinesNotifications.notify({
              
          title: 'Error',
          text: data["message"],
          type: 'error',
          hide: true
        });
      }

    });

  };


}]);