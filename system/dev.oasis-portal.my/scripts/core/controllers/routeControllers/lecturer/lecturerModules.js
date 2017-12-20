app.register.controller('lecturerModules', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', function($scope, $http, pinesNotifications, $location, $routeParams){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.modules = [];

  $http({
    method: 'get',
    url: base_url + '/lecturer/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.modules = data;
   

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course modules.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);