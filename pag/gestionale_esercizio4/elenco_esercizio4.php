
<?php
// Start the session
session_start();
?>
 
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user();
 if ($_GET["attiva"]=="1" && $_GET["id"]<>""){
?>
<script>
  var theUrl= "http://93.147.158.9:5002/run_exercise4?id=<?php echo $_GET["id"]?>&lang=<?php echo $_GET["lang"]?>"
      var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
   


  </script>
 <!-- $url = 'http://93.147.158.9:5002/run_exercise4?id='.$_GET["id"].'&lang='.$_GET["lang"];
  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  $result = curl_exec($ch);-->
<?php }
 ?>



<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <div class="content-header">
      <div class="container">
      <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center">Gestione esercizio 4</h1>
            <hr>
          
              </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  

    <!-- Main content -->
    <div class="content">
      <div class="container" >
       
    









<table id="example1" class="table table-hover text-nowrap">
<thead>
<tr>
<th>Parola</th>


<th>Classe</th>
<th>Attivo</th>

<th>Modifica <br>parola</th>

<th>Modifica <br>mappa</th>
<th>Genera <br>parole</th>
</tr>
</thead>
<tbody>
<?php $qry="select * from tab_text_exe";
$rs=connetti($qry);
while ($val=mysqli_fetch_array($rs)) {
  ?> 
<tr>
<td>
<?php echo $val["title"];?> 
</td>
<td>

<?php echo visualizza_classe($val["id_suitable"]);?>
</td>
<td>
<?php if($val["attiva"] == 1){ ?>
    <div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>
  <?php }else{ ?> 
    
    <div  class='circlered' title='Non Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>
    <?php } ?>
  </td>

<td><a class="nav-link"  href="genera_esercizio4.php?id=<?php echo $val["id_text"]?>"><i class="fas fa-pencil-alt" ></i></a></td>
<td>
<a class="nav-link"  href="modifica_mappa4.php?id=<?php echo $val["id_text"]?>"><i class="fas fa-pencil-alt" ></i></a>
</td>
<td>
<a class="nav-link"  href="elenco_esercizio4.php?attiva=1&id=<?php echo $val["id_text"]?>&lang=<?php echo $val["language"]?>">GO</a></td>


</tr>
<?php 
}
?>  
 
</tbody>
</table><br>
<br>

   <!-- /.col-md-6 -->

      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 
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
      'previous': '',
      'next': ''
    }
  },
  "stateSave": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
   
  });
</script>
</body>
</html>
