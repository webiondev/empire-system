app.register.controller('myTasks', ['$scope', '$http', 'pinesNotifications', '$location', function($scope, $http, pinesNotifications, $location){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};

  $http({
      method: 'get',
      url: base_url + '/student/get-my-tasks/' + _config.id
      }).success(function(data, status, headers, config) {
      
        $scope.credentials.tasks = data;

      }).error(function(data, status){
        
        $('#error').html('code: ' + status + ' unable to load data.');
        $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);