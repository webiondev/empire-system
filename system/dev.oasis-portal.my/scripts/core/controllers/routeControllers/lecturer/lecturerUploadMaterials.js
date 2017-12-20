app.register.controller('lecturerUploadMaterials', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', function($scope, $http, pinesNotifications, $location, $routeParams){

  $scope.credentials = [];

  $scope.submit = function(credentials) {

    var base_url = $("meta[name='base_url']").attr('content');
    
    var module_id = ($routeParams.module_id || "");
    var fileName = $('#filename').html();
    var ext = fileName.substr(fileName.lastIndexOf('.') + 1);

     console.log(ext) ;
     console.log(filename) ;
        $data = {
          module_id: module_id,
          name: $scope.credentials.name,
          category : $scope.credentials.category,
          file: $scope.credentials.file,
          ext: ext
        };


      $http({
      method: 'post',
      url: base_url + '/lecturer/upload-materials',
      data: $data,

      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

          
        console.log(data['success']);
        if(data['success']) {

          $location.path('/lecturer-modules');
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'File successfully uploaded.',
            type: 'success',
            hide: true
          });

        } else {

          pinesNotifications.notify({
          
            title: 'Error',
            text: "Unable to upload a file. Avoid special characters in filename",
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