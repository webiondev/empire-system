app.register.controller('editTest', ['$scope', '$http',  'pinesNotifications', '$route', '$location', '$routeParams', '$timeout', 'testDetails','SessionService', 'WebService', '$modal', function($scope, $http, pinesNotifications, $route, $location, $routeParams, $timeout, testDetails, SessionService, WebService, $modal){

  var test_id = ($routeParams.test_id || "");
  var base_url = $("meta[name='base_url']").attr('content');

   $scope.test = {};
   window.testid=test_id;
   
  

    $http({
      method: 'get',
      url: base_url + '/lecturer/gettestbyid/' + test_id
      }).success(function(data, status, headers, config) {

        $scope.test = data;

        console.log(JSON.stringify($scope.test));


      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch course modules.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });

  
    $scope.isValid = function(object) {
      return (object !== undefined && object.length > 0);
    };

    $scope.shared = [];
    $scope.shared.mydata = testDetails;
    $scope.shared.mydata.length = 0; //SET TO NULL BETWEEN SESSIONS

    
    var url = base_url + '/lecturer/gettestquestions/' + test_id;
    var shit = 0;

    if(test_id != "") {

        increase = function() {
            shit++;
        }


        var promise = 
          $http.get(url).then(function(response){
          
            if(response.data.length) {
              $scope.shared.mydata.push({test_id,question: response.data[shit]["question"], option_1: response.data[shit]["option_1"], option_2: response.data[shit]["option_2"], option_3: response.data[shit]["option_3"], option_4: response.data[shit]["option_4"], correct_answer: response.data[shit]["correct_answer"], mark: response.data[shit]["mark"]});
              increase();
              window.question=response.data[shit]["question"];
           
            }

        

        
            
        }); //end promise 
        
         
    } 

    

     $scope.delete = function(test_id, size) {

         test_id= window.testid;
         question=window.question;
        
        var modalInstance = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: function($scope, $modalInstance, items) {

            $scope.items = items;
            $scope.ok = function() {
              
                $data= {

                  
                    q: question
               }
            

              console.log(question);

              $http({
              method: 'post',
              url: base_url + '/lecturer/delete_test_q/'+ test_id,
              data : $data
              
              }).
              success(function(data, status, headers, config) {

                //console.log(data['success']);
                if(data['success']) {

                  $route.reload();
                  pinesNotifications.notify({
                  
                    title: 'Success',
                    
                    text: 'Question removed successfully.',
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

                  $('#error').html('code: ' + status);
                  $('#alert').fadeIn(1000).removeClass('hide');
              });

              $modalInstance.close();

            };

          $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
          };
        },
        size: size,
        resolve: {
          items: function() {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function(selectedItem) {
        $scope.selected = selectedItem;
      }, function() {
      });

    };
    

}]);