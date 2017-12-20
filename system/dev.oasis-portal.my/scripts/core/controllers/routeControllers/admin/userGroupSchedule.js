app.register.controller('createTemplateController', ['$scope', '$http', '$location', 'pinesNotifications', function($scope, $http, $location, pinesNotifications) {
    
$scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};

  $http({
    method: 'get',
    url: base_url + '/usergroup/all',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.usergroups = data;
      
    }).error(function(data, status){
      
      $('#error').html('code: ' + status + ' unable to obtain data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

    $http({
    method: 'get',
    url: base_url + '/schedule/getTemplatesList',
    }).
    success(function(data, status, headers, config) {

        $scope.credentials.templates = data;
    }).
    error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to obtain data.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });  


    $scope.submit = function(credentials)
    {

      console.log("template id : ");
      console.log(credentials.template);
      console.log("usergroup : ");
      console.log(credentials.usergroup);

       var data = {
          template_id: credentials.template,
          usergroup_id: credentials.usergroup
        };

        $http({
        method: 'post',
        url: base_url + '/admin/assign-usergroup-schedule',
        data: data
        }).
        success(function(data, status, headers, config) {

          if(data['success']) {

            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Schedule successfully assigned for usergroup.',
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

            $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });

    };

    

}]);