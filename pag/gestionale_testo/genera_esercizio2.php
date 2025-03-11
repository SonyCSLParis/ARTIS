
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
  esercizi2=1
   where id_text =".$_GET["idattiva"]." and lang ='it'
   ";
$rsins = connetti($qryinsert);

}
if($_POST["pul_aggiungiR"]=="Aggiungi"){


$qry3="select * from tab_question where id_text=".$_GET["id"];
$rs3 = connetti($qry3);
while ($val3=mysqli_fetch_array($rs3)){


 if ($_POST["rispo".$val3["id_question"]]!=""){

  $qryiunse = "insert into tab_response set
  id_question=".$val3["id_question"].",
  response = '".addslashes($_POST["rispo".$val3["id_question"]])."'";

 $rsinser=connetti($qryiunse);

  $qryup ="update tab_question set multi =1 where id_question=".$val3["id_question"];
  $rsup = connetti($qryup);
 }


}


}
if($_GET["elirispo"]<>""){

$qrydel ="delete from tab_response where id_response=".$_GET["elirispo"];
echo $qrydel;
$rsdel = connetti($qrydel);

}
if($_GET["eliquest"]<>""){
$qrydel="delete from tab_question where id_question=".$_GET["eliquest"];
$rsdel =connetti($qrydel);

  $qrydel ="delete from tab_response where id_question=".$_GET["eliquest"];

  $rsdel = connetti($qrydel);
  
  }

if ($_POST["pul_aggiungi"]=="Aggiungi"){
$qryp = "select max(tab_question.order) as maxo ,min(tab_question.order)as mino from tab_question where id_exercise=2";
$rsp = connetti($qryp);
$valp = mysqli_fetch_array($rsp);
if ($_POST["posizione"]=="0"){
$pos =  $valp["mino"]-1;

}else{
  $pos =  $valp["maxo"]+1;
}

$qryins ="insert into  tab_question set 
id_exercise = 2,
id_text=".$_GET["id"].",
question ='".addslashes($_POST["newquest"])."',
multi=0,
lang='it',
tab_question.order=".$pos;
$rsins = connetti($qryins);


}




if ($_POST["Genera"]== "Genera Domande"){

  $qryinsert = "update  tab_confirm set 
  esercizi2=0
   where id_text =".$_GET["id"]." and lang ='it'
   ";
$rsins = connetti($qryinsert);

$qryf ="select * from tab_question where id_text=".$_GET["id"]." and id_exercise=2 and lang='it'";
$rsf = connetti($qryf);
while ($valf=mysqli_fetch_array($rsf)){

  $qrydel ="delete from tab_response where id_question=".$valf["id_question"];

  $rsdel = connetti($qrydel);

}
$qrydel ="delete from tab_question where id_text=".$_GET["id"]." and id_exercise=2 and lang='it'";
$rsdel =connetti($qrydel);

  $url = 'http://93.147.158.9:5002/get_most_difficult_words';

  $data=str_replace("\"","",$_POST["text"]);

  
  $ch = curl_init( $url );


$payload = json_encode( array( "text"=> $data ,"language"=> $_POST["language"],"id"=>$_GET["id"]) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$result = curl_exec($ch);
  
  
$pp =json_decode($result, true);
$x =0;
foreach($pp  as $value) {
    $x=$x+1;
 
     $qryins="insert into tab_question set 
     id_exercise = 2,
     id_text=".$_GET["id"].",
     question ='Cosa significa ".$value." ?',
     multi=0,
     lang='it',
     tab_question.order=".$x."";
 
    $rsins = connetti($qryins);
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
            <h1 class="m-0" align="center">Genera Esercizio finale (IT)</h1>
          
          </div>
        <div class="col-sm-1">
        <a href="elenco.php"> <i class="fas fa-undo-alt"></i></a>
        <!-- /.col -->
        
        </div><!-- /.row -->  <hr>
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
<h3 class="card-title"><?php echo $val["title"]?> <?php echo controlla_attivo(5,'it',$_GET["id"])?></h3>


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
<input type="hidden" value="it" name="language" checked>

<input type="submit" name="Genera" value="Genera Domande" class="btn btn-info">
&nbsp;
<a href="?id=<?php echo $_GET["id"];?>&idattiva=<?php echo $_GET["id"];?>&l=it"><div class="btn btn-info" >Attiva</div> </a>

<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>N.</th>
<th>Domanda</th>
<th>Opzioni</th>
<th>&nbsp;</th>


</tr>
</thead>
<tbody>
  <form method="post" action="?id=<?php echo $_GET["id"]?>">
  <tr><td>
<select name="posizione"><option value="0">Aggiungi sopra</option>
<option value="1">Aggiungi sotto</option></td>
<td>
<input type="text" name="newquest" size="50" value="" >
</td>
<td></td>
<td><input type="submit" class="btn btn-info" value="Aggiungi" name="pul_aggiungi">
</td>

</tr>
<?php

$y=0;
$qry ="select * from tab_question where id_text =".$_GET["id"]." and id_exercise=2 and lang='it' order by tab_question.order";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
?>
<tr><td>
  <?php echo $y++;?></td>
  <td>
<input type="text" name="quest<?php echo $val["id_question"];?>" size="50" value="<?php echo $val["question"] ?>" ><br>

</td>
<td><input type="checkbox" onclick='visualizza_riga(<?php echo $val["id_question"]?>)' name="multi<?php echo $val["id_question"]?>" value="1" <?php if ($val["multi"]=="1"){echo "checked";}?>> </td>
<td><a href="?id=<?php echo $_GET["id"]?>&eliquest=<?php echo $val["id_question"]?>"><i class="fas fa-times-circle"></i></a> 
</td>

</tr>


<tr class="riga<?php echo $val["id_question"]?>" style="display:none;"><td>
  Risposte</td>
  <td>
<input type="text" name="rispo<?php echo $val["id_question"];?>" size="50" value="" >
</td>
<td> </td>
<td><input type="submit" class="btn btn-info" value="Aggiungi" name="pul_aggiungiR">
</td>

</tr>
<?php $qry1="select * from tab_response where id_question=".$val["id_question"];
$rs1 = connetti($qry1);
while($val1=mysqli_fetch_array($rs1)){?>

<tr class="riga<?php echo $val["id_question"]?>"  style="display:none;"><td>
  Risposte</td>
  <td>
<?php echo $val1["response"];?>
</td>
<td> </td>
<td><a href="?id=<?php echo $_GET["id"]?>&elirispo=<?php echo $val1["id_response"]?>"><i class="fas fa-times-circle"></i></a> 
</td>

</tr>


<?php }?>



<?php
}

?>
</form>
</tbody>
</table>





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


  <div class="modal fade" id="modal-multi" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-l">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title"><span id="title_multi"></span></h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">

<span id="modal_multi_text"></spoan>
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
