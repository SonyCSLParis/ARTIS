
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
if($_GET["ideli"]<>""){
  $qry ="select * from tab_map where id_text=".$_GET["ideli"]." and lang='it'";
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
    $qrydel ="delete from tab_keyword where id_map=".$val["id_map"]." ";
    $rsdel = connetti($qrydel);
   
  }
 
  $qrydel ="delete from tab_map where id_text=".$_GET["ideli"]." and lang='it'";
  $rsdel = connetti($qrydel);
  
  }
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<style>
  
#loading {
  position: fixed;
  display: block;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  opacity: 0.7;
  background-color: #fff;
  z-index: 1000000;
  
  background-color: rgba(192, 192, 192, 0.5);
  background-image: url("https://i.stack.imgur.com/MnyxU.gif");
  background-repeat: no-repeat;
  background-position: center;
}
</style>
<meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php include "../../head.php";?>
</head>
<body class="hold-transition layout-top-nav layout-footer-fixed layout-navbar-fixed">

<div class="wrapper">

<?php include "../../navbar2.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Genera Mappa IT</h1>
            
          </div>
        <div class="col-sm-1">
         <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
<i class="fas fa-cog" style="font-weight: 900;    color: white;    background-color: #017BFF;    padding: 9px;    border-radius: 5px;"></i>

</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;margin-left:20px!important;">
&nbsp; &nbsp;<a href="elenco.php"><i class="fa fa-chevron-left" aria-hidden="true"></i> Gestione testi</a>
<div class="dropdown-divider"></div>
<span class="dropdown-item dropdown-header">Testo</span>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="modifica_testo.php?id=<?php echo $_GET["id"]?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i> Modifica testo</a>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="ins_img.php?id_text=<?php echo $_GET["id"]?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i> Inserimento immagini biblioteca</a>
<div class="dropdown-divider"></div>
<span class="dropdown-item dropdown-header">Mappa</span>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="modifica_mappa.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span> </a>
&nbsp; &nbsp;<a href="modifica_mappa_en.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span></a>&nbsp; &nbsp;Gestione mappa
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_mappa.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span></a> 
&nbsp; &nbsp;<a href="genera_mappa_en.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span ></a>&nbsp; &nbsp;Genera mappa
<div class="dropdown-divider"></div>

&nbsp; &nbsp;<a href="genera_testi_semplificati.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span> </a>
&nbsp; &nbsp;<a href="genera_testi_semplificati_en.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span></a>&nbsp; &nbsp;Genera testi semplificati
<div class="dropdown-divider"></div>
<span class="dropdown-item dropdown-header">Parole</span>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_parole.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it " style="width: 25px;height:20px;"></span></a>
&nbsp; &nbsp;<a href="genera_parole_EN.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span></a>&nbsp; &nbsp;Gestione parole
<div class="dropdown-divider"></div>
<span class="dropdown-item dropdown-header">Esercizi</span>
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_pronomi.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it" style="width: 25px;height:20px;"></span></a>
&nbsp; &nbsp;<a href="genera_pronomi_EN.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span></a>&nbsp; &nbsp;Gestione pronomi
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_esercizio1.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it" style="width: 25px;height:20px;"></span></a> 
&nbsp; &nbsp;<a href="genera_esercizio1_en.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span></a>&nbsp; &nbsp;Gestione esercizio iniziale
<div class="dropdown-divider"></div>
&nbsp; &nbsp;<a href="genera_esercizio2.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-it" style="width: 25px;height:20px;"></span></a>
&nbsp; &nbsp;<a href="genera_esercizio2_en.php?id=<?php echo $_GET["id"]?>"><span class="fi fi-gb" style="width: 25px;height:20px;"></span></a>&nbsp; &nbsp;Gestione esercizio finale

</div>
    
        </div>
       <!-- /.col -->
        
        </div><!-- /.row --><hr>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
      <form method="post" action="?id=<?php echo $_GET["id"]?>" >         
      <?php
$qry ="select * from tab_text where id_text=".$_GET["id"]."";
$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<div class="row">
  <div class="col-lg-12">

    <div class="card card-primary">
<div class="card-header">
<h3 class="card-title"><?php echo $val["title"]; ?></h3>


</div>

<div class="card-body" >
<div class="form-group">


 
<input type="hidden" value="<?php echo str_replace("\"","",$val["text"]);?>" name="text">
<?php echo str_replace("\"","",$val["text"]);


}

?>




</div>
</div>
<div class="card-footer">
<input type="hidden" value="it" name="language">

<input type="submit" class="btn btn-info" value="Genera Mappa" onclick="$('#loading').show();" name="genera" >

<a href="?id=<?php echo $_GET["id"];?>&ideli=<?php echo $_GET["id"];?>&l=it"><div class="btn btn-info" >Elimina mappa</div> </a>

<div >
<button type="submit" class="btn btn-default float-right">Cancel</button>
</div>
</div>
<?php

if ($_POST["genera"]== "Genera Mappa" ){
  ?>

  <?php
 $qry ="select * from tab_map where id_text=".$_GET["id"]." and lang='it'";
 $rs = connetti($qry);
 while ($val =mysqli_fetch_array($rs)){
   $qrydel ="delete from tab_keyword where id_map=".$val["id_map"]." ";
   $rsdel = connetti($qrydel);
  
 }

 $qrydel ="delete from tab_map where id_text=".$_GET["id"]." and lang='it'";
 $rsdel = connetti($qrydel);
$url = 'http://93.147.158.9:5002/run_all';
$ch = curl_init( $url );
$data=str_replace("\"","",$_POST["text"]);

$payload = json_encode( array( "text"=> $data ,"language"=> $_POST["language"],"id"=>$_GET["id"]) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$result = curl_exec($ch);

?>

<script>
   $("#loading").hide();
   console.log("hide");
   
  </script>
<?php

}

?>
</div>
<?php
$qryc="select * from tab_map where id_text=".$_GET["id"]." and lang='it'";
$rsc = connetti($qryc);
$valc=mysqli_num_rows($rsc);
if($valc >0){

?><div align="center">
<a href="modifica_mappa.php?id=<?php echo $_GET["id"];?>"><div class="btn btn-info" >MODIFICA/ATTIVA</div> </a></div>
<?php 

}




  
   
  
?>

   

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

<script> 



 const synth = window.speechSynthesis;
 function play_text(text){
  $("#play").hide();
  $("#resume").show();
  var msg = new SpeechSynthesisUtterance();
var voices = synth.getVoices();
msg.voice = voices[10]; 
msg.volume = 0.5; // From 0 to 1
msg.rate = 1; // From 0.1 to 10
msg.pitch = 2; // From 0 to 2
msg.text = text;
msg.lang = 'it';
synth.speak(msg);
} 
function pause_text(){
  synth.pause();
}
function resume_text(){
  synth.resume();
}
</script>
<div id="loading" style="display:none;"></div>
</body>
</html>
