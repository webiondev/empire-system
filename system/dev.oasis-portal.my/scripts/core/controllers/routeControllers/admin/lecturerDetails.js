app.register.controller('lecturerDetails', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

    var base_url = $("meta[name='base_url']").attr('content');

    var lecturer_id = ($routeParams.lecturer_id || "");
    $scope.credentials = {};

    $http({
    method: 'get',
    url: base_url + '/lecturer/getdetails/' + lecturer_id,
    }).success(function(data, status, headers, config) {
    
      $scope.lecturer = data;

      $scope.credentials.address = $scope.lecturer[0].address;
      $scope.credentials.phone = $scope.lecturer[0].phone;

    }).error(function(data, status){
        
      $('#error').html('code: ' + status + ' unable to save data.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.submit = function(credentials) {

        $data = {
          
          user_id: lecturer_id,
          address: $scope.credentials.address,
          phone: $scope.credentials.phone

        };

        $http({
        method: 'post',
        url: base_url + '/lecturer/update',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/admin-browse-lecturers');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Lecturer information successfully updated.',
              type: 'success',
              hide: true
            });
          } else {

            pinesNotifications.notify({
            
              title: 'Error',
              text: data['errors'],
              type: 'error',
              hide: true
            });
          } 
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to save data.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });
      };

}]);