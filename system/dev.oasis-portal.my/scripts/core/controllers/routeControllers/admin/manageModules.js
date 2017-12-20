app.register.controller('manageModules', ['$scope', '$http', '$modal', '$location', 'pinesNotifications', '$route', 'SessionService', 'WebService', function($scope, $http, $modal, $location, pinesNotifications, $route, SessionService, WebService){
    
    console.log("manage modules controller start..");
    var base_url = $("meta[name='base_url']").attr('content');
    $scope.modules={};

    console.log("before request");
    
    $http({
    method: 'get',
    url: base_url + '/module/getmodules'
    }).success(function(data, status, headers, config) {

     console.log("success request");
      
      $scope.modules = data;

    console.log(JSON.stringify($scope.modules));

    }).error(function(data, status){
    
    console.log("error request");
      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
    });

    console.log("end of request line");



      $scope.open = function(code, size) {

        

        var modalInstance = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: function($scope, $modalInstance, items) {

            $scope.items = items;
            $scope.ok = function() {
              
             
              $data = {
               id: code
              };

              $http({
              method: 'post',
              url: base_url + '/module/delete',
              data : $data
              
              }).
              success(function(data, status, headers, config) {

                if(data['success']) {

                  $route.reload();
                  pinesNotifications.notify({
                  
                    title: 'Success',
                    
                    text: 'Module removed successfully.',
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


    // $scope.lecOpen = function(lecturer, size) {

        

    //     var modalInstance = $modal.open({
    //       templateUrl: 'myModalContent1.html',
    //       controller: function($scope, $modalInstance, items) {

    //         $scope.items = items;
    //         $scope.ok = function() {
              
             
    //           $data = {
    //            id: lecturer
    //           };

    //           $http({
    //           method: 'post',
    //           url: base_url + '/module/deleteLecturer',
    //           data : $data
              
    //           }).
    //           success(function(data, status, headers, config) {

    //             if(data['success']) {

    //               $route.reload();
    //               pinesNotifications.notify({
                  
    //                 title: 'Success',
                    
    //                 text: 'Lecturers removed successfully.',
    //                 type: 'success',
    //                 hide: true
    //               });

    //             } else {

    //               pinesNotifications.notify({
                  
    //                 title: 'Error',
    //                 text: data['errors'],
    //                 type: 'error',
    //                 hide: true
    //               });
    //             }
    //           }).
    //           error(function(data, status, headers, config) {

    //               $('#error').html('code: ' + status);
    //               $('#alert').fadeIn(1000).removeClass('hide');
    //           });

    //           $modalInstance.close();

    //         };

    //       $scope.cancel = function() {
    //         $modalInstance.dismiss('cancel');
    //       };
    //     },
    //     size: size,
    //     resolve: {
    //       items: function() {
    //         return $scope.items;
    //       }
    //     }
    //   });

    //   modalInstance.result.then(function(selectedItem) {
    //     $scope.selected = selectedItem;
    //   }, function() {
    //   });

    // };

}]);