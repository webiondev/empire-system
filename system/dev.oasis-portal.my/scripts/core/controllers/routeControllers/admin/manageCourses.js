app.register.controller('manageCourses',  ['$scope', '$http', '$modal', '$location', 'pinesNotifications', '$route', 'SessionService', 'WebService', function($scope, $http, $modal, $location, pinesNotifications, $route, SessionService, WebService){
    
    var base_url = $("meta[name='base_url']").attr('content');
     $scope.courses ={};
    $http({
    method: 'get',
    url: base_url + '/course/getcourses'
    }).success(function(data, status, headers, config) {
    
      $scope.courses = data;
    
    }).error(function(data, status){

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
    });



 $scope.open = function(name, size) {

        var modalInstance = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: function($scope, $modalInstance, items) {

            $scope.items = items;
            $scope.ok = function() {
              
             
              $data = {
               id: name
               
              };



              $http({
              method: 'post',
              url: base_url + '/course/delete',
              data : $data
              //data: name;
              }).
              success(function(data, status, headers, config) {

                if(data['success']) {

                  $route.reload();
                  pinesNotifications.notify({
                  
                    title: 'Success',
                    
                    text: 'Course removed Successfully.',
                    type: 'success',
                    hide: true
                  });

                }
               else {

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

    };


}]);