
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

if ($_POST["pul_salva"]=="Salva"){
  $language="it";
  if($_SESSION["lang"]=="_en"){
    $language="en";
  }
  $qry ="select * from tab_question where id_text =".$_SESSION["id_text"]." and id_exercise=2 and lang='".$language."' order by tab_question.order";
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){

    $qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_exercise=2 and id_question =".$val["id_question"]." and id_version=0";
    $rsv = connetti($qryv);
    $count = mysqli_num_rows($rsv);
    if ($count >0){

      if ($val["multi"]==0){


        $qryinsert ="update tab_result set
     
        result = '".addslashes($_POST["risposta".$val["id_question"]])."',
        id_response=0,
        multi=0
        where
        id_exercise = 2 and
        id_student = ".$_SESSION["id_alunno"]." and
        id_text =".$_SESSION["id_text"]." and
        id_question =".$val["id_question"]." and
        id_version=0
        ";
      }else{
    
        $qryinsert ="update tab_result set
      
        result = '',
        id_response=".$_POST["multipla".$val["id_question"]].",
        multi=1
        where
        id_exercise = 2 and
        id_student = ".$_SESSION["id_alunno"]." and
        id_text =".$_SESSION["id_text"]." and
        id_question =".$val["id_question"]." and
        id_version=0
        ";
    
    
    
      }

    }else{


  
    if ($val["multi"]==0){


    $qryinsert ="insert into tab_result set
    id_exercise = 2,
    id_student = ".$_SESSION["id_alunno"].",
    id_text =".$_SESSION["id_text"].",
    id_question =".$val["id_question"].",
    result = '".addslashes($_POST["risposta".$val["id_question"]])."',
    id_response=0,
    id_version=0,
    multi=0
    ";
  }else{

    $qryinsert ="insert into tab_result set
    id_exercise = 2,
    id_student = ".$_SESSION["id_alunno"].",
    id_text =".$_SESSION["id_text"].",
    id_question =".$val["id_question"].",
    result = '',
    id_version=0,
    id_response=".$_POST["multipla".$val["id_question"]].",
    multi=1
    ";



  }
}
$rsins = connetti($qryinsert);
  }
//CAlcola risultati

$qrycheck ="select * from tab_question where  id_text =".$_SESSION["id_text"]." and id_exercise= 2 and lang='".$language."'";
$rschk =connetti($qrycheck);
while($valcheck =mysqli_fetch_array($rschk)){

    $idquestion=$valcheck["id_question"];



$qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_question= ".$idquestion." and id_version=0";
$rsv = connetti($qryv);
while ($val1 =mysqli_fetch_array($rsv)){
  $totale = $totale+1;
  if ($val1["result"]<>""){
    $risposte = $risposte +1;
  }else{
    if ($val1["multi"]==1 && $val1["id_result"]>0){
      $risposte=$risposte +1;
    }
  }

}
}

if($totale == $risposte){
$chkW=1;
}else{
$chkW=2;
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
  <meta charset="utf-8">
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
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["esercizio2_titolo"]?>
            <button type="button" class="btn btn-tool" onclick="resume_text()" id="resumes2" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["esercizio2_esercizio"])?>','s2')" id="plays2">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button></h1>
           <hr>
            <?php echo $lang["esercizio2_esercizio"]?>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
       
          
 
<div class="row">
  <div class="col-lg-12">
  <?php 
    $qry ="select * from tab_text where id_text=".$_SESSION["id_text"];
    $rs= connetti($qry);
    while($val=mysqli_fetch_array($rs)){?>
    <div class="card card-primary  collapsed-card">
<div class="card-header">
<h3 class="card-title"><?php echo $val["title".$_SESSION["lang"]];?></h3>
<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse">
<i class="fas fa-plus"></i>
</button>

</div>

</div>

<div class="card-body context-menu-one" style="display: none;">
<?php echo $val["text".$_SESSION["lang"]];?>
</div>

</div>
  


    <?php 
    }
?>
</div>
</div>
<form method="post" >
<?php $y=0;
$l="it";
if($_SESSION["lang"]=="_en"){
  $l="en";
}
$qry ="select * from tab_question where id_text =".$_SESSION["id_text"]." and id_exercise=2 and lang='".$l."' order by tab_question.order";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){?>
<div class="row">

    <div class="col-lg-12">
           
           <div class="card card-primary card-outline">
             <div class="card-header">
               <h5 class="card-title m-0"><?php echo $val["question"]?></h5>
               <div class="card-tools">
               <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val["id_question"]?>" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($val["question"])?>',<?php echo $val["id_question"]?>)" id="play<?php echo $val["id_question"]?>">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button>
</div>
             </div>
             <div class="card-body">
              <?php if ($val["multi"]==1){?>
              
                    <Select name="multipla<?php echo $val["id_question"]?>" class="custom-select form-control-border border-width-2">
              <option>Seleziona risposta..</option>
              <?php $qry1="select * from tab_response where id_question=".$val["id_question"];
              $rs1 = connetti($qry1);
              while($val1= mysqli_fetch_array($rs1)){
                $qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_exercise=2 and id_question =".$val["id_question"]." and id_version=0";
                $rsv = connetti($qryv);
                $valv = mysqli_fetch_array($rsv);?>
                <option value="<?php echo $val1["id_response"]?>" <?php if($valv["id_response"]==$val1["id_response"]){ echo "selected";}?>><?php echo $val1["response"];?></option>
<?php
              }
              ?>
             
             </select>
              <?php }else{
                
                $qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_exercise=2 and id_question =".$val["id_question"]." and id_version=0";
                $rsv = connetti($qryv);
                $valv = mysqli_fetch_array($rsv); ?>
                <input type="text" name="risposta<?php echo $val["id_question"]?>" class="form-control" value="<?php echo $valv["result"]?>">
              <?php
              } ?>
      
           </div>
         </div>
         
</div>
</div>

<?php } ?>
     <!-- /.row -->
<input type="submit" value="Salva" name="pul_salva">
            </form>
<br><br><br>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>
<script> 

 const synth = window.speechSynthesis;
 var msg = new SpeechSynthesisUtterance();
 synth.cancel();
 var wordIndex = 0;
var global_words = [];
var idtext ="";
 function play_text(text,id){
  synth.cancel();
  idtext = id;
  var words   = text.split(" ");
    global_words = words;
    spokenTextArray = words;
  $("#play"+idtext).hide();
  $("#resume"+idtext).show();
  $("#card-text"+idtext).hide();
  $("#underline-text"+idtext).show();
  drawTextInPanel(words);
var voices = synth.getVoices();
console.log(voices);

msg.volume = 0.5; // From 0 to 1
msg.rate = 1; // From 0.1 to 10
msg.pitch = 1; // From 0 to 2
msg.text = text;
<?php if ($_SESSION["lang"]=="_en"){?>
  msg.lang = 'en';
  var v = voices.findIndex(x=>x.lang==='en-US')
  msg.voice = voices[v]; 
<?php
}
?>
<?php if ($_SESSION["lang"]==""){?>
  msg.lang = 'it';
  var v = voices.findIndex(x=>x.lang==='it-IT')
  msg.voice = voices[v]; 
<?php
}
?>
synth.speak(msg);
} 


msg.onboundary = function(event){
  
};

msg.onend = function(){
		
    wordIndex = 0;
    $("#play"+idtext).show();
    $("#resume"+idtext).hide();
    $("#card-text"+idtext).show();
 
   // document.getElementById(idtext+"panel").innerHTML = "";
};

// Get the word of a string given the string and the index
function getWordAt(str, pos) {
    // Perform type conversions.
    str = String(str);
    pos = Number(pos) >>> 0;

    // Search for the word's beginning and end.
    var left = str.slice(0, pos + 1).search(/\S+$/),
        right = str.slice(pos).search(/\s/);

    // The last word in the string is a special case.
    if (right < 0) {
        return str.slice(left);
    }
    // Return the word, using the located bounds to extract it from the string.
    return str.slice(left, right + pos);
}

function drawTextInPanel(words_array){

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
