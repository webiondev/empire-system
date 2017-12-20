app.register.controller('systemModule', ['$scope', '$http', '$location', 'pinesNotifications', '$window', function($scope, $http, $location, pinesNotifications, $window){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.modules = [];

  $http({
    method: 'get',
    url: base_url + '/system/getmodules'
    }).success(function(data, status, headers, config) {

      $scope.modules = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course modules.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });


}]);