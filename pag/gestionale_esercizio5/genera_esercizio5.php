
<?php
// Start the session
session_start();





?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 

if($_POST["Salva"]=="Salva"){

  $qryinsert = "update  tab_word set 
  word ='".addslashes($_POST["titolo"])."' ,
    id_suitable =".$_POST["nuovo_suitable"].",
    language='".$_POST["nuovo_language"]."'

  where id_word =".$_GET["id"]."
  ";
  $rs = connetti($qryinsert);
  }
  if($_POST["Nuovo"]=="Salva"){
  $qryinsert = "insert into tab_word set 
  word ='".addslashes($_POST["titolo"])."' ,
    id_suitable =".$_POST["nuovo_suitable"].",
        language='".$_POST["nuovo_language"]."'
  ";

  $rs = connetti($qryinsert);
  }
  if($_POST["Salva2"]=="Attiva"){
 
    $qryinsert = "update  tab_word set 
    attiva=1
     where id_word =".$_GET["id"]." 
     ";
   
    $rs = connetti($qryinsert);
  }


?>

<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
        <div class="col-sm-1">
        <a href="elenco_esercizio5.php"><i class="fas fa-long-arrow-alt-left fa-2x"></i> </a> 
       <!-- /.col -->
        
        </div>
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Gestione esercizio 5[da nominare]</h1>
          
          </div>
       <!-- /.row -->  <hr><br>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
       
      <form method="post" >         





<div class="row">
  <div class="col-lg-12">

    <div class="card card-primary">

<?php $x=0;

if($_GET["id"]<>""){


$qry ="select * from tab_word where id_word=".$_GET["id"]."";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){
?>
<div class="card-body" >
<div class="form-group">
<label>Parola </label>
<textarea class="form-control" rows="1" name="titolo" placeholder="Enter ..."><?php echo $val["word"]?></textarea>
</div>
<div class="form-group">
<label>Classe</label>
<select name="nuovo_suitable">
  <option value="0">Seleziona la classe</option>
  <?php   $qry="select * from tab_suitable ";
  $rs = connetti($qry);
  while($val1 = mysqli_fetch_array($rs)){
    echo "<option value='".$val1["id_suitable"]."'";
    if($val["id_suitable"]==$val1["id_suitable"]){echo "selected";}
    echo " >".$val1["suitable"]."</option>";
  }
  ?>
</select>
</div>
<div class="form-group">
<label>Language</label>
<select name="nuovo_language">
  <option value="0">Seleziona la lingua</option>
  <option <?php if($val["language"]=="it"){echo "selected";}?>>it</option>
    <option <?php if($val["language"]=="en"){echo "selected";}?>>en</option>   
</select>
</div>

<?php 
$x=1;
}
}?>
</div>
<?php if ($x==0){?>
  <div class="card-body" >
<div class="form-group">
<label>Parola </label>
<textarea class="form-control" rows="1" name="titolo" placeholder="Enter ..."><?php echo $val["title"]?></textarea>
</div>
<div class="form-group">
<label>Classe</label>
<select name="nuovo_suitable">
  <option value="0">Seleziona la classe</option>
  <?php   $qry="select * from tab_suitable ";
  $rs = connetti($qry);
  while($val1 = mysqli_fetch_array($rs)){
    echo "<option value='".$val1["id_suitable"]."'";
    if($val["id_suitable"]==$val1["id_suitable"]){echo "selected";}
    echo " >".$val1["suitable"]."</option>";
  }
  ?>
</select>
</div>
<div class="form-group">
<label>Language</label>
<select name="nuovo_language">
  <option value="0">Seleziona la lingua</option>
  <option <?php if($val["language"]=="it"){echo "selected";}?>>it</option>
    <option <?php if($val["language"]=="en"){echo "selected";}?>>en</option>   
</select>
</div>
</div>


<?php } ?>

<div class="card-footer">
<?php if ($x==0){?>
<input type="submit" name="Nuovo" class="btn btn-info" value="Salva">
<?php } ?>
<?php if ($x==1){?>
<input type="submit" name="Salva" class="btn btn-info" value="Salva">
<?php } ?>
<input type="submit" name="Salva2" class="btn btn-info" value="Attiva">

<button type="submit" class="btn btn-default float-right">Cancel</button>
</div>
</div>
 

   
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

</body>
</html>
