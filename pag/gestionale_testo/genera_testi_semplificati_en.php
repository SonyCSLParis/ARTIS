
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
if ($_POST["pul1"]== "Salva modifiche"){
  $qry ="select * from tab_map where id_text =".$_GET["id"]." and lang='en'  ";
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){ 

    $textup=$_POST["semplifica".$val["id_map"]];
    $qryupdate ="update tab_map set text_simp ='".addslashes($textup)."' where id_map = ".$val["id_map"];
    $rsup = connetti($qryupdate);

  }


}


if ($_POST["pul"]== "Semplifica"){
  $qry ="select * from tab_map where id_text =".$_GET["id"]." and lang='en' ";
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){ 
          $url = 'http://93.147.158.9:5002/simplify_sentence';
          $ch = curl_init( $url );
        $data=$val["text"];
        $payload = json_encode( array( "text"=> $data ,"language"=> "english") );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch); 
        $pp =json_decode($result, true);
        $textup = $pp['simplified_output'];
        $qryupdate ="update tab_map set text_simp ='".addslashes($textup)."' where id_map = ".$val["id_map"];
        $rsup = connetti($qryupdate);

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
            <h1 class="m-0" align="center">Generazione del testo semplificato EN</h1>
           
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
<div class="card-header">
<?php
$qry ="select * from tab_text where id_text=".$_GET["id"]."  ";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<h3 class="card-title"><?php echo str_replace("\"","",$val["title_en"]);?></h3>


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



<table class="table table-hover text-nowrap">
<thead>
<tr>

<th>Frase</th>

<th>&nbsp;</th>


</tr>
</thead>
<tbody>
  <form method="post" action="?id=<?php echo $_GET["id"]?>">

<?php

$y=0;
$qry ="select * from tab_map where id_text =".$_GET["id"]."  and lang='en' ";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
?>
<tr>
  <td>
<input type="text" id="frase<?php echo $val["id_map"];?>" name="frase<?php echo $val["id_map"];?>" size="50" value="<?php echo $val["text"] ?>" >
</td>
<td><input type="text" id="semplifica<?php echo $val["id_map"];?>" size="50"  name="semplifica<?php echo $val["id_map"];?>" value="<?php echo $val["text_simp"] ?>"></td>

</tr>





<?php
}

?>
<input type="submit" class="btn btn-info"  name="pul" value="Semplifica">
<input type="submit" class="btn btn-info"  name="pul1" value="Salva modifiche">
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
