app.register.controller('lecturerViewMaterials', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', function($scope, $http, pinesNotifications, $location, $routeParams){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  var module_id = ($routeParams.module_id || "");

  $scope.credentials = {};
  $scope.delCredential = {};
  $scope.key = {};

  $http({
    method: 'get',
    url: base_url + '/lecturer/getfiles/' + module_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.files = data;
      

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course modules.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  $scope.destroy = function() {
        $data = {
          id: $scope.delCredential.item_id
        };

        $http({
        method: 'post',
        url: base_url + '/module-materials/destroy',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {
             window.location.reload(true);
            $scope.credentials.files.splice($scope.delCredential.item_id, 1);

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

            $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });

        $('#deleteModal').modal('hide'); 
  };

  $scope.setDeleteItem = function(key,value){
    $scope.key = key;
    $scope.delCredential = value;

    $("#deleteMessage").html("Are you sure you want to remove "+$scope.delCredential.filename+""+$scope.delCredential.file+" from your module");
  };

}]);