angular
  .module('theme.demos.chatbox', [])
  .controller('ChatRoomController', ['$scope', '$timeout', '$window', 'chatMessages', '$http', 'SessionService', function($scope, $t, $window, chatMessages, $http, SessionService) {
    'use strict';
    
    var base_url = $("meta[name='base_url']").attr('content');
    var avatars = ['potter.png', 'tennant.png', 'johansson.png', 'jackson.png', 'jobs.png'];
    
    $scope.messages = chatMessages.getMessages();
    $scope.userText = '';
    $scope.userTyping = false;
    $scope.userAvatar = 'johansson.png';
    
    /*
    $scope.cannedResponses = [
      'Go on...',
      'Why, thank you!',
      'I will let you know.'
    ]; */

    $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
    };

    $scope.sendMessage = function(msg) {

      var currentUser = chatMessages.getCurrentUser();
      this.userText = '';

      var data = {
        text: msg,
        currentUser: currentUser 
      };

      $http({
      method: 'post',
      url: base_url + '/chat/post-message',
      data : data
      }).
      success(function(data, status, headers, config) {
        
        if(data['success']) {

          var im = {
            id: data.id,
            class: 'me',
            avatar: 'original_male.svg',
            text: msg
          };

          $scope.messages.push(im);

        } else {

          pinesNotifications.notify({
                
            title: 'Error',
            text: "Unable to post a message",
            type: 'error',
            hide: true
          });
        }

      }).
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });

      /*
      $t(function() {
        $scope.userAvatar = $window._.shuffle(avatars).shift();
        $scope.userTyping = true;
      }, 500);

      $t(function() {
        var reply = $window._.shuffle($scope.cannedResponses).shift();
        var im = {
          class: 'chat-success',
          avatar: $scope.userAvatar,
          text: reply
        };
        $scope.userTyping = false;
        $scope.messages.push(im);
      }, 1200); */
    };
  }]);