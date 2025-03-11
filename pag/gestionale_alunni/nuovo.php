
<?php

// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";

 controlla_user()?>

<?php 

if($_POST["pul"]=="Salva"){

  
  $qry="insert into tab_student set 
  name='".addslashes($_POST["name"])."',
  
  avatar='".$_POST["img_av"]."',
id_user=".$_POST["logopedista"]."
";

  $rs=connetti($qry);
$qry ="select max(id_student) as massimo from tab_student";
$rs=connetti($qry);
while($val = mysqli_fetch_array($rs)){

$last_id=$val["massimo"];
}
  $qry1="select * from tab_suitable ";
  $rs1 = connetti($qry1);

  while($val1 = mysqli_fetch_array($rs1)){
   
    $p=$val1["id_suitable"];
 if($_POST["suit_".$p]=="yes"){
  
  $qryc = "select * from tab_classe where id_student=".$last_id." and id_suitable=".$val1["id_suitable"];

  $rsc = connetti($qryc);
  if (mysqli_num_rows($rsc)==0){

    $qryins = "insert into tab_classe set id_student = ".$last_id." , id_suitable =".$val1["id_suitable"];
    $rsss = connetti($qryins);
  }
 
}else{
  $qryc = "select * from tab_classe where id_student=".$last_id." and id_suitable=".$val1["id_suitable"];
  $rsc = connetti($qryc);
  if (mysqli_num_rows($rsc)>0){
    $qryins = "delete from tab_classe where id_student = ".$last_id." and id_suitable =".$val1["id_suitable"];

    $rsss = connetti($qryins);
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
            <h1 class="m-0" align="center">Nuovo Alunno</h1>
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




                 <form class="form-horizontal" method="post" action="nuovo.php">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="mail" class="col-sm-2 control-label">Alunno</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $val["name"]?>" >
                      </div>
                    </div>
    
                      <div class="form-group">
                      <label for="suitable" class="col-sm-2 control-label">Classe</label>
                       <div class="col-xs-5">
                    
                                 <?php   $qry1="select * from tab_suitable ";
                                  $rs1 = connetti($qry1);
                                  while($val1 = mysqli_fetch_array($rs1)){
                                   ?><?php echo $val1["suitable"];?>
                                   <input type="checkbox" name="suit_<?php echo $val1["id_suitable"];?>" value="yes"
                                   <?php
                                    $qry2 ="select * from tab_classe where id_student=".$_GET["id_student"]." and id_suitable=".$val1["id_suitable"];
                                    $rs2 = connetti($qry2);
                                    while ($val2=mysqli_fetch_array($rs2)){
                                      echo " checked ";

                                    }?> ><br>
                                   <?php
                                  }
                                  ?>

                       
                      </select>
                      </div>
                    </div>
               
                    <div class="form-group">
                      <label for="logopedista" class="col-sm-2 control-label">Logopedista</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="logopedista">
                      <option value="0">Seleziona il logopedista</option>
                                  <?php   $qry1="select * from tab_user where level<3 order by name";
                                  $rs1 = connetti($qry1);
                                  while($val1 = mysqli_fetch_array($rs1)){
                                    echo "<option value=".$val1["id_user"];
                                    if ($val1["id_user"]==$val["id_user"]){
                                      echo " selected ";
                                    }
                                    echo ">".$val1["name"]." ".$val1["surname"]."</option>";
                                  }
                                  ?>

                       
                      </select>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Avatar </label>
                      <div class="col-xs-5">
                      <img id="img" src="<?php echo $base_dir;?>img/avatar/<?php echo $val["avatar"];?>" width="50">
                      <a href="#" onclick="$('#modal-img').modal('show');">+</a>
                        <input type="hidden" name="img_av" id="img_av" value="<?php echo $val["avatar"];?>">
                      </div>
                    </div>
                  



              
                    
                    <button type="submit" class="btn btn-primary btn-block" value="Salva" name="pul">Salva</button>
      <!-- /.box-footer -->
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
