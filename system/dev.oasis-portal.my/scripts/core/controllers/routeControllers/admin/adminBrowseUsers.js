app.register.controller('adminBrowseUsers', ['$scope', '$http', '$modal', '$location', 'pinesNotifications', '$route', 'SessionService', 'WebService', function($scope, $http, $modal, $location, pinesNotifications, $route, SessionService, WebService){
    
    var base_url = $("meta[name='base_url']").attr('content');
    $scope.students = {};

    $http({
    method: 'get',
    url: base_url + '/browseStudents'
    }).success(function(data, status, headers, config) {
    
      $scope.students = data;
    
    }).error(function(data, status){
        
        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });


    $scope.lock = function(user_id, size) {

        var modalInstance = $modal.open({
        templateUrl: 'myModalContent_lock.html',

        controller: function($scope, $modalInstance, items) {

          $scope.items = items;
          $scope.ok = function() {

            $data = {
              user_id: user_id
            };
        
        $http({
        method: 'post',
        url: base_url + '/admin/lockstudent', //+ user_id,
        data: $data
        }).
        success(function(data, status, headers, config) {

            if(data['success'] && data ['stat']=='unlock') {

                $route.reload();
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Student account successfully unlocked.',
                  type: 'success',
                  hide: true
                });

              } 

              else if(data['success'] && data ['stat']=='lock') {

                $route.reload();
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Student account successfully locked.',
                  type: 'success',
                  hide: true
                });



              }




               else {

                pinesNotifications.notify({
                
                  title: 'Error',
                  text: 'Unable to lock student account due to unknown error',
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

    $scope.open = function(name, size) {
      var modalInstance = $modal.open({
        templateUrl: 'myModalContent.html',
        controller: function($scope, $modalInstance, items) {

          $scope.items = items;
          $scope.ok = function() {

            $data = {
              user_id: name
            };

            $http({
            method: 'post',
            url: base_url + '/student/delete',
            data : $data
            }).
            success(function(data, status, headers, config) {

              if(data['success']) {

                $route.reload();
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Student successfully deleted.',
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

    }; 
  }]);