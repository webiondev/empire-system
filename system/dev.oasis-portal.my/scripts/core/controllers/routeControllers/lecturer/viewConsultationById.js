app.register.controller('viewConsultationById', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', 'eventFactory', '$modal', 'WebService', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout, eventFactory, $modal, WebService){

    $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
    };

    var base_url = $("meta[name='base_url']").attr('content');
    var consultation_id = ($routeParams.consultation_id || "");

    $scope.credentials = {};
    $scope.credentials.bookings = {};
    $scope.credentials.note = "You have not set any meeting at the specified time with the specified lecturer.";
    $scope.credentials.consultation = {};

    $http({
      method: 'get',
      url: base_url + '/lecturer/view-consultation/' + consultation_id
      }).success(function(data, status, headers, config) {

        $scope.credentials.consultation = data;

      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch modules data.');
        $('#alert').fadeIn(1000).removeClass('hide');
    }).then(WebService.get('/lecturer/consultation-bookings/' + consultation_id)
      .then(function(data, status, headers, config){

        $scope.items = data;

    }));

    $scope.items = {};

    $scope.open = function(name, size) {
      var modalInstance = $modal.open({
        templateUrl: 'BookingList.html',
        controller: function($scope, $modalInstance, items, pinesNotifications, $location) {

          $scope.items = items;
          $scope.student_booked = name;

          $scope.book = function(obj) {
            $data = {
              id: obj.consultation_id,
              student_id: obj.user_id,
              status: 1
            };
        
            $http({
            method: 'post',
            url: base_url + '/lecturer/approve-consultation',
            data: $data,
            header: {'Content-Type': undefined}
            }).
            success(function(data, status, headers, config) {

              if(data['success']) {

                pinesNotifications.notify({
                    
                  title: 'Success',
                  text: "Consultation successfully approved",
                  type: 'success',
                  hide: true
                });

                $modalInstance.close();
                $location.path('/view-consultations');

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

    };

}]);