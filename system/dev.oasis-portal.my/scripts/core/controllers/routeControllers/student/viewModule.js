app.register.controller('viewModule', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$theme', '$filter', function($scope, $http, pinesNotifications, $location, $routeParams, $theme, $filter){

  var module_id = ($routeParams.module_id || "");
  var base_url = $("meta[name='base_url']").attr('content');

  $scope.module = [];
  $scope.materials = {};
  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/student/getmodulebyid/' + module_id
    }).success(function(data, status, headers, config) {

      $scope.module = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course module.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $moduleHelper = ["Lectures", "Assignment Resources", "Assessments & Grades", "Video", "Case Study"];
  $moduleError = [];
  $scope.filteredData = [];

  $http({
    method: 'get',
    url: base_url + '/student/learning-materials/' + module_id
    }).success(function(data, status, headers, config) {

      angular.forEach($moduleHelper, function(value, key) {
        
        $scope.filteredData[key] = $filter("getObjectBy")(data, value);
        console.log($scope.filteredData);

      });

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch learning materials.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);