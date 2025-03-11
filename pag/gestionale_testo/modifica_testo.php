
<?php
// Start the session
session_start();





?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 

if($_POST["Salva"]=="Salva"){

  $qryinsert = "update  tab_text set 
  title ='".addslashes($_POST["titolo"])."' ,
  title_en ='".addslashes($_POST["titolo_en"])."' ,
  text ='".addslashes($_POST["text"])."' ,
  text_en ='".addslashes($_POST["text_en"])."' ,
  id_suitable =".$_POST["nuovo_suitable"]."
  where id_text =".$_GET["id"]."
  ";
  $rs = connetti($qryinsert);
  }


  if($_POST["Salva2"]=="Attiva ITA"){
   $qryc = "select * from tab_confirm where lang ='it' and id_text=".$_GET["id"];
   $rsc = connetti($qryc);
   $val = mysqli_num_rows($rsc);
   if ($val >0){
    $qryinsert = "update  tab_confirm set 
    leggi=1
     where id_text =".$_GET["id"]." and lang ='it'
     ";
   } else{
    $qryinsert = "insert into tab_confirm set 
    leggi=1,
    lang='it',
    id_text =".$_GET["id"]."
     ";
   }
    $rs = connetti($qryinsert);
  }

if($_POST["Salva1"]=="Attiva EN"){
    $qryc = "select * from tab_confirm where lang ='en' and id_text=".$_GET["id"];
   $rsc = connetti($qryc);
   $val = mysqli_num_rows($rsc);
   if ($val >0){
    $qryinsert = "update  tab_confirm set 
    leggi=1
     where id_text =".$_GET["id"]." and lang ='en'
     ";
   } else{
    $qryinsert = "insert into tab_confirm set 
    leggi=1,
    lang='en',
    id_text =".$_GET["id"]."
     ";
   }
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
        <a href="elenco.php"><i class="fas fa-long-arrow-alt-left fa-2x"></i> </a> 
       <!-- /.col -->
        
        </div>
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Gestione testo</h1>
          
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

<?php $qry ="select * from tab_text where id_text=".$_GET["id"]."";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){
?>
<div class="card-body" >
<div class="form-group">
<label>Titolo <?php echo controlla_attivo(1,'it',$_GET["id"])?></label>
<textarea class="form-control" rows="1" name="titolo" placeholder="Enter ..."><?php echo $val["title"]?></textarea>
</div>
<div class="form-group">
<label>Testo</label>
<textarea class="form-control" rows="10" name="text" placeholder="Enter ..."><?php echo $val["text"]?></textarea>
</div>

<div class="form-group">
<label>Titolo EN  <?php echo controlla_attivo(1,'en',$_GET["id"])?></label>
<textarea class="form-control" rows="1" name="titolo_en" placeholder="Enter ..."><?php echo $val["title_en"]?></textarea>
</div>
<div class="form-group">
<label>Testo EN</label>
<textarea class="form-control" rows="10" name="text_en" placeholder="Enter ..."><?php echo $val["text_en"]?></textarea>
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
<?php }?>
</div>
<div class="card-footer">
<input type="submit" name="Salva" class="btn btn-info" value="Salva">
<input type="submit" name="Salva2" class="btn btn-info" value="Attiva ITA">
<input type="submit" name="Salva1" class="btn btn-info" value="Attiva EN">
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
