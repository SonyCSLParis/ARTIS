
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

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

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >

      <br><br>
      <div class="col-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Setting</h3>

</div>
 
<form method="post" >  
<div class="card-body ">
<div class="form-group">
<label>semplificato</label>
<input  type="checkbox"   name="semplificato" >
</div>
<div class="form-group">
<label>Font size</label>
<input  type="text"   name="size" value="" >
</div>
<input type="submit" value="Save">
   <!-- /.col-md-6 -->
</form>     
</div>

     
</div>

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="modal-img" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-l">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Avatar</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">

<?php

$handler = opendir('../../img/avatar/');

if (false !== $handler) {

    while ($file = readdir($handler)) {
      if ($file<>"." && $file <> ".." ){
        echo "<img src='../../img/avatar/".$file."' onclick=\"$('#img_av').attr('value','".$file."');$('#img').attr('src','../../img/avatar/".$file."');\" width='100'>";
      }
       
    }
}
closedir($handler);
?>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>

</div>

</div>

 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>

</body>
</html>
