app.register.controller('viewGroupUsers', ['$scope', '$http', '$location', 'pinesNotifications', '$window', '$routeParams', function($scope, $http, $location, pinesNotifications, $window, $routeParams){

  var base_url = $("meta[name='base_url']").attr('content');
  var group_id = ($routeParams.group_id || "");

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/usergroup/group-students/' + group_id,
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.students = data;

    }).error(function(data, status){

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.openDel = function(userId){
    $scope.student_id = userId;
  };

  $scope.delete = function(){

    $data = {
      group_id:group_id,
      student_id:$scope.student_id
    };
    $http({
      method:'post',
      url:base_url+'/usergroup/remove-student',
      data:$data
    }).success(function(data,status,headers,config){
      $('#modalDelete').modal('hide')
      if(data['success']){
        $location.path('admin-browse-groups');
            pinesNotifications.notify({
              title: 'Success',
              text: 'Students removed from usergroup',
              type: 'success',
              hide: true
            });

      }else{
        pinesNotifications.notify({
              title: 'Failed',
              text: 'Unable to remove student from usergroup',
              type: 'failed',
              hide: true
            });
      }
    }).error(function(data,status,headers,config){
      console.log(data);
    });
  };

}]);

