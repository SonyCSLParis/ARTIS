
<?php

// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 include "../../admin/class.phpmailer.php";
include "../../admin/class.smtp.php";
 controlla_user()?>

<?php 

if($_POST["pul"]=="Salva"){
  if ($_POST["pass"]<>""){
      $sql_pas=" password ='".sha1($_POST["pass"])."', ";
      $txt ="Benvenut* ".$_POST["name"]." ".$_POST["surname"].",<br> La tua nuova password è <br> ".$_POST["pass"]." <br> Potrai collegarti al software Artis all'indirizzo: <br> <a href='http://93.147.158.9/artis/'>Artis</a><br><br> Saluti.";
      invio_mail($_POST["mail"],"Modifica password",$txt);
}else{
  $sql_pas="";
}
$qry ="update tab_user set
mail ='".$_POST["mail"]."',
".$sql_pas."
level =".$_POST["livello"].",
name ='".$_POST["name"]."',
surname ='".$_POST["surname"]."',
id_student =".$_POST["studente"]."
 where id_user =".$_GET["id"];

$rs = connetti($qry);

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
            <h1 class="m-0" align="center">Modifica Utente</h1>
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




<?php $qry = "select * from tab_user where id_user =".$_GET["id"];
$rs =connetti($qry);
while ($val = mysqli_fetch_array($rs)){?>
                 <form class="form-horizontal" method="post" action="modifica1.php?id=<?php echo $_GET["id"]?>">
                  <div class="box-body">

                  <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">ID </label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $val["name"]?>" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="mail" class="col-sm-2 control-label">E-mail</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="mail" name="mail" value="<?php echo $val["mail"]?>" >
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="pass" class="col-sm-2 control-label">Password</label>
                      <div class="col-xs-5">
                        <input type="password" class="form-control" id="pass" name="pass" >
                      </div>
                    </div>

                  <?php if ($val["level"]==3){?>


                    <input type="hidden" name="livello" value="3">
                    <?php  } else { ?> 
                      <div class="form-group">
                      <label for="livello" class="col-sm-2 control-label">Ruolo</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="livello">
                        <option value="1" <?php if($val["level"] ==1) { echo "selected";}?>>Amministratore</option>
                        <option value="2"  <?php if($val["level"] ==2) { echo "selected";}?>>Logopedista</option>
        
                       
                      </select>
                      </div>
                    </div>
                  <?php } ?>
                   


                  
                  

                    <div class="form-group">
                      <label for="livello" class="col-sm-2 control-label">Alunno</label>
                       <div class="col-xs-5">
                       <input type="hidden" class="form-control" id="studente" name="studente" value="<?php echo $val["id_student"]?>" >
                      <input type="text" class="form-control" id="studenten" name="studenten" readonly value="<?php echo visualizza_studente($val["id_student"])?>" >
        
                      </div>
                    </div>



              
                    
                    <button type="submit" class="btn btn-primary btn-block" value="Salva" name="pul">Salva</button>
      <!-- /.box-footer -->
</form>
<?php } ?>
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

</body>
</html>
