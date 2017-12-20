app.register.controller('feeStatement', ['$scope', '$http', '$routeParams', 'pinesNotifications', '$location', 'feeDetails', function($scope, $http, $routeParams, pinesNotifications, $location, feeDetails){

    
    $scope.isValid = function(object) {
      return (object !== undefined && object.length > 0);
    };

    $scope.today = function() {
      $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function() {
      $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
      return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
    };

    $scope.toggleMin = function() {
      $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function($event) {
      $event.preventDefault();
      $event.stopPropagation();

      $scope.opened = true;
    };

    $scope.dateOptions = {
      formatYear: 'yy',
      startingDay: 1
    };

    $scope.initDate = new Date('2016-15-20');
    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];


    //GET STUDENT FEES

    var base_url = $("meta[name='base_url']").attr('content');
    var student_id = ($routeParams.student_id || "");
    
    $scope.shared = [];
    $scope.shared.mydata = feeDetails;
    $scope.shared.mydata.length = 0; //SET TO NULL BETWEEN SESSIONS

    if(student_id != "")
    {

        var url = base_url + '/student/feedetails/' + student_id;

        $http({
        method: 'get',
        url: url
        }).success(function(data, status, headers, config) {

          console.log('data: ' + data.length);

          var log = [];
          angular.forEach(data, function(value, key) {
            $scope.shared.mydata.push({id: data[key]["id"], user_id: data[key]["user_id"], description: data[key]["description"], duedate: data[key]["duedate"], amount_payable: data[key]["amount_payable"], total_collected: data[key]["total_collected"], outstanding: data[key]["outstanding"]});
          }, log);

        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to fetch fee details.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });
        
    }

    $scope.destroy = function(item) {

        $data = {
          id: item.id
        };

        $http({
        method: 'post',
        url: base_url + '/feedetails/destroy',
        data : $data
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            console.log('before: ' + $scope.shared.mydata.length);
            $scope.shared.mydata.splice($scope.shared.mydata.indexOf(item.id), 1);
            console.log('after: ' + $scope.shared.mydata.length);

            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Row successfully deleted.',
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

            $('#error').html('code: ' + status + ' unable to delete fee details.');
            $('#alert').fadeIn(1000).removeClass('hide');
        });
      
      };

}]);