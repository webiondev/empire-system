app.register.controller('moduleDetail', ['$scope', '$http','$routeParams','pinesNotifications', '$location', function($scope, $http,$routeParams, pinesNotifications, $location){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.moduleId = ($routeParams.module_id || "");
  $scope.credentials = {};

  console.log("module details start");
  $http({
    method:'get',
    url:base_url+'/student/getSyllabusDetail/'+$scope.moduleId,
  }).success(function(data,status,header,config){
    $scope.moduleDetail = data;

    console.log(JSON.stringify(data));
  }).error(function(data,status,header,config){
    console.log(data);
  });
       

}]);