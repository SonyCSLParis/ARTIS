
<?php
// Start the session
session_start();





?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 

if($_POST["Salva"]=="Salva"){

  $qryinsert = "insert into tab_text set 
  title ='".addslashes($_POST["titolo"])."' ,
  
  title_en ='".addslashes($_POST["titolo_en"])."' ,
  text ='".addslashes($_POST["text"])."' ,
  text_en ='".addslashes($_POST["text_en"])."' ,
  status=0,
  status_en=0,
  id_suitable =".$_POST["nuovo_suitable"]."
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
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Inserimento testo</h1>
           
          </div>
        <div class="col-sm-1">
        <a href="elenco.php"> <i class="fas fa-undo-alt"></i></a>
      <!-- /.col -->
        
        </div><!-- /.row --> <hr>
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


<div class="card-body" >
<div class="form-group">
<label>Titolo</label>
<textarea class="form-control" rows="1" name="titolo" placeholder="Enter ..."><?php echo $_POST["titolo"]?></textarea>
</div>
<div class="form-group">
<label>Testo</label>
<textarea class="form-control" rows="10" name="text" placeholder="Enter ..."><?php echo $_POST["text"]?></textarea>
</div>
<div class="form-group">
<label>Titolo EN</label>
<textarea class="form-control" rows="1" name="titolo_en" placeholder="Enter ..."><?php echo $_POST["titolo_en"]?></textarea>
</div>
<div class="form-group">
<label>Testo EN</label>
<textarea class="form-control" rows="10" name="text_en" placeholder="Enter ..."><?php echo $_POST["text_en"]?></textarea>
</div>

<div class="form-group">
<label>Classe</label>
<select name="nuovo_suitable">
  <option value="0">Seleziona la classe</option>
  <?php   $qry="select * from tab_suitable ";
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){
    echo "<option value=".$val["id_suitable"].">".$val["suitable"]."</option>";
  }
  ?>
</select>
</div>

</div>
<div class="card-footer">
<input type="submit" name="Salva" class="btn btn-info" value="Salva">

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
