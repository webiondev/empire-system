app.register.controller('viewTests', ['$scope', '$modal', '$http', '$route', 'pinesNotifications', '$location', '$route', '$routeParams', '$timeout', '$modal', function($scope, $modal, $http, $route, pinesNotifications, $location,  $routeParams, $timeout){




  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  var modulecode = ($routeParams.modulecode || "");
    
  $scope.credentials = {};

    

    $http({
      method: 'get',
      url: base_url + '/lecturer/viewtests/' + _config.id
      }).success(function(data, status, headers, config) {

        $scope.credentials.tests = data;
        console.log($scope.credentials.tests);
        console.log($scope.credentials.tests[id]);

      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch test data.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });

     

     $scope.delete= function(modulecode,size){

          var modalInstance = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: function($scope, $modalInstance, items) {

            $scope.items = items;
            $scope.ok = function() {
             
            
              $http({
              method: 'post',
              url: base_url + '/lecturer/delete_test/'+ modulecode,
              //data : $data
              
              }).
              success(function(data, status, headers, config) {

               
                if(data['success']) {

                  $route.reload();
                  pinesNotifications.notify({
                  
                    title: 'Success',
                    
                    text: 'Test removed successfully.',
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

                  $('#error').html('code: ' + status);
                  $('#alert').fadeIn(1000).removeClass('hide');
              });

              $modalInstance.close();

            };

          $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
          };
        },
        size: size,
        resolve: {
          items: function() {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function(selectedItem) {
        $scope.selected = selectedItem;
      }, function() {
      });




     }

}]);