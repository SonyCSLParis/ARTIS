
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 

if($_GET["archivia"]==1){

  if($_POST["libro"]>0){
    $filtrolibro=" and id_text=".$_POST["libro"]." ";
  }
  if($_POST["esercizio"]>0){
    if ($_POST["esercizio"]==1 || $_POST["esercizio"]==2){
      $chkte=1;
      $filtroesercizio=" and id_exercise=".$_POST["esercizio"]." ";
    }
    if ($_POST["esercizio"]==3){
      $chkte=2;
      $filtroesercizio=" and id_exercise=".$_POST["esercizio"]." ";
    }

  }else{
    $chkte=0;
  }
if($chkte==1 || $chkte==0){

  $qryv ="select max(id_version) as maxv from tab_result where id_student=".$_GET["id_student"].$filtrolibro.$filtroesercizio;
  $rsv = connetti($qryv);
  while($valv =mysqli_fetch_array($rsv)){
    $new_version=$valv["maxv"]+1;

  }
  if ($new_version>0){
  $qry ="Select * from tab_result where id_student=".$_GET["id_student"]." and id_version=0".$filtrolibro.$filtroesercizio;
  $rs = connetti($qry);
  echo $qry;
  while($val=mysqli_fetch_array($rs)){
      $qryupdate ="update tab_result set 
      id_version =".$new_version.",
      datearc ='".$val["lastUpdated"]."'
      where id_result=".$val["id_result"];
    //  $rsup =connetti($qryupdate); 

  }
  }
}


if($chkte==2 || $chkte==0){
  $qryv ="select max(id_version) as maxv from tab_response_pronouns where id_student=".$_GET["id_student"].$filtrolibro;
  $rsv = connetti($qryv);
  while($valv =mysqli_fetch_array($rsv)){
    $new_version=$valv["maxv"]+1;

  }
  if ($new_version>0){
  $qry ="Select * from tab_response_pronouns where id_student=".$_GET["id_student"]." and id_version=0".$filtrolibro;
  $rs = connetti($qry);
  echo $qry;
  while($val=mysqli_fetch_array($rs)){
      $qryupdate ="update tab_response_pronouns set 
      id_version =".$new_version.",
      datearc ='".$val["lastUpdated"]."'
      where id_rp=".$val["id_rp"];
  // $rsup =connetti($qryupdate); 

  }
  }

}
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
            <h1 class="m-0" align="center">Gestione alunni</h1>
            <hr>
            <h1 class="m-0" align="center"> <a href="nuovo.php">Nuovo alunno</a></h1>
              </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <div class="content">
      <div class="container" >
     
      <div class="col-12">


<table id="example1" class="table table-hover text-nowrap">
<thead>
<tr>

<th>Alunno</th>
<th>Classe</th>
<th>Logopedista</th>
<th>Avatar</th>
<th>Modifica</th>
<th>Accesso</th><!--
<th>Download</th>
<th>Archivia</th>-->
</tr>
</thead>
<tbody>
<?php 

if($_SESSION["livello"]==2){
  $filtro1 =  " where id_user=".$_SESSION["id"];
}

$qry="select * from tab_student ".$filtro1;

$rs=connetti($qry);
while ($val=mysqli_fetch_array($rs)) {
  ?> 
<tr>

<td>
  <?php echo $val["name"];?>
</td>
<td>
  <?php echo visualizza_suitable($val["id_student"]);?>
</td>
<td>
  <?php echo visualizza_user_id($val["id_user"]);?>
</td>
<td>
  <img src="<?php echo $base_dir;?>img/avatar/<?php echo $val["avatar"];?>" width="50">
</td>
<td>
<a href="modifica.php?id_student=<?php echo $val["id_student"]?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
</td>

<td>
 <a href="../gestionale_utenti/<?php echo controllo_accesso($val["id_student"]);?>"><span class="fas fa-user"></span></a>

</td>
<!--
<td><a href="?ideli=<?php echo $val["id_student"]?>">
<i class="fas fa-times-circle"></i></a>
<a href="risultati.php?id_student=<?php echo $val["id_student"]?>">
<i class="fa fa-eye" aria-hidden="true"></i>
</a></td>
<td>
<form method="POST" action="elenco.php?id_student=<?php echo $val["id_student"]?>&archivia=1">
<select name="libro">
<option value="0">Tutti i libri</option>
<?php $qryst="select * from tab_text where id_suitable=".$val["id_suitable"];
$rsst= connetti($qryst);
while($valst = mysqli_fetch_array($rsst)){
?>
<option value="<?php echo $valst["id_text"]?>"><?php echo $valst["title"]?></option>
<?php
}
?>
</select><br>
<select name="esercizio">
<option value="0">Tutti gli esercizi</option>
<?php $qryst="select * from tab_exercise ";
$rsst= connetti($qryst);
while($valst = mysqli_fetch_array($rsst)){
?>
<option value="<?php echo $valst["id_exercise"]?>"><?php echo $valst["title"]?></option>
<?php
}
?>
</select><br>
<input type="submit" value="Archivia" name="pul_archivia" class="btn btn-info">
</form>


</td>
-->
</tr>
<?php 
}
?>  

</tbody>
</table>
   <!-- /.col-md-6 -->

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
<script>
  
  $(function () {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
  
      language: {
    'paginate': {
      'previous': '<',
      'next': '>'
    }
  },
      "ordering": false,
      "info": false,
    });
   
  });
</script>
</body>
</html>
