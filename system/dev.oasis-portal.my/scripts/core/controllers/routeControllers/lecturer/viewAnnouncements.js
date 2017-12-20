app.register.controller('viewAnnouncements', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};

  $scope.key;
  $scope.delCredentials = {};

  $http({
    method: 'get',
    url: base_url + '/announcement/getall',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.announcements = data;

      console.log($scope.credentials.announcements );

    }).error(function(data, status){

      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
  });


  $scope.destroy = function() {

        $data = {
          id: $scope.delCredentials.id
        };

        $http({
        method: 'post',
        url: base_url + '/announcements/destroy',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {
            
            $scope.credentials.announcements.splice($scope.key, 1);

            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Announcement successfully deleted.',
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

            $('#error').html('code: ' + status + ' unable to delete selected item.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });

        $("#deleteModal").modal("hide"); 
  };

  $scope.setDelAnnouncement = function(index,value){
    $scope.key = index;
    $scope.delCredentials = value;

    $("#deleteMessage").html("Are you sure you want to delete announcement : "+$scope.delCredentials.value);

  };

}]);