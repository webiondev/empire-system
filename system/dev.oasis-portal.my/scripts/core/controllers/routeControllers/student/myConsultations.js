app.register.controller('myConsultations', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', 'eventFactory', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout, eventFactory){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};
  $scope.credentials.note = "You have not set any meeting at the specified time with the specified lecturer.";

  $http({
    method: 'get',
    url: base_url + '/student/getmyconsultations/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.credentials.consultations = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch modules data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);