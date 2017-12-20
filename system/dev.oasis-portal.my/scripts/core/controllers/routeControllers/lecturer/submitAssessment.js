app.register.controller('submitAssessment', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'studentGrades', function($scope, $http, pinesNotifications, $location, $routeParams, studentGrades){

  $scope.shared.module_id = 0;

  $scope.details = function(module) {
    
    $scope.shared.student_id = ($routeParams.student_id || "");
    $scope.shared.module_id = module;

    $location.path('/add-assessment/' + $scope.shared.student_id);
  }

  $scope.edit = function(module) {
    
    $scope.shared.student_id = ($routeParams.student_id || "");
    $scope.shared.module_id = module;

    $location.path('/edit-assessment/' + $scope.shared.student_id);
  }

}]);