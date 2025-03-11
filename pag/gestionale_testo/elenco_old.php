
<?php
// Start the session
session_start();






?>
     <?php if($_GET["suitable"]<>"0" && $_GET["suitable"]<>"" && $_GET["title"]<>"0" || $_GET["title"]<>"" ){
    $_SESSION["id_text"]=$_GET["title"];
     }
     ?>
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 

if ($_GET["ideliit"]<>""){
  $qrydel ="update tab_confirm set 
  leggi=0,
  visualizza_parole=0,
  visualizza_testo=0,
  esercizi1=0,
  esercizi2=0,
  esercizi3=0
  where id_text=".$_GET["ideliit"]." and lang ='it'";
  $rsdel = connetti($qrydel);
}
if ($_GET["idelien"]<>""){
  $qrydel ="update tab_confirm set 
  leggi=0,
  visualizza_parole=0,
  visualizza_testo=0,
  esercizi1=0,
  esercizi2=0,
  esercizi3=0
  where id_text=".$_GET["idelien"]." and lang ='en'";
  $rsdel = connetti($qrydel);
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
            <h1 class="m-0" align="center">Gestione testi</h1>
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
<th>Titolo</th>
<th> Elaborazione (IT)</th>

<th> Elaborazione (EN)</th>
<th>Classe</th>
<th>Attiva</th>

<th>Strumenti</th>
</tr>
</thead>
<tbody>
<?php $qry="select * from tab_text";
$rs=connetti($qry);
while ($val=mysqli_fetch_array($rs)) {
  ?> 
<tr>
<td>
<?php echo $val["title"];?> <br>
<?php echo $val["title_en"];?>
</td>
<td>
  <?php
   if($val["status"]==10){

 
  

    echo "Completato";
   }
    if ($val["status"]==-1){
      echo "Testo <br>non presente";
    }
if ($val["status"]==0){
  echo "In <br>lista";
}
if ($val["status"]==1){
  echo "Run";
}
if ($val["status"]==2){
  echo "Genera <br>testo";
}
if ($val["status"]==3){
  echo "Genera <br>keyword";
}
if ($val["status"]==4){
  echo "Genera <br>semplicato";
}
if ($val["status"]==5){
  echo "Genera <br>esercizi";
}

  
  
  
  
  
  
  ?>
</td>
<td>
  <?php 
  
  if($val["status_en"]==10){
    echo "Completato";
  
  }
  

  if ($val["status_en"]==-1){
    echo "Testo <br>non presente";
  }
  if ($val["status_en"]==0){
    echo "In <br>lista";
  }
  if ($val["status_en"]==1){
    echo "Run";
  }
  if ($val["status_en"]==2){
    echo "Genera <br>testo";
  }
  if ($val["status_en"]==3){
    echo "Genera <br>keyword";
  }
  if ($val["status_en"]==4){
    echo "Genera <br>semplicato";
  }
  if ($val["status_en"]==5){
    echo "Genera <br>esercizi";
  }
  
    
  
  
  ?>
</td>
<td>
<?php echo visualizza_suitable($val["id_suitable"]);?>
</td>

<td><a class="nav-link"  href="modifica_testo.php?id=<?php echo $val["id_text"]?>"><i class="fas fa-pencil-alt" aria-hidden="true" style=" font-weight: 900;    color: white;    background-color: #017BFF;    padding: 9px;    border-radius: 5px;"></i></a></td>
<td>
<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true"><i class="fas fa-cog" style=" font-weight: 900;    color: white;    background-color: #017BFF;    padding: 9px;    border-radius: 5px;"></i></a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;margin-left:20px!important;">
<span class="dropdown-item dropdown-header" style="text-align:right!important;"> Stato attivazioni</span>
<div class="dropdown-divider"></div>

<?php $qrychk ="select * from tab_confirm where id_text=".$val["id_text"];
$rschk = connetti($qrychk);
while ($valchk= mysqli_fetch_array($rschk)){
  if($valchk["lang"]=="en"){
    $estensione="_en";
    $bandiera="gb";
  }else{
    $estensione="";
    $bandiera="it";
  }
  ?>

<span class="dropdown-item dropdown-header"><span class="fi fi-<?php echo $bandiera?> " style="width: 25px;height:20px;"></span></span>
<div class="dropdown-divider"></div>
<?php if ($valchk["leggi"]==1){
  $clas = "circlegreen";
}else{
  $clas = "circlered";
}?>
<div style="float:left;margin-left:10px;"><a href="modifica_testo.php?id=<?php echo $val["id_text"]?>">Gestione testo</a></div><div  class='<?php echo $clas;?>' title='Non attivo'  style="float:right;margin-right:10px;"></div> <br>
<?php if ($valchk["visualizza_testo"]==1){
  $clas = "circlegreen";
}else{
  $clas = "circlered";
}?>
<div style="float:left;margin-left:10px;"><a href="modifica_mappa<?php echo $estensione?>.php?id=<?php echo $val["id_text"]?>">Gestione mappa</a></div> <div  class='<?php echo $clas;?>' title='Non attivo'  style="float:right;margin-right:10px;"></div><br> 
<?php if ($valchk["visualizza_parole"]==1){
  $clas = "circlegreen";
}else{
  $clas = "circlered";
}?> 
<div style="float:left;margin-left:10px;"><a href="genera_parole<?php echo $estensione?>.php?id=<?php echo $val["id_text"]?>">Gestione parole</a></div><div  class='<?php echo $clas;?>' title='Non attivo'  style="float:right;margin-right:10px;"></div>  <br>
<?php if ($valchk["esercizi1"]==1){
  $clas = "circlegreen";
}else{
  $clas = "circlered";
}?>
<div style="float:left;margin-left:10px;"><a href="genera_esercizio1<?php echo $estensione?>.php?id=<?php echo $val["id_text"]?>">Gestione esercizio iniziale</a></div><div  class='<?php echo $clas;?>' title='Non attivo'  style="float:right;margin-right:10px;"></div>  <br>
<?php if ($valchk["esercizi2"]==1){
  $clas = "circlegreen";
}else{
  $clas = "circlered";
}?> 
<div style="float:left;margin-left:10px;"><a href="genera_esercizio2<?php echo $estensione?>.php?id=<?php echo $val["id_text"]?>">Gestione esercizio finale</a></div> <div  class='<?php echo $clas;?>' title='Non attivo'  style="float:right;margin-right:10px;"></div> <br>
<?php if ($valchk["esercizi3"]==1){
  $clas = "circlegreen";
}else{
  $clas = "circlered";
}?> 
<div style="float:left;margin-left:10px;"><a href="genera_pronomi<?php echo $estensione?>.php?id=<?php echo $val["id_text"]?>">Gestione esercizio pronomi</a></div><div  class='<?php echo $clas;?>' title='Non attivo'  style="float:right;margin-right:10px;"></div>  <br>
<?php
}
?>
  </div>  
</td>
<!--
<td>
  


<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
<i class="fas fa-cog" style="font-weight: 900;    color: white;    background-color: #017BFF;    padding: 9px;    border-radius: 5px;"></i>

</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;margin-left:20px!important;">
<span class="dropdown-item dropdown-header">Azioni</span>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="modifica_testo.php?id=<?php echo $val["id_text"]?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i> Modifica testo</a>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="ins_img.php?id_text=<?php echo $val["id_text"]?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i> Inserimento immagini biblioteca</a>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_mappa.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span> Genera mappa</a><br>
&nbsp; &nbsp;<a href="genera_mappa_en.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span >Genera mappa</a>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="modifica_mappa.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span> Modifica mappa</a><br>
&nbsp; &nbsp;<a href="modifica_mappa_en.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Modifica mappa</a>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_testi_semplificati.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span> Genera testi semplificati</a><br>
&nbsp; &nbsp;<a href="genera_testi_semplificati_en.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Genera testi semplificati</a>
<div class="dropdown-divider"></div>

&nbsp; &nbsp;<a href="genera_parole.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span> Genera parole</a><br> 
&nbsp; &nbsp;<a href="genera_parole_EN.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Genera parole</a> 
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_pronomi.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it" style="width: 25px;height:20px;"></span> Genera pronomi</a> <br>
&nbsp; &nbsp;<a href="genera_pronomi_EN.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Genera pronomi</a> 
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_esercizio1.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it" style="width: 25px;height:20px;"></span> Genera esercizio iniziale</a><br> 
&nbsp; &nbsp;<a href="genera_esercizio1_en.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Genera esercizio iniziale</a> 
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_esercizio2.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-it" style="width: 25px;height:20px;"></span> Genera esercizio Finale</a> <br>
&nbsp; &nbsp;<a href="genera_esercizio2_en.php?id=<?php echo $val["id_text"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Genera esercizio Finale</a>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="?ideliit=<?php echo $val["id_text"]?>" alt="Disattiva"><span class="fi fi-it" style="width: 25px;height:20px;"></span> Disattiva tutto</a><br>
&nbsp; &nbsp;<a href="?idelien=<?php echo $val["id_text"]?>" alt="Disattiva"><span class="fi fi-gb" style="width: 25px;height:20px;"></span> Disattiva tutto</a>
</div>


</td>-->
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
      'previous': '<',
      'next': '>'
    }
  },
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
   
  });
</script>
</body>
</html>
