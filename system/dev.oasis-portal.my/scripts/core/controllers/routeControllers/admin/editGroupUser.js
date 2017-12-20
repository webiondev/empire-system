app.register.controller('editGroup', ['$scope', '$http', '$location', 'pinesNotifications', '$window', '$routeParams', function($scope, $http, $location, pinesNotifications, $window, $routeParams){

  var base_url = $("meta[name='base_url']").attr('content');
  var group_id = ($routeParams.group_id || "");

  $scope.credentials = {};

  $http({
    method:'get',
    url:base_url+'/usergroup/getName/'+group_id
  }).success(function(data,status,headers,config){
    console.log(JSON.stringify(data));
    $scope.credentials = data;
  }).error(function(data,status,headers,config){
    console.log(data);
  });


  $scope.submit = function(credentials) {
    console.log("submit value for : "+credentials.groupName.name);

    $data = {
      group_id:group_id,
      group_name:credentials.groupName.name
    };

    $http({
      method:'post',
      url:base_url+'/usergroup/changeName',
      data:$data
    })
    .success(function(data,status,headers,config){

          if(data['success']) {

            $location.path('/admin-browse-groups');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Successfully change usergroup name.',
              type: 'success',
              hide: true
            });
          } else {

            pinesNotifications.notify({
            
              title: 'Error',
              text: 'Unable to change usergroup name',
              type: 'error',
              hide: true
            });
          } 
    })
    .error(function(data,status,headers,config){
      console.log("error"+data);
    });
  };

}]);