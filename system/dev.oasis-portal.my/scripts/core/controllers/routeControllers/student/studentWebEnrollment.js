app.register.controller('studentWebEnrollment', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', function($scope, $http, pinesNotifications, $location, $routeParams){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  
  $scope.results = [];
  $scope.course = [];

  $http({
    method: 'get',
    url: base_url + '/student/webresults/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.course = data["course"];
      $scope.results = data["results"];

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch web results.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);