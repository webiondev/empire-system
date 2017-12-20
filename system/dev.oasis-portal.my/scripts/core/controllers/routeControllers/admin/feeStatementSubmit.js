app.register.controller('feeStatementSubmit', ['$scope', '$http', '$routeParams', 'pinesNotifications', '$location', 'feeDetails', 'dateFilter', function($scope, $http, $routeParams, pinesNotifications, $location, feeDetails, dateFilter){

    //DATE INIT
    $scope.credentials = {};

    $scope.today = function() {
      var date = new Date();
      $scope.dt = dateFilter(date, 'yyyy-MM-dd');
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
  
    $scope.submit = function(credentials) {

        var outstanding = ($scope.credentials.amount_payable - $scope.credentials.total_collected);
        var base_url = $("meta[name='base_url']").attr('content');
        $scope.student_id = ($routeParams.student_id || "");

        var data = {
          'id': $scope.credentials.id,
          'user_id': $scope.student_id,
          'description': $scope.credentials.description,
          'duedate': dateFilter($scope.dt, 'yyyy-MM-dd'),
          'amount_payable': $scope.credentials.amount_payable,
          'total_collected': $scope.credentials.total_collected,
          'outstanding': outstanding
        };

        $scope.shared.mydata = feeDetails;
      
        var callback = function(id) {
          $scope.shared.mydata.push({id: id, user_id: $scope.student_id, description: $scope.credentials.description, duedate: $scope.dt, amount_payable: $scope.credentials.amount_payable, total_collected: $scope.credentials.total_collected, outstanding: outstanding});
        };

        $http({
        method: 'post',
        url: base_url + '/student/postfees',
        data: data
        }).
        success(function(data, status, headers, config) {

          if(data['success']) {

            callback(data.id);

            pinesNotifications.notify({
            
              title: 'Success',
              text: 'Student fee statement successfully added.',
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