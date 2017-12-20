app.register.controller('viewExaminations', ['$scope', '$http', '$modal', '$location', 'pinesNotifications', '$route', 'SessionService', 'WebService', function($scope, $http, $modal, $location, pinesNotifications, $route, SessionService, WebService){

    $scope.isValid = function(object) {
      return (object !== undefined && object.length > 0);
    };

    $scope.credentials = {};

    var base_url = $("meta[name='base_url']").attr('content');

    $http({
      method: 'get',
      url: base_url + '/lecturer/viewexaminations/' + _config.id
      }).success(function(data, status, headers, config) {

        $scope.credentials.examinations= data;

        console.log(data);
        console.log($scope.credentials.examinations);


      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch course modules.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.activate = function(index, id) {

        $data = {
          id: id
        };

        $http({
        method: 'post',
        url: base_url + '/examinations/change-status',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $scope.credentials.examinations[index]["status"] = 1;

            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Examination status successfully changed.',
              type: 'success',
              hide: true
            });

          } else {

            pinesNotifications.notify({
                
                  title: 'Error',
                  text: "Unable to change the status",
                  type: 'error',
                  hide: true
                });
          } 
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' server error.');
            $('#alert').fadeIn(1000).removeClass('hide');
        }); 

    };

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
            url: base_url + '/lecturer/delete-examination',
            data : $data
            }).
            success(function(data, status, headers, config) {

              if(data['success']) {

                $route.reload();
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Exam successfully deleted.',
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