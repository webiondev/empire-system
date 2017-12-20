app.register.controller('assignmentsList', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');

  $http({
    method: 'get',
    url: base_url + '/lecturer/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.modules = data;
      console.log($scope.modules);

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course modules.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.credentials = {};
  $scope.data = { selected: false };

  $scope.toggle = function () {
      $scope.data.selected = !$scope.data.selected;
  };

  $scope.loadAssignments = function(){

    $scope.data.selected = true;

    $http({
    method: 'get',
    url: base_url + '/lecturer/getmoduleassignments/' + $scope.credentials.module_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.assignments = data;
      console.log($scope.credentials.assignments);

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch assignments.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });
  };

  $scope.destroy = function(index, id) {

      $data = {
        id: id
      };

      $http({
      method: 'post',
      url: base_url + '/assignments/destroy',
      data : $data
      }).
      success(function(data, status, headers, config) {
        
        if(data['success']) {
          
          $scope.credentials.assignments.splice(index, 1);

          pinesNotifications.notify({
          
            title: 'Success',
            text: 'File successfully deleted.',
            type: 'success',
            hide: true
          });

        } else {

          pinesNotifications.notify({
              
                title: 'Error',
                text: "Unable to delete selected item",
                type: 'error',
                hide: true
              });
        } 
      }).
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to delete selected file.');
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };

}]);