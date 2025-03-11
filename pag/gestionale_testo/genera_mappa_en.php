
<?php
// Start the session
session_start();

   if($_GET["suitable"]<>"0" && $_GET["suitable"]<>"" && $_GET["title"]<>"0" || $_GET["title"]<>"" ){
    $_SESSION["id_text"]=$_GET["title"];
     }
     ?>
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 
if($_GET["ideli"]<>""){
  $qry ="select * from tab_map where id_text=".$_GET["ideli"]." and lang='en'";
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
    $qrydel ="delete from tab_keyword where id_map=".$val["id_map"]." ";
    $rsdel = connetti($qrydel);
   
  }
 
  $qrydel ="delete from tab_map where id_text=".$_GET["ideli"]." and lang='en'";
  $rsdel = connetti($qrydel);
  
  }
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>

<meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php include "../../head.php";?>
<style>
  
#loading {
  position: fixed;
  display: block;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  opacity: 0.7;
  background-color: #fff;
  z-index: 1000000;
  
  background-color: rgba(192, 192, 192, 0.5);
  background-image: url("https://i.stack.imgur.com/MnyxU.gif");
  background-repeat: no-repeat;
  background-position: center;
}
</style>
</head>
<body class="hold-transition layout-top-nav layout-footer-fixed layout-navbar-fixed">
<div class="wrapper">

<?php include "../../navbar2.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Genera Mappa EN</h1>
          
          </div>
        <div class="col-sm-1">
        <a href="elenco.php"> <i class="fas fa-undo-alt"></i></a>
       <!-- /.col -->
        
        </div><!-- /.row -->  <hr>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
       
      <form method="post" action="?id=<?php echo $_GET["id"]?>" >         





<div class="row">
  <div class="col-lg-12">

    <div class="card card-primary">
<div class="card-header">
<?php
$qry ="select * from tab_text where id_text=".$_GET["id"]."";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<h3 class="card-title"><?php echo $val["title_en"]; ?></h3>


</div>

<div class="card-body" >
<div class="form-group">



<input type="hidden" value="<?php echo str_replace("\"","",$val["text_en"]);?>" name="text">
<?php echo str_replace("\"","",$val["text_en"]);


}

?>




</div>
</div>
<div class="card-footer">
<input type="hidden" value="en" name="language">

<input type="submit" class="btn btn-info" value="Genera Mappa" onclick="$('#loading').show();" name="genera">
<a href="?id=<?php echo $_GET["id"];?>&ideli=<?php echo $_GET["id"];?>&l=en"><div class="btn btn-info" >Elimina mappa</div></a>
<button type="submit" class="btn btn-default float-right">Cancel</button>
</div>
</div>
  
<?php


if ($_POST["genera"]== "Genera Mappa" ){

  $qry ="select * from tab_map where id_text=".$_GET["id"]." and lang='en'";
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
    $qrydel ="delete from tab_keyword where id_map=".$val["id_map"]." ";
    $rsdel = connetti($qrydel);
   
  }
 
  $url = 'http://93.147.158.9:5002/run_all';
  $ch = curl_init( $url );
  $data=str_replace("\"","",$_POST["text"]);
 
  $payload = json_encode( array( "text"=> $data ,"language"=> $_POST["language"],"id"=>$_GET["id"]) );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  
  $result = curl_exec($ch);

  ?>
  
  <script>
     $("#loading").hide();
     console.log("hide");
    </script>
  <?php
  
  
  }
  
$qryc="select * from tab_map where id_text=".$_GET["id"]." and lang='en'";
$rsc = connetti($qryc);
$valc=mysqli_num_rows($rsc);
if($valc >0){

?><div align="center">
<a href="modifica_mappa_en.php?id=<?php echo $_GET["id"];?>"><div class="btn btn-info" >MODIFICA/ATTIVA</div> </a></div>
<?php 

}
?>

   
</div>
</div>
 </form>       <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>
<div id="loading" style="display:none;"></div>
</body>
</html>
