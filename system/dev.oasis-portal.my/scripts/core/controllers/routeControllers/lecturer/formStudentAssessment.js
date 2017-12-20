app.register.controller('formStudentAssessment', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'studentGrades', function($scope, $http, pinesNotifications, $location, $routeParams, studentGrades){

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.resetProducts = function(){
    $scope.shared.splice(0,1); 
  }

  $scope.update = function(id) {
    
    var student = ($routeParams.student_id || "");
    $scope.shared = studentGrades;
    $scope.assessment = [];
    
    $scope.shared.module_id = $scope.module.id;

    $data = {
      id: student,
      module_id: $scope.module.id,
    };
    
    $http({
    method: 'post',
    url: base_url + '/lecturer/getassessment',
    data: $data
    }).success(function(data, status, headers, config) {
   
      $scope.shared.on = true;

      $scope.resetProducts();
      $scope.shared.push({module_code: data[0].code, title: data[0].name, student_id: data[0].student_id, module_id: data[0].module_id, credit_points: data[0].credit_points, mark: data[0].mark, grade: data[0].grade});
      
    }).error(function(data, status, headers, config) {

      pinesNotifications.notify({
      title: 'Error',
      text: "Unable to get module grades: " + status,
      type: 'error',
      hide: true
      }); 
      
    }); 

  };

}]);