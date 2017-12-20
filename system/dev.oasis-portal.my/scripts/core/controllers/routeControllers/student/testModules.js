app.register.controller('testModules', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/student/get-tests/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.credentials.tests = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch test data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);