app.register.controller('createTask', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$window', function($scope, $http, pinesNotifications, $location, $routeParams, $window){

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

    var base_url = $("meta[name='base_url']").attr('content');
    $scope.credentials = {};
    

    $http({
      method: 'get',
      url: base_url + '/usergroup/all'
      }).success(function(data, status, headers, config) {

        $scope.credentials.usergroups = data;
        
      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.submit = function(credentials) {

      var fileName = $('#filename').html();
      var ext = fileName.substr(fileName.lastIndexOf('.') + 1);

      $data = {
          lecturer_id: _config.id,
          title: $scope.credentials.title,
          description: $scope.credentials.description,
          group_id : $scope.credentials.group_id,
          duedate: $scope.credentials.date,
          file: $scope.credentials.file,
          filename: fileName,
          ext: ext
      };

      
      var base_url = $("meta[name='base_url']").attr('content');
       


      $http({
      method: 'post',
      url: base_url + '/task/post-task',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

         

          $location.path('/view-tasks');
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Task successfully created.',
            type: 'success',
            hide: true
          });

        } else {

          pinesNotifications.notify({
          
            title: 'Error',
            text: "Unable to create a task. File already exists",
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