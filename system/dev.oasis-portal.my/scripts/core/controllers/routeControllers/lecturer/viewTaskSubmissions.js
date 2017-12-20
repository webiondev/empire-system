app.register.controller('viewTaskSubmissions', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$window', function($scope, $http, pinesNotifications, $location, $routeParams, $window){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  var task_id = ($routeParams.task_id || "");
  $scope.credentials = {};

  $http({
    
    method: 'get',
    url: base_url + '/tasks/get-by-id/' + task_id
    }).success(function(data, status, headers, config) {
      
      $scope.credentials.task = data;

      $http({
    
        method: 'get',
        url: base_url + '/tasks/get-student-tasks/' + task_id
        }).success(function(data, status, headers, config) {
          
          $scope.credentials.tasks = data;

        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      });

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);