app.register.controller('lecturerConsultations', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'timeFactory', function($scope, $http, pinesNotifications, $location, $routeParams, timeFactory){

  //You have not set any meeting at the specified time with the specified lecturer. 
    'use strict';

    //DATE INIT
    $scope.credentials = {};

    $scope.today = function() {
      $scope.credentials.date = new Date();
    };
    $scope.today();

    $scope.clear = function() {
      $scope.credentials.date = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
      return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
    };

    $scope.toggleMin = function() {
      $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function($event) {
      $event.preventDefault();
      $event.stopPropagation();

      $scope.opened = true;
    };

    $scope.dateOptions = {
      formatYear: 'yy',
      startingDay: 1
    };

    $scope.initDate = new Date('2016-15-20');
    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    
    //TIME INIT
    $scope.credentials = timeFactory;
    $scope.credentials.mytime = new Date();

    $scope.hstep = 1;
    $scope.mstep = 30;

    $scope.options = {
      hstep: [1, 2, 3],
      mstep: [1, 5, 10, 15, 25, 30]
    };

    $scope.ismeridian = true;
    $scope.toggleMode = function() {
      $scope.ismeridian = !$scope.ismeridian;
    };

    $scope.update = function() {
      var d = new Date();
      d.setHours(14);
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

    var base_url = $("meta[name='base_url']").attr('content');

    $http({
    method: 'get',
    url: base_url + '/lecturer/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {
      
      $scope.modules = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch module list.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.submit = function(credentials) {

      $scope.credentials.date.setHours($scope.credentials.mytime.getHours());
      $scope.credentials.date.setMinutes($scope.credentials.mytime.getMinutes());
      
      var date = $scope.credentials.date;

      var base_url = $("meta[name='base_url']").attr('content');
    
      $http({
        method: 'post',
        url: base_url + '/lecturer/createslot',
        data: { date: date, lecturer_id: _config.id, module_id: $scope.credentials.module_id  }
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            $location.path('/view-consultations');
            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Consultation slot successfully created.',
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

            $('#error').html('code: ' + status + ' unable to create a new slot.');
            $('#alert').fadeIn(1000).removeClass('hide');
        }); 
        
    };

}]);