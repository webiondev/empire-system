app.register.controller('viewExamResults', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout){

  $scope.isEssay = false;
  $scope.isMultiple = false;
  $scope.isFillup = false;

  $scope.exam_type = [];
  $scope.contentloaded = false;

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  $scope.Type = function(data) {

      switch(data) {

        case "Essay": $scope.isEssay = true; return "Essay"; break;
        case "Multiple Choice": $scope.isMultiple = true; return "Multiple Choice"; break;
        case "Fill Answer": $scope.isFillup = true; return "Fill Answer"; break;

        default: break;
      }
  }


  var base_url = $("meta[name='base_url']").attr('content');
  var exam_id = ($routeParams.exam_id || "");

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/student/getexambyid/' + exam_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.exams = data;
      $scope.exam_type = $scope.Type($scope.credentials.exams.type);
      $scope.loadResults($scope.exam_type);

      $('panel.exam').removeClass('exam');
      $('panel.exam').removeClass('ng-hide');

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch exam data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  //LOAD RESULTS BASED ON TYPE  
  $scope.loadResults = function(type) 
  {
    switch(type) {

      case "Essay":

       $http({
          method: 'get',
          url: base_url + '/student/get-essaystudents/' + exam_id
          }).success(function(data, status, headers, config) {

            $scope.credentials.students = data;

          }).error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to fetch exam data.');
            $('#alert').fadeIn(1000).removeClass('hide');
        }); 

      break;

      case "Multiple Choice":

        $http({
          method: 'get',
          url: base_url + '/student/get-mcresults/' + exam_id
          }).success(function(data, status, headers, config) {

            $scope.credentials.results = data;
            console.log('results: ' + $scope.credentials.results.length);

          }).error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to fetch exam data.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });

      break;
      case "Fill Answer":

        $http({
          method: 'get',
          url: base_url + '/student/get-fillupstudents/' + exam_id
          }).success(function(data, status, headers, config) {

            $scope.credentials.students = data;

          }).error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to fetch exam data.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });

      break;
    
      default: break;
    }

  };

}]);