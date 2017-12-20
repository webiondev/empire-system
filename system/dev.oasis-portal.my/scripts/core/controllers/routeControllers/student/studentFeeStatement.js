app.register.controller('studentFeeStatement', ['$scope', '$http', 'pinesNotifications', '$location', function($scope, $http, pinesNotifications, $location){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  $scope.user_id = _config.id;
  var base_url = $("meta[name='base_url']").attr('content');

  $http({
      method: 'get',
      url: base_url + '/student/feedetails/' + $scope.user_id
      }).success(function(data, status, headers, config) {
      
        $scope.feedetails = data;

      }).error(function(data, status){
        
        $('#error').html('code: ' + status + ' unable to load data.');
        $('#alert').fadeIn(1000).removeClass('hide');
  });


}]);