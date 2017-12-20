app.register.controller('bookConsultation', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', 'eventFactory', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout, eventFactory){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};
  $scope.factory = eventFactory;
  $scope.factory.isSelected = false;

  $scope.credentials.note = "Note#: <i>Please select module.</i>";

  $http({
    method: 'get',
    url: base_url + '/student/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.credentials.modules = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch modules data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.credentials.consultations = [];

  $scope.onChange = function(data){
    return data;
  }

  $scope.update = function(data) {

    var id = $('#modules option[value="' + data + '"]').attr('id');

    $http({
    method: 'get',
    url: base_url + '/student/getconsultations/' + $scope.credentials.module_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.consultations = data;
      
      if($scope.credentials.consultations.length) {

        $scope.factory.isSelected = true;
      } 
      else {

        $scope.factory.isSelected = false;
        $scope.credentials.note = "There is no consultation hour set by the lecturer. The lecturer can be contacted by email at <strong>" + $scope.credentials.modules[id].email + "</strong>"; 
      }
 
    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch consultations data.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });

  };


  $scope.book = function(id) {

    $data = {
        consultation_id: id,
        reason: $scope.credentials.reason,
        type: $scope.credentials.appointment_type
    };
    
    $http({
    method: 'post',
    url: base_url + '/student/book',
    data: $data,
    header: {'Content-Type': undefined}
    }).
    success(function(data, status, headers, config) {

      if(data['success']) {

        pinesNotifications.notify({
            
          title: 'Success',
          text: "Slot successfully booked",
          type: 'success',
          hide: true
        });

        $location.path('/my-consultations');

      } else {

        pinesNotifications.notify({
            
          title: 'Error',
          text: data["errors"],
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