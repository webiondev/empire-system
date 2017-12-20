app.register.controller('startExam', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'examFactory', 'timerFactory', '$route', '$modal', 'examFactoryFillUp', 'examFactoryEssay', function($scope, $http, pinesNotifications, $location, $routeParams, examFactory, timerFactory, $route, $modal, examFactoryFillUp, examFactoryEssay) {

  $scope.isEssay = false;
  $scope.isMultiple = false;
  $scope.isFillup = false;

  $scope.exam_type = [];
  $scope.contentloaded = false;

  $scope.Type = function(data) {

      switch(data) {

        case "Essay": $scope.isEssay = true; return "Essay"; break;
        case "Multiple Choice": $scope.isMultiple = true; return "Multiple Choice"; break;
        case "Fill Answer": $scope.isFillup = true; return "Fill Answer"; break;

        default: break;
      }
  }


  var base_url = $("meta[name='base_url']").attr('content');
  var exam_id = ($routeParams.exam_id || "");

  $scope.credentials = {};
  $scope.valid = false;
  $scope.submited = null;
  
  $scope.duration = 0;
  $scope.exam_type = [];
  $scope.items = [];

  $scope.credentials.questions = [];
  $scope.resultsmc = [];
  var url = base_url + '/student/getResultsMCbyId/' + _config.id;


  $http({
    method: 'get',
    url: base_url + '/student/getexambyid/' + exam_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.exams = data;
      $scope.duration = $scope.credentials.exams.duration;
      
      var res = $scope.duration.split(":");
      var hours = res[0] * 60 * 60;
      var minutes = res[1] * 60;

      $scope.credentials.examduration = hours/60/60 + " hours, " + minutes/60 + " minutes";
      
      $scope.duration = hours + minutes;
      $scope.exam_type = $scope.Type($scope.credentials.exams.type);
      
      $scope.contentloaded = true;
      
      //LOAD EXAM
      $scope.loadExam();  
      $scope.valid = $scope.isValidExam();
      console.log('valid=' + $scope.valid);
      if($scope.valid) {
        $scope.items.name = $scope.credentials.exams.name;
        $scope.loadQuestions($scope.exam_type);
      } 
      
    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch exam data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.isValidExam = function() {
      
      if(($scope.credentials.exams.current_time >= $scope.credentials.exams.startdate) && ($scope.credentials.exams.current_time <= $scope.credentials.exams.enddate)){
        return true;
      } else {
        return false;
      }
  }

  function Countdown(options) {

    var timer,
    instance = this,
    seconds = options.seconds || 10,
    updateStatus = options.onUpdateStatus || function () {},
    counterEnd = options.onCounterEnd || function () {};

    function decrementCounter() {
      updateStatus(seconds);
      if (seconds === 0) {
        counterEnd();
        instance.stop();
      }
      seconds--;
    }

    this.start = function () {
      clearInterval(timer);
      timer = 0;
      seconds = options.seconds;
      minutes = options.minutes;
      timer = setInterval(decrementCounter, 1000);
    };

    this.stop = function () {
      clearInterval(timer);
    };
  }

  
  String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time    = hours+':'+minutes+':'+seconds;
    return time;
  };

  $scope.credentials.timer = timerFactory;

  //LOAD QUESTIONS BASED ON TYPE  
  $scope.loadQuestions = function(type) 
  {
    switch(type) {

      case "Essay": 

      $http({
        method: 'get',
        url: base_url + '/lecturer/getessayquestions/' + exam_id
        }).success(function(data, status, headers, config) {

          $scope.credentials.questions = data;

        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to fetch exam data.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });


      break;

      case "Multiple Choice":

      $http({
        method: 'get',
        url: base_url + '/student/get-mcquestions/' + exam_id
        }).success(function(data, status, headers, config) {

          $scope.credentials.questions = data;

        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to fetch exam data.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });

      break;
      case "Fill Answer": 

      $http({
        method: 'get',
        url: base_url + '/lecturer/getfillupquestions/' + exam_id
        }).success(function(data, status, headers, config) {

          $scope.credentials.questions = data;

        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to fetch exam data.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });

      break;
    
      default: break;
    }

  };


  //EXAM LOAD
  angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null 
  }

  $scope.resultsmc = [];
  $scope.loadExam = function() {

    //CHECK EXAM TYPE [!!!]
    switch($scope.credentials.exams.type) {

        case "Essay": 
        
        examFactoryEssay.async().then(function(d) {
        
        $scope.resultsmc = d;
        console.log($scope.resultsmc);

        if(!angular.isUndefinedOrNull($scope.resultsmc)) {
          
          $('#checkup').removeClass('ng-hide');

        }

        if(!angular.isUndefinedOrNull($scope.resultsmc) && !$scope.resultsmc[0].submited) {

            $scope.submited = 0;
            $('#checkup').hide();

            var dt  = $scope.resultsmc.current_time.split(/-|\s|:/);//$scope.resultsmc.current_time.split(/\-|\s/);
            current = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);
            
            dt = $scope.resultsmc[0].started_time.split(/-|\s|:/);//$scope.resultsmc[0].started_time.split(/\-|\s/);
            started = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);

            var dif = current.getTime() - started.getTime();
            var secondspast = dif / 1000;

            if($scope.duration > secondspast) {
              
              var myCounter = new Countdown({  
              seconds: $scope.duration-secondspast,  
              onUpdateStatus: function(sec){

              $scope.$apply(function() {
                $scope.credentials.timer = "Estimated time: " + sec.toString().toHHMMSS();
              });

              },
           
              onCounterEnd: function(){ alert('counter ended!');} 
              });

              myCounter.start();

              $('panel.exam').removeClass('exam');
              $('panel.exam').removeClass('ng-hide');

            } else {

              //post results [!!!]
              //$route.reload();
              //console.log('reloaded');
              $scope.valid = false;
            }

          } else {

            //console.log('exam is submitted:' + $scope.resultsmc[0].submited);
            $scope.valid = false;

            //alert('2');
          }

          });



        break;
        
        case "Multiple Choice": 

        examFactory.async().then(function(d) {
        
        $scope.resultsmc = d;
        console.log($scope.resultsmc);

        if(!angular.isUndefinedOrNull($scope.resultsmc)) {
          
          $('#checkup').removeClass('ng-hide');
        }

        if(!angular.isUndefinedOrNull($scope.resultsmc) && !$scope.resultsmc[0].submited) {

            $scope.submited = 0;
            $('#checkup').hide();

            var dt  = $scope.resultsmc.current_time.split(/-|\s|:/);//$scope.resultsmc.current_time.split(/\-|\s/);
            current = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);
            
            dt = $scope.resultsmc[0].started_time.split(/-|\s|:/);//$scope.resultsmc[0].started_time.split(/\-|\s/);
            started = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);

            var dif = current.getTime() - started.getTime();
            var secondspast = dif / 1000;

            if($scope.duration > secondspast) {
              
              var myCounter = new Countdown({  
              seconds: $scope.duration-secondspast,  
              onUpdateStatus: function(sec){

              $scope.$apply(function() {
                $scope.credentials.timer = "Estimated time: " + sec.toString().toHHMMSS();
              });

              },
           
              onCounterEnd: function(){ alert('counter ended!');} 
              });

              myCounter.start();

              $('panel.exam').removeClass('exam');
              $('panel.exam').removeClass('ng-hide');

            } else {

              //post results [!!!]
              //$route.reload();
              //console.log('reloaded');
              $scope.valid = false;
            }

          } else {

            //console.log('exam is submitted:' + $scope.resultsmc[0].submited);
            $scope.valid = false;

            //alert('2');
          }

          });

        break;
        case "Fill Answer": 

        examFactoryFillUp.async().then(function(d) {
        
        $scope.resultsmc = d;
        console.log($scope.resultsmc);
        
        if(!angular.isUndefinedOrNull($scope.resultsmc)) {
          
          $('#checkup').removeClass('ng-hide');
          
        }

        if(!angular.isUndefinedOrNull($scope.resultsmc) && !$scope.resultsmc[0].submited) {

            $scope.submited = 0;
            $('#checkup').hide();

            var dt  = $scope.resultsmc.current_time.split(/-|\s|:/);//$scope.resultsmc.current_time.split(/\-|\s/);
            current = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);
            
            dt = $scope.resultsmc[0].started_time.split(/-|\s|:/);//$scope.resultsmc[0].started_time.split(/\-|\s/);
            started = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);

            var dif = current.getTime() - started.getTime();
            var secondspast = dif / 1000;

            if($scope.duration > secondspast) {
              
              var myCounter = new Countdown({  
              seconds: $scope.duration-secondspast,  
              onUpdateStatus: function(sec){

              $scope.$apply(function() {
                $scope.credentials.timer = "Estimated time: " + sec.toString().toHHMMSS();
              });

              },
           
              onCounterEnd: function(){ alert('counter ended!');} 
              });

              myCounter.start();

              $('panel.exam').removeClass('exam');
              $('panel.exam').removeClass('ng-hide');

            } else {

              //post results [!!!]
              //$route.reload();
              //console.log('reloaded');
              $scope.valid = false;
            }

          } else {

            //console.log('exam is submitted:' + $scope.resultsmc[0].submited);
            $scope.valid = false;

            //alert('2');
          }

          });

        break;
        default: break;
      }

  };
      
      
    
  //CHECKING EXAM CODE
  $scope.check = function(){
    
    if($scope.credentials.exams.code == $scope.credentials.code) {

      $('#checkup').hide();
      $('panel.exam').removeClass('exam');
      $('panel.exam').removeClass('ng-hide');

      $data = {
        exam_id: $routeParams.exam_id,
        student_id: _config.id,
        started_time: (new Date),
        status: 0
      };


      //ADD SWITCH CASE FOR EXAM TYPE

      switch($scope.credentials.exams.type) {

        case "Essay": 

        $http({
          method: 'post',
          url: base_url + '/postEssay',
          data: $data,
          header: {'Content-Type': undefined}
          }).
          success(function(data, status, headers, config) {

            if(!data['success']) {

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


        break;

        case "Multiple Choice": 

          $http({
          method: 'post',
          url: base_url + '/postResultsMC',
          data: $data,
          header: {'Content-Type': undefined}
          }).
          success(function(data, status, headers, config) {

            if(!data['success']) {

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

        break;
        case "Fill Answer":

          $http({
          method: 'post',
          url: base_url + '/postFillUp',
          data: $data,
          header: {'Content-Type': undefined}
          }).
          success(function(data, status, headers, config) {

            if(!data['success']) {

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

        break;
        default: break;
      }
  

      var myCounter = new Countdown({  
      seconds: $scope.duration,  
      onUpdateStatus: function(sec){

        $scope.$apply(function() {
          $scope.credentials.timer = "Estimated time: " + sec.toString().toHHMMSS();
        });

      },
       
      onCounterEnd: function(){ alert('counter ended!');} 
      });

      myCounter.start();

    } else {


      pinesNotifications.notify({
          
        title: 'Error',
        text: "Wrong Examination Code",
        type: 'error',
        hide: true
      });

    }
  }

  //SUBMIT RESULTS BASED ON TYPE
  $scope.credentials.questions.answer = [];
  $scope.results = function(type) 
  {

    $data = {
      student_id: _config.id,
      exam_id: $routeParams.exam_id,
      answers: $scope.credentials.questions.answer
    };

    switch(type) {

      case "Essay": 

      $http({
      method: 'post',
      url: base_url + '/student/postResultsEssay',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          //$scope.items.marks = data["results"];
          $scope.items.text = "Examination successfully submited.";
          console.log(data);
          $scope.open();

          $location.path('/examination-modules');

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

      break;

      case "Multiple Choice":

      $http({
      method: 'post',
      url: base_url + '/student/postResultsMC',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          $scope.items.text = "Examination successfully submitted.";
          $scope.items.marks = "Results: " + data["results"] + " marks.";
          console.log(data);
          $scope.open();

          $location.path('/examination-modules');

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
      
      break;
      case "Fill Answer": 

      $http({
      method: 'post',
      url: base_url + '/student/postResultsFillUp',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          //$scope.items.marks = data["results"];
          $scope.items.text = "Examination successfully submitted.";
          console.log(data);
          $scope.open();

          $location.path('/examination-modules');

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

      break;
    
      default: break;
    }

  };

  $scope.submit = function(credentials) {
    $scope.results($scope.exam_type);
  };

  $scope.open = function(name, size) {
      var modalInstance = $modal.open({
        templateUrl: 'myModalContent.html',
        controller: function($scope, $modalInstance, items) {

          $scope.items = items;
          $scope.ok = function() {
            $modalInstance.close();
            console.log($scope.items);
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
        $log.info('Modal dismissed at: ' + new Date());
      });
    };

}]);