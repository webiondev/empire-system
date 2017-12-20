app.register.controller('adminViewMaterials', ['$scope', '$http', '$location', 'pinesNotifications', '$window', '$routeParams', function($scope, $http, $location, pinesNotifications, $window, $routeParams){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  var module_id = ($routeParams.module_id || "");

  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/admin/getfiles/' + module_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.files = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch module materials.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  $scope.destroy = function(item_id, id) {

        $data = {
          id: id
        };

        $http({
        method: 'post',
        url: base_url + '/lecturer-materials/destroy',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $scope.credentials.files.splice(item_id, 1);

            pinesNotifications.notify({
            
              title: 'Success',
              text: 'File successfully deleted.',
              type: 'success',
              hide: true
            });

          } else {

            pinesNotifications.notify({
                
                  title: 'Error',
                  text: "Unable to delete selected item",
                  type: 'error',
                  hide: true
                });
          } 
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
            $('#alert').fadeIn(1000).removeClass('hide');
        }); 
  };

}]);