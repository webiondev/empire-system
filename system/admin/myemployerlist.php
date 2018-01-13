<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

$nav = "recruit";
$subnav = "myemployerlist";

$dbcon->connect();

$page_name = "myemployerlist.php";
$page_number = $_GET["pg"];

if ($page_number == "")
{
  $page_number = 1;
}

$previous_page = $page_number - 1;
$next_page = $page_number + 1;

$entrycount=$dbcon->getexec("SELECT COUNT(1) FROM employment_history ".$strwhere);

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
$strwhere="where user_id=".quote_smart($_COOKIE["user_id"]);
$myemployerlist=$dbcon->exec("SELECT * FROM employee ".$strwhere);

if($myemployerlist>0)
  $myemployerlist=$dbcon->data_seek(0);

 

$strwhere="where employee_id=".quote_smart($myemployerlist[idemployee]);
$myemployerlist=$dbcon->exec("SELECT * FROM employment_history ".$strwhere." ORDER BY company DESC LIMIT ".$position.", ".ITEM_PER_PAGE);



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
                            <h5>Employer Details</h5>
                        </div>
                      <div class="ibox-content">
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover datatables-content" >
                                  <thead>
                                  <tr>
                                     <!-- <th>&nbsp;</th> -->
                                      <th>Name</th>
                                      <th>Company</th>
                                      
                                      <th>Position</th>
                                      <th>Email</th>
                                      <!-- <th>Date Applied</th> -->
                                      <th style="width:120px;" class="no-sort text-center">Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
  <?php
    for($i=0;$i<$myemployerlist;$i++){
      $row=$dbcon->data_seek($i);
      

        $employer=$dbcon2->exec("select * from employer where idemployer = ".quote_smart($row[employer_id]));
        if ($employer>0)
           $employer=$dbcon2->data_seek(0);

        $employerinfo=$dbcon2->exec("select * from user where iduser = ".quote_smart($employer[user_id]));

         if ($employerinfo>0)
           $employerinfo=$dbcon2->data_seek(0);

  ?>
                                  <tr id="item-<?php echo $employerinfo[iduser];?>">
                                     <!-- <td><img src="<?php echo extractfile($row[file], 'preview', '200x63%23'); ?>" class="img-thumbnail" /></td> -->
                                      <td><?php echo $employerinfo[name]; ?></td>
                                      <td><?php echo $employer[company]; ?></td>   
                                      <td><?php echo $employer[position]; ?></td>
                                      <td><?php echo $employerinfo[email]; ?></td>
                                      <!-- <td><?php echo $row[date_applied]; ?></td>
                                       --><td class="text-center">
                                        <div class="btn-group action-tooltip">
                                          <a href="myemployer.php?userid=<?php echo $employer["user_id"]; ?>&name=<?php echo $employerinfo["name"]; ?>" class="btn-white btn btn-sm" data-toggle="tooltip" data-placement="top" title="message"><i class="fa fa-pencil"></i></a>
                                        </div>

                                         <!-- <div class="btn-group action-tooltip">
                                          <a href="delete.php?leaveid=<?php echo $row[idleave]; ?>" class="btn-white btn btn-sm" data-toggle="tooltip" data-placement="top" title="delete"><i class="fa fa-remove"></i></a>
                                        </div> -->
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
