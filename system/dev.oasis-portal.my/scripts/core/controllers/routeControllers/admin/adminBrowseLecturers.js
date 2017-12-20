app.register.controller('adminBrowseLecturers', ['$scope', '$http', 'pinesNotifications', '$routeParams', 'WebService', function($scope, $http, pinesNotifications, $routeParams, WebService){
    
    var base_url = $("meta[name='base_url']").attr('content');
    $scope.credentials = {};
    $scope.modal = {};

    $http({
    method: 'get',
    url: base_url + '/browseLecturers'
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.lecturers = data;
      

    }).error(function(data, status){
      
      $('#error').html('code: ' + status);
      $('#alert').fadeIn(1000).removeClass('hide');
    });

    $scope.delete = function(index, id) {
      
        var base_url = $("meta[name='base_url']").attr('content');

        $http({
          
          method: 'get',
          url: base_url + '/lecturer/delete/' + id
          }).success(function(data, status, headers, config) {
            
            if(data['success']) {

                $scope.credentials.lecturers.splice(index, 1);

                pinesNotifications.notify({
                    
                  title: 'Success',
                  text: "Lecturer successfully deleted.",
                  type: 'success',
                  hide: true
                });

              } else {

                pinesNotifications.notify({
                    
                  title: 'Error',
                  text: "Unable to delete the lecturer",
                  type: 'error',
                  hide: true
                });
              }

          }).error(function(data, status, headers, config) {

            $('#error').html('code: ' + status);
            $('#alert').fadeIn(1000).removeClass('hide');
        });

    };

    $scope.addFriend = function(id)
    {

    $data = {
      user_id: id 
    };

    WebService.post('/user/add-friend', $data).then(function(data, status, headers, config){

      if(data["success"]) {

        pinesNotifications.notify({
              
          title: 'Success',
          text: data["message"],
          type: 'success',
          hide: true
        });

      } else {

        pinesNotifications.notify({
              
          title: 'Error',
          text: data["message"],
          type: 'error',
          hide: true
        });
      }

    });

  };

  $scope.openDeleteModal = function(index, id, name)
  {
    $('#modalContent').html('Are you sure you want to delete '+name);
    $scope.modal.index = index;
    $scope.modal.id = id;
    $scope.modal.name = name;
  };

  $scope.modalDelete = function()
  {
    this.delete($scope.modal.index,$scope.modal.id);
    $('#deleteModal').modal('hide')
  };

}]);