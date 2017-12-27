<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/instafeed.js"></script>
<script src="js/moment.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="js/plugins/flot/jquery.flot.time.js"></script>

<!-- Sweet Alert -->
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>

<!-- Jasny -->
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Jvectormap -->
<script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- EayPIE -->
<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>

<!-- Clock picker -->
<script src="js/plugins/clockpicker/clockpicker.js"></script>

<!-- Select2 -->
<script src="js/plugins/select2/select2.full.min.js"></script>

<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Full Calendar -->
<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>

<!-- SUMMERNOTE -->
<script src="js/plugins/summernote/summernote.min.js"></script>

<!-- DATATABLES -->
<script src="js/plugins/dataTables/datatables.min.js"></script>

<!-- Dual Listbox -->
<script src="js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>

<!-- Toastr script -->
<script src="js/plugins/toastr/toastr.min.js"></script>

<!-- DROPZONE -->
<script src="js/plugins/dropzone/dropzone.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.3/react.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.3/react-dom.js"></script>

<script src="js/attache.js"></script>

<script>
$( document ).ready(function() {

      <?php if ($logon_Role == 'staff') { ?>
      $('body').addClass('skin-1');
      <?php } ?>

      <?php if ($logon_Role == 'agent') { ?>
      $('body').addClass('skin-3');
      <?php } ?>


      $(".disabled a").click(false);

      $(".iframe-btn").fancybox({
        fitToView : false,
        width   : '90%',
        height    : '90%',
        autoSize  : false,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect : 'none'
    });

    $("select.filter").select2({ width: '100%' });


    $('a.ajaxsign').click(function(event) {
       event.preventDefault();
       var obj = $(this);

        swal({
          title: "Are you sure?",
          text: "You are about to mark the student contract as signed.",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes",
          closeOnConfirm: false
        },
        function(){
          obj.attr('disabled','disabled');

          $.post(obj.attr('href'), {  id: obj.attr( "itemid" ) },
                     function(data){
                       swal("Contract Signed!", "This student contract is signed.", "success");
          });
        });


    });

    $('a.ajaxpublish').click(function(event) {
       event.preventDefault();
       var obj = $(this);
       $.get(this.href,{ },function(response){
        if (obj.attr( "status" ) == 1)
        {
          obj.attr("href","publish.php?type="+obj.attr( "type" )+"&id="+obj.attr( "itemid" )+"&status=1");
          obj.html('<span class="fa fa-toggle-off"></span>');
          obj.attr("status", "0");
        }
        else
        {
          obj.attr("href", "publish.php?type="+obj.attr( "type" )+"&id="+obj.attr( "itemid" )+"&status=0");
          obj.html('<span class="fa fa-toggle-on"></span>'+status);
          obj.attr("status", "1");
        }
       });

    });

    $('a.ajaxaccess').click(function(event) {
       event.preventDefault();
       var obj = $(this);
       $.get(this.href,{},function(response){
        if (obj.attr( "status" ) == 1)
        {
          obj.attr("href","access.php?type="+obj.attr( "type" )+"&id="+obj.attr( "itemid" )+"&status=1");
          obj.html('<span class="fa fa-toggle-off"></span>');
          obj.attr("status", "0");
        }
        else
        {
          obj.attr("href", "access.php?type="+obj.attr( "type" )+"&id="+obj.attr( "itemid" )+"&status=0");
          obj.html('<span class="fa fa-toggle-on"></span>'+status);
          obj.attr("status", "1");
        }
       });

    });

    $( ".ajaxdelete" ).click(function() {
      event.preventDefault();
      var obj = $(this);

      swal({
        title: "Are you sure?",
        text: "You are about to delete this record.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
      },
      function(){

        $.post(obj.attr('href'), {  },
                   function(data){
                     $('#item-'+obj.attr('itemid')).hide();
                     swal("Deleted!", "Your selected record is deleted.", "success");
        });
      });

    });

  <?php
    if ($_GET["success"]) { echo 'toastr.success("'.htmlspecialchars($_GET["success"], ENT_QUOTES, 'UTF-8').'", "");'; }
    else if ($_GET["error"]) { echo 'toastr.error("'.htmlspecialchars($_GET["error"], ENT_QUOTES, 'UTF-8').'", "");'; }
  ?>
});
</script>

