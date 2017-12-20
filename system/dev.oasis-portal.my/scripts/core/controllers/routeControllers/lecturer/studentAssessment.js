app.register.controller('studentAssessment', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'studentGrades', function($scope, $http, pinesNotifications, $location, $routeParams, studentGrades){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  $scope.isSet = function(data) {
      return (data > 0);
  }

  $scope.resetProducts = function(){
    $scope.shared.splice(0,1); 
  }


  lecturer_id = _config.id;
  var base_url = $("meta[name='base_url']").attr('content');
  $scope.modules = [];
  $scope.module_id = 0;
  $scope.shared = studentGrades;

  $scope.shared.on = false;

  $scope.resetProducts();

  $http({
    
    method: 'get',
    url: base_url + '/lecturer/getmodules/' + lecturer_id
    }).success(function(data, status, headers, config) {
      
      $scope.modules = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch module list.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  var student = ($routeParams.student_id || "");

  $http({
    
    method: 'get',
    url: base_url + '/student/getname/' + student
    }).success(function(data, status, headers, config) {
      
      $scope.student = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch student detailes.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);