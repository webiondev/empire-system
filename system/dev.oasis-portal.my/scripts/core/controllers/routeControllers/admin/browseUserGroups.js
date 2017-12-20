app.register.controller('browseUserGroups', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', 'SessionService', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, SessionService){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/usergroup/all',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.usergroups = data;
      
    }).error(function(data, status){
      
      $('#error').html('code: ' + status + ' unable to obtain data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  $scope.openDel = function (groupId) {
    $scope.groupId = groupId;
  };

  $scope.delete = function() {
    $http({
      method:'get',
      url:base_url+'/usergroup/delete/'+$scope.groupId
    }).success(function(data,status,headers,config){
      if(data['success']){
        location.reload();
        pinesNotifications.notify({    
                  title: 'Success',
                  text: "usergroup successfully deleted.",
                  type: 'success',
                  hide: true
                });
      }else{
        pinesNotifications.notify({           
                  title: 'Filed',
                  text: "Unable to delete usergroup.",
                  type: 'failed',
                  hide: true
                });
      }
    }).error(function(data,status,headers,config){
      console.log("Unable to delete data");
    });
  };

}]);