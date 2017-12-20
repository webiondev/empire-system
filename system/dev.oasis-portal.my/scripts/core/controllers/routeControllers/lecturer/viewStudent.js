app.register.controller('viewStudent', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  var student_id = ($routeParams.student_id || "");

  $scope.credentials = {};

  $http({
    
    method: 'get',
    url: base_url + '/student/getfulldetails/' + student_id
    }).success(function(data, status, headers, config) {
      
      $scope.credentials = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch student details.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);