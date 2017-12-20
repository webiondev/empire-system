app.register.controller('createTest', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout){

   $scope.credentials = {};

    //TIME INIT
    
    $scope.credentials.mytime = new Date();

    $scope.hstep = 1;
    $scope.mstep = 15;

    $scope.options = {
      hstep: [1, 2, 3],
      mstep: [1, 5, 10, 15, 25, 30]
    };

    $scope.ismeridian = false;
    $scope.toggleMode = function() {
      $scope.ismeridian = !$scope.ismeridian;
    };

    $scope.update = function() {
      var d = new Date();
      d.setHours(2);
      d.setMinutes(0);
      $scope.credentials.mytime = d;
    };

    $scope.changed = function() {
      console.log('Time changed to: ' + $scope.credentials.mytime);
    };

    $scope.clear = function() {
      $scope.credentials.mytime = null;
    };

    $scope.update();


    $scope.isValid = function(object) {
      return (object !== undefined && object.length > 0);
    };

    var base_url = $("meta[name='base_url']").attr('content');

    $http({
      method: 'get',
      url: base_url + '/lecturer/getmodules/' + _config.id
      }).success(function(data, status, headers, config) {

        $scope.credentials.modules = data;

      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch course modules.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });


    $scope.submit = function(credentials) {

      var date = $('#daterange').data('daterangepicker');
      var duration = $scope.credentials.mytime.getHours() + ':' + $scope.credentials.mytime.getMinutes();

      $data = {
        name: $scope.credentials.name,
        module_id: $scope.credentials.module_id,
        startdate: date.startDate,
        enddate: date.endDate,
        duration: duration,
        code: $scope.credentials.code
      };

      $http({
      method: 'post',
      url: base_url + '/lecturer/create-test',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          $location.path('/test-edit/' + data["id"]);
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Test successfully created.',
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
    
    };
}]);