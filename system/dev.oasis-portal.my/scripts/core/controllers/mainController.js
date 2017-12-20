
var core_module = angular.module('theme.core.main_controller', ['theme.core.services', 'angular-tour', 'ngStorage']);

core_module.factory('chatUsers', function() {
  
  var chatUsers = [];
  return chatUsers;
});

core_module.factory('userTasks', function() {
  
  var userTasks = [];
  return userTasks;
});


core_module.filter("taskClass", function () {
    
  return function taskClass(percent) {

    switch(true) {

      case (percent <= 25):
      return "primary"
      break;

      case (percent > 25 && percent <= 50):
      return "success"
      break;

      case (percent > 50 && percent <= 75):
      return "orange"
      break;

      case (percent > 75 && percent <= 100):
      return "danger"
      break;

      default: return "danger"; break;
    }

    return percent; 
  };
});

core_module.service('chatMessages', function($http, WebService) {
  
  var base_url = $("meta[name='base_url']").attr('content');
  
  var currentChatUser = null;
  var chatMessages = [];

  this.getCurrentUser = function() {
    return currentChatUser;
  };

  this.setCurrentUser = function(id) {
    currentChatUser = id;
  };

  this.getMessages = function() {
    return chatMessages;
  };

  this.getLastMessage = function() {

    return chatMessages[chatMessages.length - 1];
  };

  this.updatesLoaded = function(updates) {
    chatMessages = chatMessages.concat(updates);
  };

  this.getUpdates = function() {

        var lastMessageId;
        var lastMessage = this.getLastMessage();
        console.log(lastMessage);

        if(! lastMessage) {

          lastMessageId = 0;

          return;

        } else {

          lastMessageId = lastMessage.id;
          
          return WebService.get('/chat/get-updates/' + lastMessageId + '/' + currentChatUser)
          .then(function(data){
          
              angular.forEach(data, function(value, key) {
          
                var messageFrom = (value.user_id != _config.id) ? 'chat-primary' : 'me';
                var avatar = value.avatar ? avalue.avatar : 'original_male.svg';
                
                chatMessages.push({id: value.id, class: messageFrom, avatar: avatar, text: value.text});
              });
          });
        }
  };

  this.loadMessages = function() {

      chatMessages.length = 0;
      WebService.get('/chat/get-messages/'+ currentChatUser).then(function(data){

        angular.forEach(data, function(value, key) {
          
          var messageFrom = (value.user_id != _config.id) ? 'chat-primary' : 'me';
          var avatar = value.avatar ? value.avatar : 'original_male.svg';
          
          chatMessages.push({id: value.id, class: messageFrom, avatar: avatar, text: value.text});
        });

      });

    };
});

core_module.controller('MainController', ['$rootScope', '$scope', '$theme', '$timeout', 'progressLoader', '$location', '$http', 'chatUsers', 'chatMessages', '$interval', 'userTasks', '$filter', '$localStorage', '$window', function($rootScope, $scope, $theme, $timeout, progressLoader, $location, $http, chatUsers, chatMessages, $interval, userTasks, $filter, $localStorage, $window) {
    'use strict';
    // $scope.layoutIsSmallScreen = false;
    $scope.layoutFixedHeader = $theme.get('fixedHeader');
    $scope.layoutPageTransitionStyle = $theme.get('pageTransitionStyle');
    $scope.layoutDropdownTransitionStyle = $theme.get('dropdownTransitionStyle');
    $scope.layoutPageTransitionStyleList = ['bounce',
      'flash',
      'pulse',
      'bounceIn',
      'bounceInDown',
      'bounceInLeft',
      'bounceInRight',
      'bounceInUp',
      'fadeIn',
      'fadeInDown',
      'fadeInDownBig',
      'fadeInLeft',
      'fadeInLeftBig',
      'fadeInRight',
      'fadeInRightBig',
      'fadeInUp',
      'fadeInUpBig',
      'flipInX',
      'flipInY',
      'lightSpeedIn',
      'rotateIn',
      'rotateInDownLeft',
      'rotateInDownRight',
      'rotateInUpLeft',
      'rotateInUpRight',
      'rollIn',
      'zoomIn',
      'zoomInDown',
      'zoomInLeft',
      'zoomInRight',
      'zoomInUp'
    ];

    $scope.layoutLoading = true;


    //$localStorage.clear();
    //First time load - type undefined error
    //$scope.userType = $localStorage.currentUser ? $localStorage.currentUser.type : null;
    //$scope.userType = $localStorage.currentUser.type;
    //if(!$localStorage.currentUser) {
    //if(!$scope.userType) {

      //$localStorage.clear();
      //$window.location.reload();
    //}

    //$localStorage.currentUser; TO HIDE A PANEL ON THE RIGHT 
    // console.log("local value");
    // console.log($localStorage);

    //this function throw error 
    // $scope.isStudent = function() {
    //   if($localStorage.currentUser.type == "Student") {

    //     return true;

    //   } else {

    //     return false;
    //   }
    // };

    $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
    };

    $scope.getLayoutOption = function(key) {
      return $theme.get(key);
    };

    $scope.setNavbarClass = function(classname, $event) {
      $event.preventDefault();
      $event.stopPropagation();
      $theme.set('topNavThemeClass', classname);
    };

    $scope.setSidebarClass = function(classname, $event) {
      $event.preventDefault();
      $event.stopPropagation();
      $theme.set('sidebarThemeClass', classname);
    };

    $scope.$watch('layoutFixedHeader', function(newVal, oldval) {
      if (newVal === undefined || newVal === oldval) {
        return;
      }
      $theme.set('fixedHeader', newVal);
    });
    $scope.$watch('layoutLayoutBoxed', function(newVal, oldval) {
      if (newVal === undefined || newVal === oldval) {
        return;
      }
      $theme.set('layoutBoxed', newVal);
    });
    $scope.$watch('layoutLayoutHorizontal', function(newVal, oldval) {
      if (newVal === undefined || newVal === oldval) {
        return;
      }
      $theme.set('layoutHorizontal', newVal);
    });
    $scope.$watch('layoutPageTransitionStyle', function(newVal) {
      $theme.set('pageTransitionStyle', newVal);
    });
    $scope.$watch('layoutDropdownTransitionStyle', function(newVal) {
      $theme.set('dropdownTransitionStyle', newVal);
    });

    $scope.hideHeaderBar = function() {
      $theme.set('headerBarHidden', true);
    };

    $scope.showHeaderBar = function($event) {
      $event.stopPropagation();
      $theme.set('headerBarHidden', false);
    };

    $scope.toggleLeftBar = function() {
      if ($scope.layoutIsSmallScreen) {
        return $theme.set('leftbarShown', !$theme.get('leftbarShown'));
      }
      $theme.set('leftbarCollapsed', !$theme.get('leftbarCollapsed'));
    };

    /* CHAT */
    var base_url = $("meta[name='base_url']").attr('content');
    $scope.chatters = chatUsers;

    $scope.addUser = function(data) {

      //[#]statuses: online, away, busy
      angular.forEach(data, function(value, key) {
        var avatar = value.avatar ? value.avatar : 'original_male.svg';
        $scope.chatters.push({id: value.id, status: 'online', avatar: avatar, name: value.name});
      });

    };

    $scope.downloadTask = function(data, item) {

      console.log(item);

    };

    $scope.addTask = function(data) {

      var created_at = null;
      var duedate = null;
      var result = null;

      angular.forEach(data, function(value, key) {
       
        created_at = moment(value.created_at);
        duedate = moment(value.duedate);
        result = duedate.diff(created_at, 'days');

        var now = moment();
        var past = now.diff(created_at, 'days');

        var x = (past * 100)/result;
        var task_class = $filter("taskClass")(x);

        $scope.userTasks.push({id: value.id, title: value.title, created_at: value.created_at, duedate: value.duedate, left: x, class: task_class});
      });

    };

    $scope.promise;
    $scope.start = function(chatter_id) {
      
      // stops any running interval to avoid two intervals running at the same time
      $scope.stopInterval();  
      $scope.promise = $interval($scope.update, 3000);
    };
    
    $scope.load = function() {

      chatMessages.loadMessages();
      $scope.messages = chatMessages.getMessages();

    };

    $scope.update = function() {

      var data = chatMessages.getUpdates();

      var applyFn = function () {
       $scope.messages = chatMessages.getMessages();
      };

      if ($scope.$$phase) { // most of the time it is "$digest"
          applyFn();
      } else {
          $scope.$apply(applyFn);
      }
    };

    $scope.stopInterval = function() {

      if (angular.isDefined($scope.promise)) {
        $interval.cancel($scope.promise);
      }
    };

    $scope.$on('$destroy', function() {
      $scope.stopInterval();
    });


    $scope.userTasks = userTasks;

    $scope.toggleRightBar = function() {
      $theme.set('rightbarCollapsed', !$theme.get('rightbarCollapsed'));

      if($theme.settings.rightbarCollapsed) {

        if(!$scope.isValid($scope.chatters)) {

          $http({
          method: 'get',
          url: base_url + '/user/get-friends'
          }).success(function(data, status, headers, config) {

            $scope.addUser(data);

          }).error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to fetch modules data.');
            $('#alert').fadeIn(1000).removeClass('hide');
          });

        }


        if(!$scope.isValid($scope.userTasks) && $scope.isStudent()) {

          $http({
          method: 'get',
          url: base_url + '/user/get-task-progress'
          }).success(function(data, status, headers, config) {

            $scope.addTask(data);

          }).error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to fetch modules data.');
            $('#alert').fadeIn(1000).removeClass('hide');
          });
        }
      }
    };

    $scope.toggleSearchBar = function($event) {
      $event.stopPropagation();
      $event.preventDefault();
      $theme.set('showSmallSearchBar', !$theme.get('showSmallSearchBar'));
    };

    $scope.currentChatterId = null;
    $scope.hideChatBox = function() {
      $theme.set('showChatBox', false);
    };

    var chatBox = angular.element(document.querySelector('#chat-box'));

    $scope.$watch(function() {
      return chatBox.attr('class'); }, 
      function(newValue){

        if(!$theme.settings.showChatBox) {
          $scope.stopInterval();
       }

    });

    $scope.messages = [];
    $scope.toggleChatBox = function(chatter, $event) {

      $event.preventDefault();
      console.log($scope.messages);

      if ($scope.currentChatterId === chatter.id) {
        $theme.set('showChatBox', !$theme.get('showChatBox'));
      } else {
        $theme.set('showChatBox', true);
      }

      if($theme.settings.showChatBox) {

        $scope.currentChatterId = chatter.id;
        $scope.currentChatterName = chatter.name;

        //LOADING MESSAGES WHEN WINDOW IS OPEN
        chatMessages.setCurrentUser(chatter.id); 
        $scope.load();

        //Interval update
        $scope.start();
      }
      
    };

    $scope.hideChatBox = function() {
      $theme.set('showChatBox', false);
    };

    $scope.$on('themeEvent:maxWidth767', function(event, newVal) {
      $timeout(function() {
        $scope.layoutIsSmallScreen = newVal;
        if (!newVal) {
          $theme.set('leftbarShown', false);
        } else {
          $theme.set('leftbarCollapsed', false);
        }
      });
    });
    $scope.$on('themeEvent:changed:fixedHeader', function(event, newVal) {
      $scope.layoutFixedHeader = newVal;
    });
    $scope.$on('themeEvent:changed:layoutHorizontal', function(event, newVal) {
      $scope.layoutLayoutHorizontal = newVal;
    });
    $scope.$on('themeEvent:changed:layoutBoxed', function(event, newVal) {
      $scope.layoutLayoutBoxed = newVal;
    });

    // there are better ways to do this, e.g. using a dedicated service
    // but for the purposes of this demo this will do :P
    $scope.isLoggedIn = true;
    $scope.logOut = function() {
      $scope.isLoggedIn = false;
    };
    $scope.logIn = function() {
      $scope.isLoggedIn = true;
    };

    $scope.rightbarAccordionsShowOne = false;
    $scope.rightbarAccordions = [{
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }, {
      open: true
    }];

    $scope.$on('$routeChangeStart', function() {
      if ($location.path() === '') {
        return $location.path('/');
      }

      progressLoader.start();
      progressLoader.set(50);
    });
    
    $scope.$on('$routeChangeSuccess', function() {
      progressLoader.end();
      if ($scope.layoutLoading) {
        $scope.layoutLoading = false;
      }
    });

    $scope.type = _config;
    switch($scope.type.user) {
      case 'Admin': 

      $scope.menu = $theme.AdminMenu;

      break;
      case 'Lecturer': 

      $scope.menu = $theme.LecturerMenu;

      break;
      case 'Student': 

      $scope.menu = $theme.StudentMenu;

      break;
      default: break;
    }

    /* MANUAL */
    $scope.$on('$viewContentLoaded', function(){
      

      //$('#helper').triggerHandler('click');
      //angular.element('#helper').trigger('click');
      console.log('loaded');
    });

    
    $scope.templates = 
    [ 
      { url: '/views/manual/intro.html'},
      { name: "Course Information", url: '/views/manual/courseinfo.html'},

      { name: "Modules & Materials", url: '/views/manual/modulesmaterials.html'},
      { name: "Module Tasks", url: '/views/manual/moduletasks.html'},
      { name: "Assignment Coursework", url: '/views/manual/assignmentcoursework.html'},
      { name: "Examination & Test Processes", url: '/views/manual/examinationtests.html'},
      { name: "Consultation Hours", url: '/views/manual/consultationhours.html'},
      { name: "Web Results", url: '/views/manual/webresults.html'},
      { name: "Course Fee Information", url: '/views/manual/coursefees.html'},

      { name: "Components layout", url: '/views/manual/componentslayout.html'},
      { name: "Notifications & Announcements", url: '/views/manual/notificationsannouncements.html'},
      { name: "Pending Tasks", url: '/views/manual/pendingtasks.html'},
      { name: "Online Communication Channel", url: '/views/manual/onlinecommunication.html'},
      { name: "Technical Support", url: '/views/manual/technicalsupport.html'},

      //14
      { name: "Research Methods", url: '/views/manual/subject-research-methods.html'},
      { name: "Management and Organizations", url: '/views/manual/subject-management-and-organizations.html'},
      { name: "Business to Business Marketing", url: '/views/manual/subject-business-to-business-marketing.html'},
      { name: "Management of Financial Control", url: '/views/manual/subject-management-of-financial-control.html'},
      { name: "Strategic Operations Management", url: '/views/manual/subject-strategic-operations-management.html'},
      { name: "International Marketing Strategy", url: '/views/manual/subject-international-marketing-strategy.html'},
      { name: "Strategic Management", url: '/views/manual/subject-strategic-management.html'},
      { name: "Business Systems Analysis and Decision Support", url: '/views/manual/subject-business-systems-analysis-and-decision-support.html'},

      { url: '/views/manual/template1.html'},
      { url: '/views/manual/template2.html'}
    ];
    
    $scope.template = $scope.templates[0];

    $scope.changeContent = function(id) {

      $scope.template = $scope.templates[id];
    };


  }]);