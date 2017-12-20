app.register.controller('viewConsultations', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$filter', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $filter){

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };

  var lecturer = _config.id;
  var base_url = $("meta[name='base_url']").attr('content');

  $scope.credentials = {};
  
  $http({
    method: 'get',
    url: base_url + '/lecturer/getconsultations/' + lecturer
    }).success(function(data, status, headers, config) {

      $scope.credentials.consultations = data;

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch consultations.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

    
  $scope.delete = function(index, id) {

    $http({
    method: 'get',
    url: base_url + '/delete-consultation/' + id
    }).success(function(data, status, headers, config) {

      if(data["success"]) {

        $scope.credentials.consultations.splice(index, 1);

        pinesNotifications.notify({
            
          title: 'Success',
          text: 'Consultation successfully deleted.',
          type: 'success',
          hide: true
        });

      } else {

        pinesNotifications.notify({
            
          title: 'Error',
          text: data["errors"],
          type: 'error',
          hide: true
        });
      }
      
    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to delete consultation. Connection error.');
      $('#alert').fadeIn(1000).removeClass('hide');
    });
  };
  
  //Advanced Table Settings

  $scope.filterOptions = {
      filterText: '',
      useExternalFilter: true
    };
    $scope.totalServerItems = 0;
    $scope.pagingOptions = {
      pageSizes: [25, 50, 100],
      pageSize: 25,
      currentPage: 1
    };
    $scope.setPagingData = function(data, page, pageSize) {
      var pagedData = data.slice((page - 1) * pageSize, page * pageSize);
      $scope.myData = pagedData;
      $scope.totalServerItems = data.length;
      if (!$scope.$$phase) {
        $scope.$apply();
      }
    };

    $scope.getPagedDataAsync = function(pageSize, page, searchText) {
      setTimeout(function() {
        var data;
        if (searchText) {
          var ft = searchText.toLowerCase();

          $http.get(base_url + '/lecturer/getconsultations/' + lecturer).success(function(largeLoad) {
            data = largeLoad.filter(function(item) {
              return JSON.stringify(item).toLowerCase().indexOf(ft) !== -1;
            });
            $scope.setPagingData(data, page, pageSize);
          });
        } else {
          $http.get(base_url + '/lecturer/getconsultations/' + lecturer).success(function(largeLoad) {
            $scope.setPagingData(largeLoad, page, pageSize);
          });
        }
      }, 100);
    };

    $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);

    $scope.$watch('pagingOptions', function(newVal, oldVal) {
      if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {
        $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
      }
    }, true);
    $scope.$watch('filterOptions', function(newVal, oldVal) {
      if (newVal !== oldVal) {
        $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
      }
    }, true);

    $scope.gridOptions = {
      data: 'myData',
      enablePaging: false,
      showFooter: true,
      totalServerItems: 'totalServerItems',
      pagingOptions: $scope.pagingOptions,
      filterOptions: $scope.filterOptions,
      multiSelect: false,
      //Hiding ID Column
      columnDefs: [
        {field: 'id', displayName: 'id', visible:false},
        {field:'name', displayName:'Module'},
        {field:'date', displayName:'Appointment Date'},
        {field:'studentname', displayName:'Student Name'},
        {field:'student_id', displayName:'Student ID', visible:false}
      ]
    };

    $scope.view = function() {

      if($scope.gridOptions.ngGrid.config.selectedItems.length) {

        var id = $scope.gridOptions.ngGrid.config.selectedItems[0].id;
        $location.path("/view-consultation/"+id);

      } else {

        pinesNotifications.notify({
              
          title: 'Error',
          text: "Please select consultation first.",
          type: 'error',
          hide: true
        });
      }

    };

    $scope.ind = function(arr, obj){
        for(var i = 0; i < arr.length; i++){
            if(angular.equals(arr[i], obj)){
                return i;
            }
        };
        return -1;
    }

    $scope.remove = function() {
 
      if($scope.gridOptions.ngGrid.config.selectedItems.length) {

        var id = $scope.gridOptions.ngGrid.config.selectedItems[0].id;
        var index = $scope.ind($scope.myData, $scope.gridOptions.ngGrid.config.selectedItems[0]);

        $http({
        method: 'get',
        url: base_url + '/delete-consultation/' + id
        }).success(function(data, status, headers, config) {

          if(data["success"]) {

            $scope.myData.splice(index, 1);

            pinesNotifications.notify({
                
              title: 'Success',
              text: 'Consultation successfully deleted.',
              type: 'success',
              hide: true
            });

          } else {

            pinesNotifications.notify({
                
              title: 'Error',
              text: data["errors"],
              type: 'error',
              hide: true
            });
          }
          
        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to delete consultation. Connection error.');
          $('#alert').fadeIn(1000).removeClass('hide');
        });

      }  else {

          pinesNotifications.notify({
              
            title: 'Error',
            text: "Please select row that you want to delete.",
            type: 'error',
            hide: true
          });
      }           
    };

}]);