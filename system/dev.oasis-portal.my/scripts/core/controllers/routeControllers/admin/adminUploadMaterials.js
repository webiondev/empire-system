app.register.controller('adminUploadMaterials', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', function($scope, $http, pinesNotifications, $location, $routeParams, $route){

  $scope.credentials = [];

  $scope.submit = function(credentials) {

    var base_url = $("meta[name='base_url']").attr('content');
    
    var module_id = ($routeParams.module_id || "");
    var fileName = $('#filename').html();
    var ext = fileName.substr(fileName.lastIndexOf('.') + 1);

        $data = {
          filename:fileName,
          module_id: module_id,
          name: $scope.credentials.name,
          category : $scope.credentials.category,
          file: $scope.credentials.file,
          ext: ext
        };

      $http({
      method: 'post',
      url: base_url + '/admin/upload-materials',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          $location.path('/system-modules');
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'File successfully uploaded.',
            type: 'success',
            hide: true
          });

        } else {

          pinesNotifications.notify({
          
            title: 'Error',
            text: "Unable to upload a file",
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