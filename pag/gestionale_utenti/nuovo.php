
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
  $txt ="Benvenut* ".$_POST["name"]." ".$_POST["surname"].",<br> La tua nuova password è <br> ".$_POST["pass"]." <br> Potrai collegarti al software Artis all'indirizzo: <br> <a href='http://93.147.158.9/artis/'>Artis</a><br><br> Saluti.";
  invio_mail($_POST["mail"],"Nuova password",$txt);

  if ($_POST["studente"]<>""){
    $stud= $_POST["studente"];
   
  }else{
    $stud=0;
  }
$qry ="insert into tab_user set
mail ='".$_POST["mail"]."',
password ='".sha1($_POST["pass"])."',
level =".$_POST["livello"].",
name ='".$_POST["name"]."',
surname ='".$_POST["surname"]."',
id_student =".$stud."";
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
            <h1 class="m-0" align="center">Nuovo User</h1>
            <hr>
          
              </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container" >

      <div class="col-12">



                 <form class="form-horizontal" method="post" action="nuovo.php?id_student=<?php echo $_GET["id_student"]?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="mail" class="col-sm-2 control-label">Mail</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="mail" name="mail" value="" >
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="pass" class="col-sm-2 control-label">Password</label>
                      <div class="col-xs-5">
                        <input type="password" class="form-control" id="pass" name="pass" >
                      </div>
                    </div>
                    <?php if($_GET["id_student"]<>""){?>
                      <input type="hidden" name="livello" value="3">
                   
                    <?php    }else{  ?>
                      <div class="form-group">
                      <label for="livello" class="col-sm-2 control-label">Livello</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="livello">
                        <option value="1" <?php if($val["livello"] ==1) { echo "selected";}?>>Amministratore</option>
                        <option value="2"  <?php if($val["livello"] ==2) { echo "selected";}?>>Logopedista</option>
                      
                       
                      </select>
                      </div>
                    </div>
                    <?php    }  ?>

                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">ID </label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $val["name"]?>" >
                      </div>
                    </div>
                  
<?php if ($_GET["id_student"]<>""){?>


                    <div class="form-group">
                      <label for="livello" class="col-sm-2 control-label">Studente</label>
                      <div class="col-xs-5">
                      <input type="hidden" class="form-control" id="studente" name="studente" value="<?php echo $_GET["id_student"]?>" >
                
                        <input type="text" class="form-control" id="studenten" name="studenten" readonly value="<?php echo visualizza_studente($_GET["id_student"])?>" >
                      </div>
                    </div>

                    <?php } ?>
  		
                    
                    <button type="submit" class="btn btn-primary btn-block" value="Salva" name="pul">Salva</button>

</form>

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
