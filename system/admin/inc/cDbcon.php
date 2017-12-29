<?php
include_once  dirname(__FILE__).'/../../config.php';

error_reporting(E_ALL & ~E_NOTICE);


class dBcon_MCI
{
  var $conn = FALSE ;
  var $total = 0;
  var $abstractData = FALSE;
  var $error = FALSE;
  function error_log($str, $conn){
    if(mysqli_errno($conn)){

      $str= $str."\n " .mysqli_errno($conn).": ".mysqli_error($conn)."\n";

      die("query Error! => $str ");
    }
  }


  function connect()
  {

    $this->conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
    if($this->conn)
    {
      $this->error = FALSE ;
      mysqli_select_db($this->conn,DB);
    }
    else
    {
      $this->error = TRUE;
      echo "Database Connection Error";
    }
  }

  function exec($qry)
  {
    $this->result=mysqli_query($this->conn,$qry) or $this->error_log($qry, $this->$conn);
    $this->total = mysqli_affected_rows($this->conn);
    return $this->total;
  }

  function safeexec($qry)
  {
    $this->result=@mysqli_query($this->conn,$qry);
    $this->total = @mysqli_affected_rows($this->conn);
    //return $this->total;
  }


  function data_seek($i)
  {
    mysqli_data_seek($this->result,$i);
    $temp=mysqli_fetch_array($this->result) or $this->error_log($qry, $this->$conn);
    return $temp;
  }

  function getexec($qry)
  {
    $this->result=mysqli_query($this->conn,$qry) or $this->error_log($qry, $this->$conn);
    $this->total = mysqli_affected_rows($this->conn);
    if($this->total > 0){
      mysqli_data_seek($this->result,0);
      $temp=mysqli_fetch_array($this->result);
      return $temp[0];
    }else{
      return false;
    }
  }

  function insert($table,$row)
  {
    $key='';
    $val='';
    $fields_qry='';
    $values_qry='';

    while ( list( $key, $val ) = each( $row ) ) {
        if(0<$i){
        $fields_qry.=",";
        $values_qry.=",";
      }

      $fields_qry .=$key;
      $values_qry .="'".$val."'";
      $i++;

    }



    $qry="insert ignore into $table($fields_qry) values ($values_qry)";

    if(!($this->Exec($qry))) return false;
    $this->lastid = mysqli_insert_id($this->conn);
    return $this->lastid;
  }


   function delete($table,$id){


    $qry="DELETE FROM $table WHERE id=$id";

    if($this->Exec($qry)) return false;
    $this->total = mysqli_affected_rows($this->conn);
    return $this->total;

  }  

  function update($table,$row,$where="")
    {
    $key='';
    $val='';
    $qry='';
    while ( list( $key, $val ) = each( $row ) ) {
        if(0<$i){
        $qry .= ",";
      }
      $qry .= $key."='".$val."'";
      $i++;

    }
    
    if ($where !=""){

      $where = " where $where";
    }

    $qry="update $table  set $qry ".$where;

   
  
    if($this->Exec($qry)) return false;
    $this->total = mysqli_affected_rows($this->conn);
    return $this->total;
  }

  function close()
  {
    return mysqli_close($this->conn);
  }
}

$dbcon = new dBcon_MCI();
$dbcon2 = new dBcon_MCI();
?>