angular
  .module('theme.calendar', [])
  .directive('fullCalendar', ['$window', '$http', '$theme', function($window, $http, $theme) {
    'use strict';
    return {
      restrict: 'A',
      scope: {
        options: '=fullCalendar',
        events: '=ngModel'
      },
      link: function(scope, element) {

        // console.log(scope);
        // console.log(element);

        var defaultOptions = {
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          // select: function(start, end, allDay) {
          //   var title = $window.prompt('Event Title:');
          //   if (title) {
          //     calendar.fullCalendar('renderEvent', {
          //         title: title,
          //         start: start,
          //         end: end,
          //         allDay: allDay
          //       },
          //       true // make the event "stick"
          //     );
          //   }
          //   calendar.fullCalendar('unselect');
          // },
          editable: true,
          events: [],
          buttonText: {
            prev: '<i class="fa fa-angle-left"></i>',
            next: '<i class="fa fa-angle-right"></i>',
            prevYear: '<i class="fa fa-angle-double-left"></i>', // <<
            nextYear: '<i class="fa fa-angle-double-right"></i>', // >>
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
          },
          // eventClick: function(calEvent, jsEvent, view) {

          //     alert('Event: ' + calEvent.title);
          //     alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
          //     alert('View: ' + view.name);
          // }
        };

      //scope.$on('eventChanged', function(event, data) {
      scope.$watch(`events`, function() {
        console.log('eventChanged');

        calendar.fullCalendar('removeEventSource', scope.events.demoEvents);

          var base_url = $("meta[name='base_url']").attr('content');

          scope.events.demoEvents.length = 0;

          if(scope.events.events) {

            angular.forEach(scope.events.events, function(value, key) {

              console.log(value.start);

              var date = new Date(Date.parse(value.start));
              var d = date.getDate();
              var m = date.getMonth();
              var y = date.getFullYear();
              
              scope.events.demoEvents.push({
                title: value.title,
                start: new Date(y, m, d),
                backgroundColor: value.backgroundColor
              });

            });
              
            calendar.fullCalendar('addEventSource', scope.events.demoEvents);
            calendar.fullCalendar('addEventSource', scope.events.demoEvents);

          } 
      });


      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      scope.events.demoEvents = [];
      scope.$watch(`events.calendar_id`, function() {
        
          console.log('test');

          console.log(scope);
          console.log(element);
          
          calendar.fullCalendar('removeEventSource', scope.events.demoEvents);

          var base_url = $("meta[name='base_url']").attr('content');

          scope.events.demoEvents.length = 0;

          if(scope.events.events) {

            angular.forEach(scope.events.events, function(value, key) {

              console.log(value.start);

              var date = new Date(Date.parse(value.start));
              var d = date.getDate();
              var m = date.getMonth();
              var y = date.getFullYear();
              
              scope.events.demoEvents.push({
                title: value.title,
                start: new Date(y, m, d),
                backgroundColor: value.backgroundColor
              });

            });
              
            calendar.fullCalendar('addEventSource', scope.events.demoEvents);

          } else {

            calendar.fullCalendar('removeEventSources', scope.events.demoEvents);
          }
              // $http({
              // method: 'get',
              // url: base_url + '/schedule/loadEventsFor/' + scope.events.calendar_id,
              // }).
              // success(function(data, status, headers, config) {

                  // if(data.length) {

                  //   scope.events.demoEvents = [];

                  //   angular.forEach(data, function(value, key) {

                  //     console.log(value);

                  //     var date = new Date(Date.parse(value.start));
                  //     var d = date.getDate();
                  //     var m = date.getMonth();
                  //     var y = date.getFullYear();
                      
                  //     scope.events.demoEvents.push({
                  //       title: value.title,
                  //       start: new Date(y, m, d),
                  //       backgroundColor: value.backgroundColor
                  //     });

                  //   });
                      
                  //   calendar.fullCalendar('addEventSource', scope.events.demoEvents);

                  // } else {

                  //   calendar.fullCalendar('removeEventSources', scope.events.demoEvents);
                  // }

              // }).
              // error(function(data, status, headers, config) {

              //   console.log('error fetching events');
              // }); 
        
        });

         
        angular.element.extend(true, defaultOptions, scope.options);
        if (defaultOptions.droppable === true) {

          defaultOptions.drop = function(date, allDay) {

            var originalEventObject = angular.element(this).data('eventObject');
            var copiedEventObject = angular.element.extend({}, originalEventObject);
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;

            calendar.fullCalendar('renderEvent', copiedEventObject, true);
            if (defaultOptions.removeDroppedEvent === true) {
              angular.element(this).remove();
            }

            var base_url = $("meta[name='base_url']").attr('content');
      
            var date = new Date(Date.parse(copiedEventObject.start));

            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var data = {
              title: copiedEventObject["title"],
              calendar_id: copiedEventObject["calendar_id"],
              start: new Date(y, m, d+1),
              backgroundColor: $theme.getBrandColor('primary')
            };
        
            console.log(copiedEventObject);

            $http({
            method: 'post',
            url: base_url + '/student/addEvent',
            data: data
            }).
            success(function(data, status, headers, config) {

              if(data['success']) {

                console.log('added');
              
              } else {

                console.log('error');
              } 
            }).
            error(function(data, status, headers, config) {

            });

          };

        }
        var calendar = angular.element(element).fullCalendar(defaultOptions);
      }
    };
  }])
  .directive('draggableEvent', function() {
    'use strict';
    return {
      restrict: 'A',
      scope: {
        eventDef: '=draggableEvent'
      },
      link: function(scope, element) {
        angular.element(element).draggable({
          zIndex: 999,
          revert: true,
          revertDuration: 0
        });
        angular.element(element).data('eventObject', scope.eventDef);
      }
    };
  });