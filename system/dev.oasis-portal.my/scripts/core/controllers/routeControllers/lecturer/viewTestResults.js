app.register.controller('viewTestResults', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'testFactory', 'timerFactory', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, testFactory, timerFactory, $route, $modal){

  $scope.contentloaded = false;

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  var test_id = ($routeParams.test_id || "");

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/student/gettestbyid/' + test_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.tests = data;
      $scope.loadResults();

      $('panel.exam').removeClass('exam ng-hide');
      $('panel.exam').removeClass('ng-hide');

    }).error(function(data, status, headers, config) {
      console.log('1');
      $('#error').html('code: ' + status + ' unable to fetch exam data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.loadResults = function(type) 
  {

    $http({
      method: 'get',
      url: base_url + '/student/get-testresults/' + test_id
      }).success(function(data, status, headers, config) {

        $scope.credentials.results = data;

      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch exam data.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });
 
  };

}]);