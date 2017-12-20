app.register.controller('viewEssayResults', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

    var base_url = $("meta[name='base_url']").attr('content');

    var student_id = ($routeParams.student_id || "");
    var exam_id = ($routeParams.exam_id || "");

    $scope.credentials = {};
    $scope.credentials.exam_id = exam_id;

    $http({
    method: 'get',
    url: base_url + '/exam/essayresults/' + student_id + '/' + exam_id,
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.results = data;
      $scope.credentials.answers = JSON.parse($scope.credentials.results.answers[0]["results"]);

    }).error(function(data, status){
      console.log("ERROR: " + status);
    });

}]);