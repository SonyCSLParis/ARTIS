
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
  visualizza_testo=1
   where id_text =".$_GET["idattiva"]." and lang ='en'
   ";
$rsins = connetti($qryinsert);

}
if ($_GET["ideli"]<>""){
$qrydel ="delete  from tab_map where id_map=".$_GET["ideli"];
$rsdel = connetti($qrydel);

}

if($_POST["butt"]=="Salva modifiche"){

  $qry1="select * from tab_map where id_text=".$_GET["id"]." and lang='en'";
  $rs1 = connetti($qry1);
  while ($value = mysqli_fetch_array($rs1)) {
    $qry2 = "select * from tab_keyword where id_map =".$value["id_map"];
    $rs2 = connetti($qry2);
    while ($value2 = mysqli_fetch_array($rs2)){


       
        $new_key = $_POST["testo" . $value2["id_keyword"]];
      
        $new_img = $_POST["imgtext".$value2["id_keyword"]];

        $qryup ="update tab_keyword set
        keyw = '".$new_key."',
       
        img ='".$new_img."'
        where id_keyword = ".$value2["id_keyword"];

        $rsup = connetti($qryup);


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
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Gestione Mappa (EN)</h1>
           
        <!-- /.col -->
          
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
       
      <form method="post" action="?id=<?php echo $_GET["id"]?>">         

<input type="hidden" name="vai" value="vai">



<div class="row">
  <div class="col-lg-12">

    <div class="card card-primary">
<div class="card-header">
<?php
$qry ="select * from tab_text where id_text=".$_GET["id"]." ";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<h3 class="card-title"><?php echo $val["title_en"]?> <?php echo controlla_attivo(2,'en',$_GET["id"])?></h3>


</div>

<div class="card-body" >
<div class="form-group">



<input type="hidden" value="<?php echo str_replace("\"","",$val["text_en"]);?>" name="text">
<?php echo str_replace("\"","",$val["text_en"]);


}

?>

<br><br>

</div>
<input type="submit"   class="btn btn-info" name="butt" value="Salva modifiche">
<a href="?id=<?php echo $_GET["id"];?>&idattiva=<?php echo $_GET["id"];?>&l=en"><div class="btn btn-info" >Attiva</div> </a>
</div>
<div class="card-footer">


<div class="row" style="height:400px;overflow-y:scroll;">
  <div class="col-lg-12">
  <table class="table table-hover ">
<thead>
<tr>
<th></th>
<th>Frase/Keywords</th>
<th>&nbsp;</th>
<th>Immagine</th>


</tr>
</thead>
<tbody>
<?php

$qry1="select * from tab_map where id_text=".$_GET["id"]." and lang='en'";
$rs1 = connetti($qry1);
while ($value = mysqli_fetch_array($rs1)) {
  ?>
   <tr><td></td><td colspan="4"><?php echo $value["text"]?><a href="?id=<?php echo $_GET["id"]?>&ideli=<?php echo $value["id_map"];?>" title="Elimina la frase "><i class="fas fa-times-circle"></i></a></td></tr>
   <tr><td>Semplificato</td><td colspan="4"><?php echo $value["text_simp"]?><a href="?id=<?php echo $_GET["id"]?>&ideli=<?php echo $value["id_map"];?>" title="Elimina la frase "><i class="fas fa-times-circle"></i></a></td></tr> 
    <?php $qry2= "select * from tab_keyword where id_map =".$value["id_map"];
    $rs2 = connetti($qry2);
    while ($value2 = mysqli_fetch_array($rs2)){
      ?>
      <tr><td></td>
      <td><input type="text" name="testo<?php echo $value2["id_keyword"];?>" id="testo<?php echo $value2["id_keyword"];?>" value="<?php echo $value2["keyw"]; ?>"></td>
      <td><a href="#" onclick='ricalcola("<?php echo $value2["id_keyword"];?>","en")'><i class="fas fa-sync-alt"></i></a></TD>
      <td > 
      <input type="hidden" name="imgtext<?php echo $value2["id_keyword"];?>" value="<?php echo $value2["img"];?>" id="imgtext<?php echo $value2["id_keyword"];?>"> 
      <img id="img<?php echo $value2["id_keyword"];?>" src="<?php echo $value2["img"];?>" width="100" style="border-style: solid;">
      </td>
    </tr>

  <?php
  } 
      
  
}?>

</tbody>

</table> 


</div>
</div>
 </form>  </div>
</div>
  
</div>
</div>     <!-- /.row -->
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
 
    var testo = $("#testo"+input).val()
  

  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/see_another",
    data: JSON.stringify ({word: testo,language:lang}),
    success: function(data) { 
      var txt="";
      $("#title_img").empty()
      $("#title_img").append(testo)
      $("#modal_img").empty()
      for (var x in data){
        urlimg=data[x].replace("'","")
        
        txt = txt + "<img src='"+urlimg+"' width='100' onclick=\"aggiornaimg('"+input+"','"+urlimg+"','"+lang+"','"+testo+"')\"><br>";
      }
      if (txt==""){
        txt ="Nessun immagine trovata";
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


$("#img"+id).attr("src",urlimg);

$("#imgtext"+id).attr("value",urlimg);



  $("#testo"+id).attr("value",testo);


$("#modal-l").modal('hide');

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
