angular
  .module('theme.core.notifications_controller', [])
  .controller('NotificationsController', ['$scope', '$filter', 'WebService', '$localStorage', '$http', '$modal', 'pinesNotifications', '$bootbox', '$location', function($scope, $filter, WebService, $localStorage, $http, $modal, pinesNotifications, $bootbox, $location) {
    'use strict';
    

    // LOAD PERSONAL NOTIFICATIONS

    var base_url = $("meta[name='base_url']").attr('content');

    $http({
      method: 'get',
      url: base_url + '/user/get-pnotifications'
      }).success(function(data, status, headers, config) {

        console.log('Loading Personal Notifications:');
        console.log(data);

        if(data["success"]) {
          
          var name = "";
          var size = "";

          angular.forEach(data["data"], function(value, key) {
            console.log(value);
          });

          if(data["data"] != null){
            var notificationTitle = data["data"].title;
            var notificationBody = data["data"].body;
            var userId = data["data"].user_id;
          
          $bootbox.dialog({
            message: notificationBody,
            title: notificationTitle,
            onEscape: false,
            closeButton: false,
            size: 'large',
            buttons: {

              danger: {
                  label: 'I\'m acknowledged.',
                  className: 'btn-danger',
                  callback: function() {

                    // alert('uh oh, look out!');
                    var base_url = $("meta[name='base_url']").attr('content');

                    $http({
                    method: 'get',
                    url: base_url + '/user/mark-as-read/' + userId
                    }).success(function(data, status, headers, config) {

                        if(data["success"]) {

                          $location.path('/logout');

                        } else {

                          alert('Please check your internet connection and try again.');
                        }
                        

                    }).error(function(data, status, headers, config) {

                        console.log('Error: ' + status);
                    });

                  }
              }

            }
          });

        }
          // var modalInstance = $modal.open({
          //   templateUrl: 'personalNotifications.html',
          //   controller: function($scope, $modalInstance, items) {

          //     $scope.items = items;

          //     $scope.notificationTitle = notificationTitle;
          //     $scope.notificationBody = notificationTitle;

          //     $scope.ok = function() {

          //       $data = {
          //         user_id: name
          //       };

          //       $http({
          //       method: 'post',
          //       url: base_url + '/student/delete1',
          //       data : $data
          //       }).
          //       success(function(data, status, headers, config) {

          //         if(data['success']) {

          //           $route.reload();
          //           pinesNotifications.notify({
                    
          //             title: 'Success',
          //             text: 'Student successfully deleted.',
          //             type: 'success',
          //             hide: true
          //           });

          //         } else {

          //           pinesNotifications.notify({
                    
          //             title: 'Error',
          //             text: data['errors'],
          //             type: 'error',
          //             hide: true
          //           });
          //         }
          //       }).
          //       error(function(data, status, headers, config) {

          //           $('#error').html('code: ' + status);
          //           $('#alert').fadeIn(1000).removeClass('hide');
          //       });

          //       $modalInstance.close();

          //     };

          //     $scope.cancel = function() {
          //       $modalInstance.dismiss('cancel');
          //     };
          //   },
          //   size: size,
          //   resolve: {
          //     items: function() {
          //       return $scope.items;
          //     }
          //   }
          // });

        } else {
          alert('not success');
        }

      }).error(function(data, status, headers, config) {

        console.log('Error:' + status);
    });



    //Loading Notifications
    $scope.notifications = [];

    WebService.get('/user/load-notifications')
    .then(function(data, status, headers, config){

      var notifications = data;

      WebService.get('/user/get-marked')
      .then(function(data, status, headers, config){
      
        angular.forEach(notifications["data"], function(value, key) {

          var seen = false;
          angular.forEach(data, function(item, key) {
            
            if(item.notification_id == value.id) {
              seen = true;
            }

          });

          $scope.notifications.push({id: value.id, class: value.n_class, text: value.text, iconClasses: value.n_icon, seen: seen});
        });

      });
    });

    $scope.setSeen = function(item, $event) {
      $event.preventDefault();
      $event.stopPropagation();
      item.seen = true;

      WebService.post('/notification/mark-seen', item.id);
    };

    $scope.setUnseen = function(item, $event) {
      $event.preventDefault();
      $event.stopPropagation();
      item.seen = false;

      WebService.post('/notification/mark-unseen', item.id);
    };

    $scope.setSeenAll = function($event) {
      $event.preventDefault();
      $event.stopPropagation();
      angular.forEach($scope.notifications, function(item) {
        item.seen = true;
        WebService.post('/notification/mark-seen', item.id);
      });
    };

    $scope.unseenCount = $filter('filter')($scope.notifications, {
      seen: false
    }).length;

    console.log(  $scope.unseenCount);

    $scope.$watch('notifications', function(notifications) {
      $scope.unseenCount = $filter('filter')(notifications, {
        seen: false
      }).length;
    }, true);
  }]);