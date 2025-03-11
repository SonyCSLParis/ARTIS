
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 



  




?>
<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center">Gestione Gruppi</h1>
            <hr>
            <h1 class="m-0" align="center"> <a href="nuovo.php">Nuovo gruppo</a></h1>
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

<th>Gruppo</th>

<th>Azioni</th>
</tr>
</thead>
<tbody>
<?php 


$qry="select * from tab_suitable ";

$rs=connetti($qry);
while ($val=mysqli_fetch_array($rs)) {
  ?> 
<tr>

<td>
  <?php echo $val["suitable"];?>
</td>

<td>
<a href="modifica.php?id_suitable=<?php echo $val["id_suitable"]?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



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
