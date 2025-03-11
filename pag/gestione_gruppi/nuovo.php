
<?php

// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";

 controlla_user()?>

<?php 

if($_POST["pul"]=="Salva"){

  
  $qry="insert into tab_suitable set 
  suitable='".addslashes($_POST["name"])."'
  

";

  $rs=connetti($qry);





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
            <h1 class="m-0" align="center">Nuovo Gruppo</h1>
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
                      <label for="mail" class="col-sm-2 control-label">Gruppo</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $val["suitable"]?>" >
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

<!-- ./wrapper -->

<?php include "../../scripts.php";?>

</body>
</html>
