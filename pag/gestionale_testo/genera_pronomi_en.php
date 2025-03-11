
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
if($_GET["idattiva"]<>""){
  $qryinsert = "update  tab_confirm set 
  esercizi3=1
   where id_text =".$_GET["idattiva"]." and lang ='en'
   ";
$rsins = connetti($qryinsert);

}
if($_GET["eliword"]<>""){

  $qrydel ="delete from tab_pronouns where id_pronouns=".$_GET["eliword"];
  $rsdel = connetti($qrydel);
  
  }

if ($_POST["Genera"]== "Genera Pronomi"){
  $qrydel ="delete  from tab_pronouns where  id_text=".$_GET["id"]." and lang='".$_POST["language"]."'" ;
  $rsdel =connetti($qrydel);
  $qryinsert = "update  tab_confirm set 
  esercizi3=0
   where id_text =".$_GET["id"]." and lang ='en'
   ";
$rsins = connetti($qryinsert);
  $url = 'http://93.147.158.9:5002/pronouns';
  $ch = curl_init( $url );
$data=str_replace("\"","",$_POST["text"]);
$payload = json_encode( array( "text"=> $data ,"language"=> $_POST["language"],"id"=>$_GET["id"]) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = curl_exec($ch); 
$pp =json_decode($result, true);
//print_r($pp);

$x =0;
foreach($pp  as $value) {
   // print_r($value[0]['frase']);
   // print_r($value[1]['pronome']);
   // print_r($value[2]['option'][0]);
   // print_r($value[2]['option'][1]);
   // print_r($value[2]['option'][2]);
   // print_r($value[2]['option'][3]);
    
    $x=$x+1;
     $qryins="insert into tab_pronouns set 
     id_text=".$_GET["id"].",
     frase ='".addslashes($value[0]['frase'])."',
     pronome ='".addslashes($value[1]['pronome'])."',
     r1 ='".addslashes($value[2]['option'][0])."',
     r2 ='".addslashes($value[2]['option'][1])."',
     r3 ='".addslashes($value[2]['option'][2])."',
     r4 ='".addslashes($value[2]['option'][3])."',
    
     lang='".$_POST["language"]."'
   ";
  
    $rsins = connetti($qryins);
  }
}




if($_POST["pul_aggiorna"]=="Salva modifiche"){

  $qry ="select * from tab_pronouns where id_text =".$_GET["id"]." and lang='en' ";
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
    $qryup ="update tab_pronouns set
    frase ='".addslashes($_POST["frase".$val["id_pronouns"]])."',
    pronome ='".addslashes($_POST["pronome".$val["id_pronouns"]])."',
    r1 ='".addslashes($_POST["r1-".$val["id_pronouns"]])."',
    r2 ='".addslashes($_POST["r2-".$val["id_pronouns"]])."',
    r3 ='".addslashes($_POST["r3-".$val["id_pronouns"]])."',
    r4 ='".addslashes($_POST["r4-".$val["id_pronouns"]])."'
   
  
    where id_pronouns =".$val["id_pronouns"]."";
  
    $qryup=connetti($qryup);
  
  }


}
  


?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>

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
            <h1 class="m-0" align="center">Genera Esercizio pronomi (EN)</h1>
           
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
<div class="card-header">  <?php
$qry ="select * from tab_text where id_text=".$_GET["id"]."";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<h3 class="card-title"><?php echo $val["title_en"]?> <?php echo controlla_attivo(6,'en',$_GET["id"])?></h3>


</div>

<div class="card-body" >
<div class="form-group">



<input type="hidden" value="<?php echo str_replace("\"","",$val["text_en"]);?>" name="text">
<?php echo str_replace("\"","",$val["text_en"]);


}

?>




</div>
</div>
<div class="card-footer">

<input type="hidden" value="en" name="language">
<input type="submit" name="Genera" value="Genera Pronomi" class="btn btn-info">

</form> 
<table class="table table-hover text-nowrap">
<thead>
<tr>

<th>Frase</th>
<th>Pronome</th>
<th>opz1</th>
<th>opz2</th>
<th>opz3</th>
<th>opz4</th>
<th>&nbsp;</th>


</tr>
</thead>
<tbody>
  <form method="post" action="?id=<?php echo $_GET["id"]?>">

<?php

$y=0;
$qry ="select * from tab_pronouns where id_text =".$_GET["id"]." and lang='en' ";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
?>
<tr>
  <td>
<input type="text" id="frase<?php echo $val["id_pronouns"];?>" name="frase<?php echo $val["id_pronouns"];?>" size="20" value="<?php echo $val["frase"] ?>" >
</td>
<td>
<input type="text" id="pronome<?php echo $val["id_pronouns"];?>" name="pronome<?php echo $val["id_pronouns"];?>" size="10" value="<?php echo $val["pronome"] ?>" >

</td>
<td>
<input type="text" id="r1-<?php echo $val["id_pronouns"];?>" name="r1-<?php echo $val["id_pronouns"];?>" size="10" value="<?php echo $val["r1"] ?>" >

</td>
<td>
<input type="text" id="r2-<?php echo $val["id_pronouns"];?>" name="r2-<?php echo $val["id_pronouns"];?>" size="10" value="<?php echo $val["r2"] ?>" >

</td>
<td>
<input type="text" id="r3-<?php echo $val["id_pronouns"];?>" name="r3-<?php echo $val["id_pronouns"];?>" size="10" value="<?php echo $val["r3"] ?>" >

</td>
<td>
<input type="text" id="r4-<?php echo $val["id_pronouns"];?>" name="r4-<?php echo $val["id_pronouns"];?>" size="10" value="<?php echo $val["r4"] ?>" >

</td>
<td>
<a href="?id=<?php echo $_GET["id"]?>&eliword=<?php echo $val["id_pronouns"]?>"><i class="fas fa-times-circle"></i></a> 
</td>

</tr>





<?php
}

?>
<input type="submit" name="pul_aggiorna"  class="btn btn-info" value="Salva modifiche">&nbsp;
<a href="?id=<?php echo $_GET["id"];?>&idattiva=<?php echo $_GET["id"];?>&l=en"><div class="btn btn-info" >Attiva</div> </a>
</form>
</tbody>
</table>

<br><br><br>



</div>
</div>

   
</div>
</div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-l" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-l">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title"><span id="title_img"></span></h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">

<span id="modal_img"></spoan>
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
<script> 
function ricalcola(input,lang){
  console.log(input)
  if (lang=="it"){
    var testo = $("#par"+input).val()
  }else{
    var testo = $("#testo_en"+input).val()
  }

  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/see_another",
    data: JSON.stringify ({word: testo,language:lang}),
    success: function(data) { 
      var txt;
      $("#title_img").empty()
      $("#title_img").append(testo)
      $("#modal_img").empty()
      for (var x in data){
        urlimg=data[x].replace("'","")
        console.log(urlimg);
        txt = txt + "<img src='"+urlimg+"' width='100' onclick=\"aggiornaimg('"+input+"','"+urlimg+"','"+lang+"','"+testo+"')\"><br>";
      }
      $("#modal_img").append(txt)
      $("#modal-l").modal('show');
     // alert('data: ' + data);
    
    
    
    },
    contentType: "application/json",
    dataType: 'json'
});
 
}
function aggiornaimg(id,urlimg,lang,testo){

console.log(id)
console.log(urlimg)
console.log(lang)
$("#img"+id).attr("src",urlimg);

$("#imgtext"+id).attr("value",urlimg);


if (lang=="it"){
  $("#testo"+id).attr("value",testo);
}else{
  $("#testo_en"+id).attr("value",testo);
}

$("#modal-l").modal('hide');

}
function alternative_img(div){
if ($("#"+div).is(':visible')==false){

  $("#"+div).show();
}else{
  $("#"+div).hide();
}


}
function visualizza_riga(idq){

$(".riga"+idq).show();



}

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
</body>
</html>
