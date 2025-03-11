
<?php
// Start the session
session_start();
if ($_POST["text"]<> ""){


$url = 'http://93.147.158.9:5002/run_all';
$ch = curl_init( $url );
$data=$_POST["text"];

$payload = json_encode( array( "text"=> $data ,"language"=> "it") );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$result = curl_exec($ch);



}
?>
     <?php if($_GET["suitable"]<>"0" && $_GET["suitable"]<>"" && $_GET["title"]<>"0" || $_GET["title"]<>"" ){
    $_SESSION["id_text"]=$_GET["title"];
     }
     ?>
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 
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

<?php include "../../navbar.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Testo</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
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
<h3 class="card-title">INSERIRE TESTO</h3>


</div>

<div class="card-body" >
<div class="form-group">
<label>Textarea</label>
<textarea class="form-control" rows="10" name="text" placeholder="Enter ..."><?php echo $_POST["text"]?></textarea>
</div>
</div>
<div class="card-footer">
<button type="submit" class="btn btn-info">Salva</button>
<button type="submit" class="btn btn-default float-right">Cancel</button>
</div>
</div>
  
<?php

 $pp =json_decode($result, true);
$x =0;
foreach($pp  as $value) {
  $x=$x+1;?><br>
<?php echo $value[2]['stringa']?><br>
<input type="text" id="stest1<?php echo $x;?>"   name="stest1<?php echo $x;?>" value="<?php echo $value[0]['keywords'][0]?>">
<a href="#" onclick="alternative_img('imgplus<?php echo $x;?>')" >img alternative</a>
<a href="#" onclick="ricalcola('stest1<?php echo $x;?>')" >reload</a>
<img src="<?php echo $value[1]['picture'][0][0];?>" width="250" style="border-style: solid;">
<div id="imgplus<?php echo $x?>" style="display:none;">
<?php 
$pp1 =$value[1]['picture'][0];
foreach($pp1  as $value1) {?>
<img src="<?php echo $value1;?>" width="50">
<?php } ?>
</div>

<br><input type="text" id="stest2<?php echo $x;?>"  name="test2<?php echo $x;?>" value="<?php echo $value[0]['keywords'][1]?>">
<a href="#" onclick="alternative_img('imgplus2<?php echo $x;?>')" >img alternative</a>
<a href="#" onclick="ricalcola('stest2<?php echo $x;?>')" >ricalcola</a>
<img src="<?php echo $value[1]['picture'][1][0];?>" width="250">
<div id="imgplus2<?php echo $x?>" style="display:none;">
<?php 
$pp1 = $value[1]['picture'][1];
foreach($pp1  as $value1) {?>
<img src="<?php echo $value1;?>" width="50">
<?php } ?>
</div>

<?php 

  
   
  
}?>

   
</div>
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
function ricalcola(input){
  console.log(input)
var testo = $("#"+input).val()
  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/see_another",
    data: JSON.stringify ({word: testo}),
    success: function(data) { 
      
      
      alert('data: ' + data);
    
    
    
    },
    contentType: "application/json",
    dataType: 'json'
});
 
}

function alternative_img(div){
if ($("#"+div).is(':visible')==false){

  $("#"+div).show();
}else{
  $("#"+div).hide();
}


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
