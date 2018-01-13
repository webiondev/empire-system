<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

$nav = "hire";
$subnav = "listrecruitrequest";

$dbcon->connect();

$page_name = "recruitrequestlist.php";
$page_number = $_GET["pg"];

if ($page_number == "")
{
  $page_number = 1;
}

$previous_page = $page_number - 1;
$next_page = $page_number + 1;

$entrycount=$dbcon->getexec("SELECT COUNT(1) FROM recruitrequest ".$strwhere);

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
$strwhere="where employer_iduser=".$_COOKIE["user_id"];
$recruitrequestlist=$dbcon->exec("SELECT * FROM recruitrequest ".$strwhere." ORDER BY date DESC LIMIT ".$position.", ".ITEM_PER_PAGE);


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
                            <h5>Recruit Requests</h5>
                        </div>
                      <div class="ibox-content">
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover datatables-content" >
                                  <thead>
                                  <tr>
                                     <!-- <th>&nbsp;</th> -->
                                      <th>Recruit Name</th>
                                      <th>Date</th>
                                      <th style="width:120px;" class="no-sort text-center">Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
  <?php
    for($i=0;$i<$recruitrequestlist;$i++){
      $row=$dbcon->data_seek($i);


        $name=$dbcon2->exec("select name from user where iduser =".quote_smart($row[recruit_iduser]));
        if ($name>0)
           $name=$dbcon2->data_seek(0);

        

  ?>
                                  <tr id="item-<?php echo $row[idrequest];?>">
                                    <!--  <td><img src="<?php echo extractfile($row[photo], 'preview', '200x63%23'); ?>" class="img-thumbnail" /></td> -->
                                      <td><?php echo $name[name]; ?></td>
                                      <td><?php echo $row[date]; ?></td>
                                      <td class="text-center">
                                        <div class="btn-group action-tooltip">
                                          <a href="acceptrequest.php?requestid=<?php echo $row[idrequest]; ?>&recruitid=<?php echo $row[recruit_iduser]; ?>" class="btn-white btn btn-sm" data-toggle="tooltip" data-placement="top" title="hire recruit"><i class="fa fa-pencil"></i></a>
                                        </div>

                                         <div class="btn-group action-tooltip">
                                          <a href="delete.php?requestid=<?php echo $row[idrequest]; ?>" class="btn-white btn btn-sm" data-toggle="tooltip" data-placement="top" title="delete"><i class="fa fa-remove"></i></a>
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
