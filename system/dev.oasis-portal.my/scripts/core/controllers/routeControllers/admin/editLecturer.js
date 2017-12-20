//NOT FINISHED GET
app.register.controller('editLecturer', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$window', function($scope, $http, pinesNotifications, $location, $routeParams, $window){

  var base_url = $("meta[name='base_url']").attr('content');
  var lecturer_id = ($routeParams.lecturer_id || "");
  console.log('id for the lecturer : '+lecturer_id);
  $scope.credentials = {};

  $http({
    
    method: 'get',
    url: base_url + '/lecturer/getdetails/' +lecturer_id,
    }).success(function(data, status, headers, config) {
       
      $scope.credentials.address = data[0].address;
      $scope.credentials.phone = data[0].phone;
      $scope.credentials.id = data[0].user_id;
      $scope.credentials.address_id = data[0].id;

      $scope.credentials.name = data[1][0].name;
      $scope.credentials.email = data[1][0].email;

      // console.log(data);
    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });

$scope.submit = function(credentials){

  $data = {
      user_id: credentials.id,
      user_name: credentials.name,
      user_email: credentials.email,
      user_password: credentials.password,
      user_password_confirmation : credentials.password_confirmation,
      address_id : credentials.address_id,
      user_address:credentials.address,
      user_phone_no:credentials.phone,
      _token:credentials.token
    };

  $http({
    method: 'post',
    url: base_url + '/lecturer/updateInfo',
    data:$data
  }).success(function(data,status,headers,config){

     if(data['success']) {

        $location.path('/admin-browse-lecturers');
        pinesNotifications.notify({
        
          title: 'Success',
          text: 'lecturer information updated',
          type: 'success',
          hide: true
        });
      } else {

        pinesNotifications.notify({
            
          title: 'Error',
          text: data["errors"],
          type: 'error',
          hide: true
        });
      }

  }).error(function(data,status,headers,config){

    $('#error').html('code: ' + status);
    $('#alert').fadeIn(1000).removeClass('hide');
  });

};

}]);