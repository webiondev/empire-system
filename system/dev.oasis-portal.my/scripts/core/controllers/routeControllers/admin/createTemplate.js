app.register.controller('createTemplateController', ['$scope', '$http', '$location', 'pinesNotifications', function($scope, $http, $location, pinesNotifications) {
    
	console.log('DONE');

	$scope.credentials = {};

	$scope.submit = function(credentials) {

      var base_url = $("meta[name='base_url']").attr('content');

      var data = {
        'name': $scope.credentials.name
      };
    
      $http({
      method: 'post',
      url: base_url + '/student/createTemplate',
      data: data
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Template successfully created.',
            type: 'success',
            hide: true
          }); 

          $scope.credentials = {};

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

          $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });
  };

}]);