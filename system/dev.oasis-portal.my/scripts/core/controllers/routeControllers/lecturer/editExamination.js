app.register.controller('editExamination', ['$scope', '$http', '$modal', 'pinesNotifications', '$location', '$routeParams', 'multipleChoiceDetails', 'fillUpDetails', 'essayDetails', function($scope, $http, $modal, pinesNotifications, $location, $routeParams, multipleChoiceDetails, fillUpDetails, essayDetails){

  $scope.isEssay = false;
  $scope.isMultiple = false;
  $scope.isFillup = false;

  $scope.Type = function(data) {

      switch(data) {

        case "Essay": return $scope.isEssay = true; break;
        case "Multiple Choice": return $scope.isMultiple = true; break;
        case "Fill Answer": return $scope.isFillup = true; break;

        default: break;
      }
  }

  var exam_id = ($routeParams.exam_id || "");
  var base_url = $("meta[name='base_url']").attr('content');

    $http({
      method: 'get',
      url: base_url + '/lecturer/getexambyid/' + exam_id
      }).success(function(data, status, headers, config) {

        $scope.exam = data;
        $scope.Type($scope.exam.type);

        if($scope.exam.status) {

          $location.path('/view-examinations');
          pinesNotifications.notify({
                
                  title: 'Error',
                  text: "Examination already approved.",
                  type: 'error',
                  hide: true
                });
          

        } else {

          $scope.loadExamForm($scope.exam.type);
        }

      }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch course modules.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });


    $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
    };

    //LOAD FORM BASED ON TYPE
    $scope.shared = [];

    $scope.loadExamForm = function(type) {

      switch(type) {

        case "Essay":

          $scope.shared.mydata = essayDetails;
          $scope.shared.mydata.length = 0; //SET TO NULL BETWEEN SESSIONS

          var url = base_url + '/lecturer/getessayquestions/' + exam_id;
          var shit = 0;

          if(exam_id != "") {

            increase = function() {

                shit++;
            }

            var promise = 
              $http.get(url).then(function(response){

                $scope.shared.mydata.push({question: response.data[shit]["question"], mark: response.data[shit]["mark"]});
                increase();
            });  
          } 

        break;

        case "Multiple Choice":

          $scope.shared.mydata = multipleChoiceDetails;
          $scope.shared.mydata.length = 0; //SET TO NULL BETWEEN SESSIONS

          var url = base_url + '/lecturer/getmultiplechoicequestions/' + exam_id;
          var shit = 0;

          if(exam_id != "") {

            increase = function() {

                shit++;
                console.log('shit:' + shit);
            }

            var promise = 
              $http.get(url).then(function(response){

                $scope.shared.mydata.push({question: response.data[shit]["question"], option_1: response.data[shit]["option_1"], option_2: response.data[shit]["option_2"], option_3: response.data[shit]["option_3"], option_4: response.data[shit]["option_4"], correct_answer: response.data[shit]["correct_answer"], mark: response.data[shit]["mark"]});
                increase();
            });  
          } 

        break;

        case "Fill Answer":

          $scope.shared.mydata = fillUpDetails;
          $scope.shared.mydata.length = 0; //SET TO NULL BETWEEN SESSIONS

          var url = base_url + '/lecturer/getfillupquestions/' + exam_id;
          var shit = 0;

          if(exam_id != "") {

            increase = function() {

                shit++;
            }

            var promise = 
              $http.get(url).then(function(response){

                $scope.shared.mydata.push({question: response.data[shit]["question"], mark: response.data[shit]["mark"]});
                increase();
            });  
          } 

        break;

        default: break;
      }

    };



    //$scope.delete= function(exam_id, question,size){




      //   var modalInstance = $modal.open({
      //     templateUrl: 'myModalContent.html',
      //     controller: function($scope, $modalInstance, items) {

      //       $scope.items = items;
      //       $scope.ok = function() {
              
             
      //         $data = {
      //          id: exam_id;
      //         };

              


      //         $http({
      //         method: 'post',
      //         url: base_url + '/examination/delete_question/',
      //         data : $data
              
      //         }).
      //         success(function(data, status, headers, config) {

      //           if(data['success']) {

      //             $route.reload();
      //             pinesNotifications.notify({
                  
      //               title: 'Success',
                    
      //               text: 'Question removed successfully.',
      //               type: 'success',
      //               hide: true
      //             });

      //           } else {

      //             pinesNotifications.notify({
                  
      //               title: 'Error',
      //               text: data['errors'],
      //               type: 'error',
      //               hide: true
      //             });
      //           }
      //         }).
      //         error(function(data, status, headers, config) {

      //             $('#error').html('code: ' + status);
      //             $('#alert').fadeIn(1000).removeClass('hide');
      //         });

      //         $modalInstance.close();

      //       };

      //     $scope.cancel = function() {
      //       $modalInstance.dismiss('cancel');
      //     };
      //   },
      //   size: size,
      //   resolve: {
      //     items: function() {
      //       return $scope.items;
      //     }
      //   }
      // });

      // modalInstance.result.then(function(selectedItem) {
      //   $scope.selected = selectedItem;
      // }, function() {
      // });


    //};

}]);