app.register.controller('examinationModules', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', function($scope, $http, pinesNotifications, $location, $routeParams){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/student/get-examinations/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.credentials.exams = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch exam data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);