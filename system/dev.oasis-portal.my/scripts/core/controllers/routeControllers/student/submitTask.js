app.register.controller('submitTask', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'dateFilter', function($scope, $http, pinesNotifications, $location, $routeParams, dateFilter){

  var task_id = ($routeParams.task_id || "");
  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};

  $http({
      method: 'get',
      url: base_url + '/tasks/get-task-by-id/' + task_id
      }).success(function(data, status, headers, config) {
      
        $scope.credentials.task = dateFilter(data["duedate"], 'yyyy-MM-dd');

      }).error(function(data, status){
        
        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.submit = function(credentials) {

      var fileName = $('#filename').html();
      var ext = fileName.substr(fileName.lastIndexOf('.') + 1);

      $data = {
          user_id: _config.id,
          task_id: task_id,
          file: $scope.credentials.file,
          filename: fileName,
          ext: ext
      };

      $http({
      method: 'post',
      url: base_url + '/task/upload-task',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {


        if(data['success']) {

          $location.path('/my-tasks');
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Task successfully uploaded.',
            type: 'success',
            hide: true
          });

        } else {


          pinesNotifications.notify({

           
            title: 'Error',
            text: data['message'],//"Unable to uploaded a task",
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