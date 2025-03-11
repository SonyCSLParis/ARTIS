
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 
if ($_GET["ideli"]<>""){
  $qrydel= "delete from tab_user where id_user=".$_GET["ideli"];
  $rsdel = connetti($qrydel);
}
?>


<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center">Gestione utenti</h1>
            <hr>
            <h3  align="center"> <a href="nuovo.php" >Nuovo utente</a></h3>
              </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >

 




<table id="example1" class="table table-hover text-nowrap">
<thead>
<tr>

<th>ID</th>

<th>E-mail</th>
<th>Ruolo</th>
<th>Studente</th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
<?php 



$qry="select * from tab_user";

$rs=connetti($qry);
while ($val=mysqli_fetch_array($rs)) {
  ?> 
<tr>

<td>
  <?php echo $val["name"];?>
</td>

<td>
  <?php echo $val["mail"];?>
</td>
<td>
  <?php echo visulizza_livello($val["level"]);?>
</td>
<td>
  <?php echo visualizza_studente($val["id_student"]);?>
</td>
<td>

<a href="modifica1.php?id=<?php echo $val["id_user"]?>" class="linktesto" title="Modifca utente"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
</td>
<td>  <?php if($_SESSION["livello"]==1){?>
<a href="elenco.php?ideli=<?php echo $val["id_user"]?>" class="linktesto" title="Elimina utente"><i class="fa fa-trash" aria-hidden="true"></i></a>
<?php }?></td>
</tr>
<?php 
}
?>  

 
</tbody>
</table>
<br><br>
   <!-- /.col-md-6 -->

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
  
  $(function () {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
     
      language: {
    'paginate': {
      'previous': '',
      'next': ''
    }
  },  "stateSave": true,
      "ordering": true,
      "ordering": false,
      "info": false,
    });
   
  });
</script>
</body>
</html>
