app.register.controller('viewLearningModule', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', function($scope, $http, pinesNotifications, $location, $routeParams, $route){

  var base_url = $("meta[name='base_url']").attr('content');
  var module_id = ($routeParams.module_id || "");
  
  $scope.materials = [];
  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/lecturer/learning-materials/' + module_id
    }).success(function(data, status, headers, config) {

      $scope.materials = data;

      console.log($scope.materials);

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch learning materials.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);