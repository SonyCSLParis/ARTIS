
<?php
// Start the session
session_start();

?>
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 



if ($_GET["ideli"]<>""){
$qrydel ="delete  from tab_synset where id_synset=".$_GET["ideli"];
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
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Gestione esercizio (IT)</h1>
           
        <!-- /.col -->
          
          </div>
        <div class="col-sm-1">
        <a href="elenco_esercizio4.php"> <i class="fas fa-undo-alt"></i></a>
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
$qry ="select * from tab_word where id_word=".$_GET["id"]."";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<h3 class="card-title"><?php echo $val["word"]?> </h3>


</div>

<div class="card-body" >
<div class="form-group">



<input type="hidden" value="<?php echo str_replace("\"","",$val["text"]);?>" name="text">
<?php echo str_replace("\"","",$val["text"]);


}

?>



</div>
<input type="submit"   class="btn btn-info" name="butt" value="Salva modifiche">

</div>
<div class="card-footer">


<div class="row" style="height:400px;overflow-y:scroll;">
  <div class="col-lg-12">
  <table class="table table-hover ">
<thead>
<tr>
<th>parola</th>
<th>definizione</th>

<th>Immagine</th>

<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php

$qry1="select * from tab_synset where id_word=".$_GET["id"]." and giusto=1";
$rs1 = connetti($qry1);
while ($value = mysqli_fetch_array($rs1)) {
  ?>
   <tr><td><?php echo $value["word"]?></td>
   <td width="70%"><?php echo $value["definition"]?></td>
   <td>    <input type="hidden" name="imgtext<?php echo $value["id_synset"];?>" value="<?php echo $value["img"];?>" id="imgtext<?php echo $value2["id_synset"];?>"> 
   <img id="img<?php echo $value2["id_synset"];?>" src="<?php echo $value["img"];?>" width="100" style="border-style: solid;"></td>
   <td>
   <a href="?id=<?php echo $_GET["id"]?>&ideli=<?php echo $value["id_synset"];?>" title="Elimina la frase "><i class="fas fa-times-circle"></i></a></td></tr>
   
     
   
     
     
   
    

     
     
 

  <?php

      
  
}?>
<tr><td colspan="4"><hr></td></tr>
<?php

$qry1="select * from tab_synset where id_word=".$_GET["id"]." and giusto=0";
$rs1 = connetti($qry1);
while ($value = mysqli_fetch_array($rs1)) {
  ?>
   <tr><td><?php echo $value["word"]?></td>
   <td width="70%"><?php echo $value["definition"]?></td>
   <td>    <input type="hidden" name="imgtext<?php echo $value["id_synset"];?>" value="<?php echo $value["img"];?>" id="imgtext<?php echo $value2["id_synset"];?>"> 
   <img id="img<?php echo $value2["id_synset"];?>" src="<?php echo $value["img"];?>" width="100" style="border-style: solid;"></td>
   <td>
   <a href="?id=<?php echo $_GET["id"]?>&ideli=<?php echo $value["id_synset"];?>" title="Elimina la frase "><i class="fas fa-times-circle"></i></a></td></tr>
   
     
   
     
     
   
    

     
     
 

  <?php

      
  
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
<input type="hidden" id="cerca_input">
<input type="text" value="" id="cerca_parola">
<button id="but_img" onclick="ricalcola_box('it')">Cerca</button>
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
      $("#cerca_input").attr("value",input);
      $("#cerca_parola").attr("value",testo);
      $("#modal_img").empty()
      for (var x in data){
        urlimg=data[x].replace("'","")
       // console.log(urlimg);
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
function ricalcola_box(lang){
 

 var testo = $("#cerca_parola").val()

input = $("#cerca_input").val()
$.ajax({
 type: 'POST',
 url: "http://93.147.158.9:5002/see_another",
 data: JSON.stringify ({word: testo,language:lang}),
 success: function(data) { 
   var txt="";
   $('#loading').hide();
   $("#modal_img").empty()
   for (var x in data){
   
     urlimg=data[x].replace("'","")

     txt = txt + "<img src='"+urlimg+"' width='100' onclick=\"aggiornaimg('"+input+"','"+urlimg+"','"+lang+"','"+testo+"')\"><br>";
   }

   $("#modal_img").append(txt.replace("undefined",""))
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



 // $("#testo"+id).attr("value",testo);


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
