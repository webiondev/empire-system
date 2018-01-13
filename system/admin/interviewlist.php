<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

$nav = "interview";
$subnav = "listinterview";

$dbcon->connect();

$page_name = "interviewlist.php";
$page_number = $_GET["pg"];

if ($page_number == "")
{
  $page_number = 1;
}

$previous_page = $page_number - 1;
$next_page = $page_number + 1;

$entrycount=$dbcon->getexec("SELECT COUNT(1) FROM interview ".$strwhere);

$pages = ceil($entrycount/ITEM_PER_PAGE);

$pagination = '';

if($pages > 1)
{
    $pagination .= '<ul class="pagination pull-right">';

    if ($previous_page < 1)
    {
      $pagination .= '<li class="footable-page-arrow disabled">';
    }
    else
    {
      $pagination .= '<li class="footable-page-arrow">';
    }

    $pagination .= '<a href="'.$page_name.'?pg=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';
    $pagination .= '</li>';

    if ($previous_page < 1)
    {
      $pagination .= '<li class="footable-page-arrow disabled">';
    }
    else
    {
      $pagination .= '<li class="footable-page-arrow">';
    }

    $pagination .= '<a href="'.$page_name.'?pg='.$previous_page.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
    $pagination .= '</li>';

    for($i = 1; $i<=$pages; $i++)
    {
      if ($i == $page_number)
      {
        $pagination .= '<li class="footable-page active"><a href="'.$page_name.'?pg='.$i.'">'.$i.'</a></li>';
      }
      else
      {
        $pagination .= '<li class="footable-page"><a href="'.$page_name.'?pg='.$i.'">'.$i.'</a></li>';
      }
    }

    if ($next_page > $pages)
    {
      $pagination .= '<li class="footable-page-arrow disabled">';
    }
    else
    {
      $pagination .= '<li class="footable-page-arrow">';
    }
    $pagination .= '<a href="'.$page_name.'?pg='.$next_page.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
    $pagination .= '</li>';
    if ($next_page > $pages)
    {
      $pagination .= '<li class="footable-page-arrow disabled">';
    }
    else
    {
      $pagination .= '<li class="footable-page-arrow">';
    }
    $pagination .= '<a href="'.$page_name.'?pg='.$pages.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
    $pagination .= '</li>';

    $pagination .= '</ul>';
}

if(!is_numeric($page_number)){
  header("location: ".$page_name);
  exit();
}

$position = (($page_number - 1) * ITEM_PER_PAGE);

$interviewlist=$dbcon->exec("SELECT * FROM interview ".$strwhere." ORDER BY date_time DESC, domain ASC LIMIT ".$position.", ".ITEM_PER_PAGE);


?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_NAME; ?></title>

    <?php include "inc/header.php"; ?>

</head>

<body class="md-skin">
    <div id="wrapper">

    <?php include "inc/nav.php"; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
          <?php include "inc/topnav.php"; ?>
        </div>
        <div class="wrapper wrapper-content">
              <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>User List</h5>
                        </div>
                      <div class="ibox-content">
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover datatables-content" >
                                  <thead>
                                  <tr>
                                     <!--  <th>&nbsp;</th> -->
                                      <th>Arranged by</th>
                                      <th>Date/Time</th>
                                      <th>domain</th>
                                      <th>postcode</th>
                                      <th>city</th>
                                      <th>street</th>
                                      <th>country</th>
                                      <th style="width:120px;" class="no-sort text-center">Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
  <?php
    for($i=0;$i<$interviewlist;$i++){
      $row=$dbcon->data_seek($i);

        $name=$dbcon2->exec("select name from user where iduser = ".quote_smart($row[user_id]));
        if ($name>0)
           $name=$dbcon2->data_seek(0);

  ?>
                                  <tr id="item-<?php echo $row[idinterview];?>">
                                     <!--  <td><img src="<?php echo extractfile($row[image], 'preview', '200x63%23'); ?>" class="img-thumbnail" /></td> -->
                                      <td><?php echo $name[name]; ?></td>
                                      <td><?php echo $row[date_time]; ?></td>
                                      <td><?php echo $row[domain]; ?></td>
                                      
                                      <td><?php echo $row[postcode]; ?></td>
                                      <td><?php echo $row[city]; ?></td>
                                      <td><?php echo $row[street]; ?></td>
                                      <td><?php echo $row[country]; ?></td>
                                      
                                      <td class="text-center">
                                        <div class="btn-group action-tooltip">
                                          <a href="interview.php?interviewid=<?php echo $row[idinterview]; ?>" class="btn-white btn btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                        </div>

                                         <div class="btn-group action-tooltip">
                                          <a href="delete.php?interviewid=<?php echo $row[idinterview]; ?>" class="btn-white btn btn-sm" data-toggle="tooltip" data-placement="top" title="delete"><i class="fa fa-remove"></i></a>
                                        </div>
                                      </td>
                                  </tr>

  <?php
    }
?>

                                  </tbody>
                                  <tfoot>
                                  <tr>
                                      <td colspan="9" class="footable-visible">
                                          <?php echo $pagination; ?>
                                      </td>
                                  </tr>
                                  </tfoot>
                              </table>
                          </div>

                            </div>
                    </div>
        </div>

          <?php include "inc/footer.php"; ?>

        </div>
    </div>

  <?php include "inc/script.php"; ?>
    <script>
        $(document).ready(function(){


        });

    </script>
</body>
</html>
