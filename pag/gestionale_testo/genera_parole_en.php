
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
  $qryinsert = "update  tab_confirm set   visualizza_parole=1  where id_text =".$_GET["idattiva"]." and lang ='en'";
  $rsins = connetti($qryinsert);

}
if($_GET["eliword"]<>""){

  $qrydel ="delete from tab_difficult_words where id_df=".$_GET["eliword"];
  $rsdel = connetti($qrydel);
  
  }

  if ($_POST["Genera"]== "Genera parole"){

    $qrydel ="delete from tab_difficult_words where id_text =".$_GET["id"]." and lang='en'";
    $rsdel = connetti($qrydel);
      $qryinsert = "update  tab_confirm set 
      visualizza_parole=0
       where id_text =".$_GET["id"]." and lang ='en'
       ";
    $rsins = connetti($qryinsert);
      $url = 'http://93.147.158.9:5002/get_most_difficult_words';
      $ch = curl_init( $url );
    $data=str_replace("\"","",$_POST["text"]);
    $payload = json_encode( array( "text"=> $data ,"language"=> $_POST["language"],"id"=>$_GET["id"]) );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch); 
    $pp =json_decode($result, true);
    $x =0;
    foreach($pp  as $value) {
     
        $x=$x+1;
         $qryins="insert into tab_difficult_words set 
         id_text=".$_GET["id"].",
         word ='".$value."',  
         lang='".$_POST["language"]."'
       ";
      
        $rsins = connetti($qryins);
      }
      $qry ="select * from tab_difficult_words where id_text =".$_GET["id"]." and lang='en'";
      $rs = connetti($qry);
      while ($val =mysqli_fetch_array($rs)){
        $url1 = 'http://93.147.158.9:5002/get_definition';
        $ch1 = curl_init( $url1 );
        $payload1 = json_encode( array( "word"=> $val["word"] ,"language"=> $val["lang"]) );
        curl_setopt( $ch1, CURLOPT_POSTFIELDS, $payload1 );
        curl_setopt( $ch1, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, true );
        $result1 = curl_exec($ch1); 
          $qryup ="update tab_difficult_words set
          definition ='".addslashes($result1)."'
          where id_df =".$val["id_df"]."";
          $rsup = connetti($qryup);
      }
      $qry1 ="select * from tab_text where id_text=".$_GET["id"]."";
      $rs1= connetti($qry1);
      while($val1=mysqli_fetch_array($rs1)){
         $text = $val1["text_en"];
    
      }
      $qry = "select * from tab_difficult_words where id_text =".$_GET["id"]." and lang='en'";
      $rs = connetti($qry);
      while($val =mysqli_fetch_array($rs)){
    
        $url = 'http://93.147.158.9:5002/extract_sentence_token';
        $ch = curl_init( $url );
        $data=str_replace("\"","",$text);
        $payload = json_encode( array( "text"=> $data , "token"=> $val["word"], "language"=> $_POST["language"]) );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        
        $result = curl_exec($ch); 

        if ($result!='KO'){
    
      
          $qryins="update  tab_difficult_words set 
          
          frase ='".addslashes($result)."'
          where id_df =".$val["id_df"]."
        ";
    
        $rsins = connetti($qryins);
        } 
    
    }
    $qry ="select * from tab_difficult_words where id_text =".$_GET["id"]." and lang='en'";
    $rs = connetti($qry);
    while ($val =mysqli_fetch_array($rs)){
    
      $url1 = 'http://93.147.158.9:5002/see_another';
      $ch1 = curl_init( $url1 );
      $payload1 = json_encode( array( "word"=> $val["word"] ,"language"=> $val["lang"]) );
      curl_setopt( $ch1, CURLOPT_POSTFIELDS, $payload1 );
      curl_setopt( $ch1, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, true );
      $result1 = json_decode(curl_exec($ch1)); 
       $qryins="update  tab_difficult_words set   
       img ='".addslashes($result1[0])."'
       where id_df =".$val["id_df"]."
     ";
     $rsins = connetti($qryins);
    }
    ?>
    <script>
       $("#loading").hide();
       console.log("hide");
      </script>
    <?php
    }





if($_POST["pul_aggiorna"]=="Salva modifiche"){

  $qry ="select * from tab_difficult_words where id_text =".$_GET["id"]." and lang='en'";
  $rs = connetti($qry);
  while ($val =mysqli_fetch_array($rs)){
    $qryup ="update tab_difficult_words set
    word = '".addslashes($_POST["par".$val["id_df"]])."',
    definition ='".addslashes($_POST["def".$val["id_df"]])."',
    frase ='".addslashes($_POST["frase".$val["id_df"]])."',
    img ='".$_POST["imgtext".$val["id_df"]]."'
    where id_df =".$val["id_df"]."";
  
    $qryup=connetti($qryup);
  
  }


}
  


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
            <h1 class="m-0" align="center">Gestione parole difficili, frasi, definizioni e immagini EN</h1>
            
          </div>
        <div class="col-sm-1">
        <a href="elenco.php"> <i class="fas fa-undo-alt"></i></a>
        <!-- /.col -->
        
        </div><!-- /.row --><hr>
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
$qry ="select * from tab_text where id_text=".$_GET["id"]."";

$rs= connetti($qry);
while($val=mysqli_fetch_array($rs)){?>
<h3 class="card-title"><?php echo str_replace("\"","",$val["title_en"]);?><?php echo controlla_attivo(3,'en',$_GET["id"])?></h3>


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
<input type="hidden" value="en" name="language" >
<input type="submit" name="Genera" value="Genera parole" onclick="$('#loading').show();" class="btn btn-info">

</form> 
<table class="table table-hover text-nowrap">
<thead>
<tr>

<th>Parola</th>
<th>Definizione</th>
<th>Frase</th>
<th>Immagine</th>
<th>&nbsp;</th>


</tr>
</thead>
<tbody>
  <form method="post" action="?id=<?php echo $_GET["id"]?>">

<?php

$y=0;
$qry ="select * from tab_difficult_words where id_text =".$_GET["id"]." and lang='en'";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
?>
<tr>
  <td>
<input type="text" id="par<?php echo $val["id_df"];?>" name="par<?php echo $val["id_df"];?>" size="20" value="<?php echo $val["word"] ?>" >
</td>
<td>
<textarea name="def<?php echo $val["id_df"];?>" cols="20" rows="5" id="def<?php echo $val["id_df"];?>"  ><?php echo $val["definition"] ?></textarea>
<a href="#" onclick='ricalcola_def("<?php echo $val["id_df"];?>","en")' title="Cerca una nuova definizione"><i class="fas fa-sync-alt"></i></a>

</td>
<td ><textarea name="frase<?php echo $val["id_df"];?>" cols="20" rows="5" ><?php echo $val["frase"] ?></textarea></td>
<td>
<input type="hidden" name="imgtext<?php echo $val["id_df"];?>" value="<?php echo $val["img"];?>" id="imgtext<?php echo $val["id_df"];?>"> 
      <img id="img<?php echo $val["id_df"];?>" src="<?php echo $val["img"];?>" width="100" style="border-style: solid;"></td>
<td><a href="#" onclick='ricalcola("<?php echo $val["id_df"];?>","en")'><i class="fas fa-sync-alt"></i></a>
<a href="?id=<?php echo $_GET["id"]?>&eliword=<?php echo $val["id_df"]?>"><i class="fas fa-times-circle"></i></a> 
</td>

</tr>




<?php
}

?>
<input type="submit" name="pul_aggiorna" class="btn btn-info" value="Salva modifiche">&nbsp;
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

    var testo = $("#par"+input).val()


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
function ricalcola_def(input,lang){
  console.log(input)
  
    var testo = $("#par"+input).val()
 
console.log(testo)
  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/get_definition_json_all",
    data: JSON.stringify ({word: testo,language:lang}),
    success: function(data) { 
      var txt="";
      $("#title_img").empty()
      $("#title_img").append(testo)
      $("#modal_img").empty()
  
      for (var x in data){
      
        console.log(data[x])
  
        txt = txt +"<div  onclick=\"aggiornadef('"+input+"','"+data[x]+"','"+lang+"','"+testo+"')\">"+  data[x]+"</div><hr>"
      }
    
      $("#modal_img").append(txt.replace("undefined",""))
      $("#modal-l").modal('show');
     // alert('data: ' + data);
    
    
    
    },
    contentType: "application/json",
    dataType: 'json'
});
 
}

function aggiornadef(id,urlimg,lang,testo){

console.log(id)
console.log(urlimg)
console.log(lang)





if (lang=="it"){
 
  $("#def"+id).attr("value",'La definizione di '+testo+" è '"+ urlimg+"'");
}else{
 
  $("#def"+id).attr("value",'The definition of  '+testo+" is '"+ urlimg+"'");
}

$("#modal-l").modal('hide');

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
<div id="loading" style="display:none;"></div>
</body>
</html>
