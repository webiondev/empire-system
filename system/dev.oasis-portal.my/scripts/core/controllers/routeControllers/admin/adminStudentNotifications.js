app.register.controller('adminStudentNotifications', ['$scope', '$http', '$modal', '$location', 'pinesNotifications', '$route', 'SessionService', 'WebService', '$routeParams', function($scope, $http, $modal, $location, pinesNotifications, $route, SessionService, WebService, $routeParams){
    
    $scope.isValid = function(object) {
      return (object !== undefined && object.length > 0);
    };

    var base_url = $("meta[name='base_url']").attr('content');

    $student_id = $routeParams.student_id;
    $scope.credentials = {};

    $scope.credentials.title = "Personal Notification";

    $scope.credentials.notifications = [];

    $http({
    method: 'get',
    url: base_url + '/student/get-private-notifications/' + $student_id,
    }).
    success(function(data, status, headers, config) {

        console.log('Notifications: ');
        console.log(data);

        if(data["success"]) {

          angular.forEach(data["notifications"], function(value, key){

            $scope.credentials.notifications.push(value);

          });

        }
        
        //$scope.credentials.notifications = data;

    }).
    error(function(data, status, headers, config) {

        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });


    $http({
    method: 'get',
    url: base_url + '/student/getstudentbyid/' + $student_id,
    }).
    success(function(data, status, headers, config) {

        $scope.credentials.name = data.name;

        $scope.credentials.body = `Dear ` + $scope.credentials.name + `, your next login will be suspended due to the following reasons: <br><br>
        - Failing to attent internship<br>
        - Failing to pay the balance of the fees<br><br>

        For furhter clarification, kindly approach the consultant or call
        011-17771896.
        Thank you.
        `;


    }).
    error(function(data, status, headers, config) {

        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.destroy = function(notification_id, key) {

      console.log(notification_id + ' ' + key);
      
      $http({
      method: 'get',
      url: base_url + '/student/delete-private-notifications/' + notification_id.id,
      }).
      success(function(data, status, headers, config) {

          if(data["success"]) {

            $scope.credentials.notifications.splice(key, 1);
           
          }

      }).
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      });

    };

    $scope.submit = function(credentials) {

        var base_url = $("meta[name='base_url']").attr('content');

        $data = {
          user_id: $student_id,
          title : $scope.credentials.title,
          body: $scope.credentials.body
        };

        $http({
        method: 'post',
        url: base_url + '/popup/create',
        data : $data
        }).
        success(function(data, status, headers, config) {

          if(data['success']) {

            $location.path('/admin-browse-users');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Notification successfully created.',
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
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status);
            $('#alert').fadeIn(1000).removeClass('hide');
        });
      };

}]);