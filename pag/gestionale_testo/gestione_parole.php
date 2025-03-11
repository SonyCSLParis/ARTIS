
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

if($_GET["eliword"]<>""){

  $qrydel ="delete from tab_img where id_img=".$_GET["eliword"];
  $rsdel = connetti($qrydel);
  
  }



if($_POST["pul_aggiorna"]=="Salva modifiche"){
  $qry ="select * from tab_img  ";
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
    $qryup ="update tab_img set
    word = '".addslashes($_POST["par".$val["id_img"]])."',
   
    img ='".$_POST["imgtext".$val["id_img"]]."'
    where id_img =".$val["id_img"]."";
    $qryup=connetti($qryup);
  }
}
  
function sovrascrivi_img($tab,$campo1,$campo2,$word,$img){
 
    $qup="update ".$tab." set 
    ".$campo2."='".$img."' 
    where ".$campo1."='".$word."";
  $rs=connetti($qup);
  

}
if($_GET["aggiorna_tutto"]<>""){

  $qry ="select * from tab_img  where id_img=".$_GET["aggiorna_tutto"];
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
      sovrascrivi_img("tab_difficult_word","word","img",$val["word"],$val["img"]);
      sovrascrivi_img("tab_keyword","keyw","img",$val["word"],$val["img"]);
      sovrascrivi_img("tab_keyword_exe","keyword","img",$val["word"],$val["img"]);
      sovrascrivi_img("tab_synset","word","img",$val["word"],$val["img"]);
      sovrascrivi_img("tab_synset_df","word","img",$val["word"],$val["img"]);
  }

}
// tab_difficult_word: word img
// tab_keyword keyw img

// tab_keyword_exe keyword img
//tab_synset word img
//tab_synset_df word img
?>

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
<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
        <div class="col-sm-11">
          <h1 class="m-0" align="center">Gestione parole immagini</h1>
         
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

    <div class="card card-primary" width="100%">
<div class="card-header">
<?php

?>




</div>
</div>
<div class="card-footer">
<input type="hidden" value="it" name="language" >


</form> 
<table id="example1" class="table table-hover text-nowrap">
<thead>
<tr>

<th>Parola</th>
<th>Mod Parola</th>
<th>Immagine</th>
<th>&nbsp;</th>


</tr>
</thead>
<tbody>
  <form method="post" action="">

<?php

$y=0;
$qry ="select * from tab_img";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
?>



<tr>
  <td><?php echo $val["word"] ?></td><td>
<input type="text" id="par<?php echo $val["id_img"];?>" name="par<?php echo $val["id_img"];?>" size="20" value="<?php echo $val["word"] ?>" >
</td>

<td>
<input type="hidden" name="imgtext<?php echo $val["id_img"];?>" value="<?php echo $val["img"];?>" id="imgtext<?php echo $val["id_img"];?>"> 
      <img id="img<?php echo $val["id_img"];?>" src="<?php echo $val["img"];?>" width="100" style="border-style: solid;"></td>
<td><a href="#" onclick='ricalcola("<?php echo $val["id_img"];?>","it")' title="cerca una nuova immagine"><i class="fas fa-sync-alt"></i></a>
<a href="?id=<?php echo $_GET["id"]?>&eliword=<?php echo $val["id_img"]?>"><i class="fas fa-times-circle"></i></a> 
<a href="?aggiorna_tutto=<?php echo $_GET["id_img"]?>"><i class="fas fa-upload"></i></a> 
</td>

</tr>


<?php
}

?>
<input type="submit" name="pul_aggiorna" class="btn btn-info" value="Salva modifiche">&nbsp;

</form>
</tbody>
</table>

<br><br><br>




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
<input type="hidden" id="cerca_input">
<input type="text" value="" id="cerca_parola">
<button id="but_img" style="display:none;" onclick="ricalcola_box('it')">Cerca</button>
<button id="but_def" style="display:none;" onclick="ricalcola_box_def('it')">Cerca</button>
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
  $("#but_img").show();
  $("#but_def").hide();
  $("#cerca_parola").val(testo);
  $("#cerca_input").val(input);
  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/see_another",
    data: JSON.stringify ({word: testo,language:lang}),
    success: function(data) { 
      var txt="";
    
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
      if (txt==""){
        txt ="Non ho trovato immagini"
      }
      $("#modal_img").append(txt.replace("undefined",""))
      $("#modal-l").modal('show');
     // alert('data: ' + data);
    
    
    
    },
    contentType: "application/json",
    dataType: 'json'
});
 
}
function ricalcola_box_def(lang){

  var testo = $("#cerca_parola").val()
  $('#loading').show();
input = $("#cerca_input").val()
  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/get_definition_json_all",
    data: JSON.stringify ({word: testo,language:lang}),
    success: function(data) { 
      console.log(data);
      var txt="";
      $('#loading').hide();
      $("#modal_img").empty()

      for (var x in data){
        text_dd=data[x].replace(/'/g, "\\'");
        txt = txt +"<div style='cursor:pointer;'  onclick=\"aggiornadef('"+input+"','"+text_dd+"','"+lang+"','"+testo+"')\">"+  data[x]+"</div><hr>"
      }
      if (txt==""){
        txt = "Non ho trovato una definizione";
      }
      $("#modal_img").append(txt.replace("undefined",""))
      $("#modal-l").modal('show');
      $('#loading').hide();

    },
    contentType: "application/json",
    dataType: 'json'
});
 
}

function ricalcola_def(input,lang){
  console.log(input)
  $("#but_img").hide();
  $("#but_def").show();
 
    var testo = $("#par"+input).val()
  console.log(testo)
  $('#loading').show();
  $("#cerca_parola").val(testo);
  $("#cerca_input").val(input);
//$("#cerca_parola").attr("value",testo);

  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/get_definition_json_all",
    data: JSON.stringify ({word: testo,language:lang}),
    success: function(data) { 
      var txt="";
      $('#loading').hide();
      $("#modal_img").empty()
  
      for (var x in data){
        text_dd=data[x].replace(/'/g, "\\'");
        console.log(text_dd)
  
        txt = txt +"<div style='cursor:pointer;'  onclick=\"aggiornadef('"+input+"','"+text_dd+"','"+lang+"','"+testo+"')\">"+  data[x]+"</div><hr>"
      }
    
      $("#modal_img").append(txt.replace("undefined",""))
      $("#modal-l").modal('show');

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




function aggiornadef(id,urlimg,lang,testo){

console.log(id)
console.log(urlimg)
console.log(lang)





if (lang=="it"){
  console.log("dddd");
  $("#def"+id).empty();
  $("#def"+id).append('La definizione di '+testo+" è "+ urlimg);
}else{
  $("#def"+id).empty();
  $("#def"+id).append('La definizione di '+testo+" è "+ urlimg);
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
<div id="loading" style="display:none;"></div>
</body>
</html>
