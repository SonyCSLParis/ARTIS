
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 

if ($_POST["alunno"]<> ""){
  $_SESSION['id_alunno'] = $_POST["alunno"];
  $qry="select * from tab_student where id_student=".$_POST["alunno"];
  $rs= connetti($qry);
  while($val=mysqli_fetch_array($rs)){
    $_SESSION['img'] = $val["avatar"];
    $_SESSION['id_suitable']=carica_suitable($_POST["alunno"]);
    $_SESSION['id_text']="";
    if ($val["id_grafica"]==0){
      $_SESSION["grafica"] ="";

    }
    if ($val["id_grafica"]==1){
      $_SESSION["grafica"] ="spazio";

    }
    if ($val["id_grafica"]==2){
      $_SESSION["grafica"] ="bosco";
      
    }

  

  }
  
}



?>
<?php include "../../header.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["alunni_titolo"]?></h1>
            <hr>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >

     
      <div class="col-12">
<div class="card">

 
<form method="post" >  
<div class="card-body table-responsive p-0">
<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>Seleziona</th>
<th>Alunno</th>
<th>Classe</th>
<th>Avatar</th>

</tr>
</thead>
<tbody>
<?php 
if ($_SESSION["livello"]=="1"){


$qry="select * from tab_student";
}else{
  $qry="select * from tab_student where id_user=".$_SESSION["id"];
}
$rs=connetti($qry);
while ($val=mysqli_fetch_array($rs)) {
  ?> 
<tr>
<td>

<div class="icheck-primary d-inline">
<input type="radio" id="alun<?php echo $val["id_student"]?>" name="alunno" value="<?php echo $val["id_student"];?>" 
<?php if ($_SESSION["id_alunno"]== $val["id_student"]){echo "checked";}?> onclick='submit()' >

<label for="alun<?php echo $val["id_student"]?>">
</label>
</div>
</td>
<td>
  <?php echo $val["name"];?>
</td>
<td>
  <?php echo visualizza_suitable($val["id_student"]);?>
</td>
<td>
  <img src="<?php echo $base_dir;?>img/avatar/<?php echo $val["avatar"];?>" width="50">
</td>

</tr>
<?php 
}
?>  

</tbody>
</table>

   <!-- /.col-md-6 -->
       


     
</div>


</div>    
<br>   
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
<script>
  
const synth = window.speechSynthesis;
synth.cancel();
</script>

</body>
</html>
