
<?php
// Start the session
session_start();
?>
     <?php if($_GET["suitable"]<>"0" && $_GET["suitable"]<>"" && $_GET["title"]<>"0" || $_GET["title"]<>"" ){
    $_SESSION["id_text"]=$_GET["title"];
     }
     ?>
<?php include "../../admin/conn.php";?>

<?php 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php include "../../head.php";?>
</head>
<body class="hold-transition layout-top-nav layout-footer-fixed layout-navbar-fixed">
<div class="wrapper">

<?php include "../../navbar.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Esercizi</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
      <div class="row">

 <?php $qry="select * from tab_exercise";
 $rs=connetti($qry);
 while($val=mysqli_fetch_array($rs)){?>
 
   
<div class="col-lg-6 col-6">

<div class="small-box bg-info">
<div class="inner">
<h3><?php echo strtoupper($val["title"])?></h3>
<h4>0/10</h4>
<p><?php echo $val["info"]?> </p>
</div>

<a href="../exercise1/index.php" class="small-box-footer">VAI <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<?php }?>




</div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>

</body>
</html>
