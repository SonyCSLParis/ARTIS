
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
$l = "it";
if($_SESSION["lang"]=="_en"){
  $l="en";
}
if ($_POST["pul_salva"]=="Salva"){

  $qry ="select * from tab_pronouns where id_text =".$_SESSION["id_text"]." and lang='".$l."'";
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){
   $risp= $_POST["risp".$val["id_pronouns"]];
   if ($risp==""){
    $risp=0;
   }
    $qryv ="select * from tab_response_pronouns where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_pronouns =".$val["id_pronouns"]." and id_version=0";
    $rsv = connetti($qryv);
    $count = mysqli_num_rows($rsv);
    if ($count >0){

     


        $qryinsert ="update tab_response_pronouns set
     
        response=".$risp."
      
        where
       
        id_student = ".$_SESSION["id_alunno"]." and
        id_text =".$_SESSION["id_text"]." and
        id_pronouns =".$val["id_pronouns"]." and
        id_version=0
        ";
    
    
    
    
      

    }else{

    $qryinsert ="insert into tab_response_pronouns set
    id_student = ".$_SESSION["id_alunno"]." ,
    id_text =".$_SESSION["id_text"]." ,
    id_pronouns =".$val["id_pronouns"].",
    response=".$risp.",
    id_version=0
    ";
 
}
//echo $qryinsert;
$rsins = connetti($qryinsert);
  }


  $qrycheck="Select * from tab_pronouns where lang='".$l."'";
  $rschk = connetti($qrycheck);
  while($valchk = mysqli_fetch_array($rschk)){
  
  
    $qryv ="select * from tab_response_pronouns where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_pronouns= ".$valchk["id_pronouns"]." and id_version=0";
    $rsv = connetti($qryv);
    while ($val1 =mysqli_fetch_array($rsv)){
      $totale = $totale+1;
      if ($val1["response"]<>"0"){
        $risposte = $risposte +1;
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


<?php include "../../header.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["pronomi_titolo"]?>  <button type="button" class="btn btn-tool" onclick="resume_text()" id="resumes2" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["pronomi_esercizio"])?>','s2')" id="plays2">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button></h1>
          <hr>
            <?php echo $lang["pronomi_esercizio"]?>
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
    <div class="card card-primary collapsed-card">
<div class="card-header">
<h3 class="card-title"><?php echo $val["title".$_SESSION["lang"]];?></h3>
<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse">
<i class="fas fa-plus"></i>
</button>

</div>

</div>

<div class="card-body context-menu-one" style="display: none;">
<p id="text"><?php echo $val["text".$_SESSION["lang"]];?></p>
</div>

</div>
  


    <?php 
    }
?>
</div>
</div>
<div style="height:360px;overflow-y:scroll; overflow-x:hidden;">
<form method="post" >
<?php $y=0;

$qry ="select * from tab_pronouns where id_text =".$_SESSION["id_text"]." and lang='".$l."'";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
  $res =0;
  $qryr="select * from tab_response_pronouns where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_pronouns =".$val["id_pronouns"]." and id_version=0";
  $rsr = connetti($qryr);
  while($valr = mysqli_fetch_array($rsr)){
    $res = $valr["response"];
  }
  $txt =$val["frase"];
                $txt = str_replace("’","",$txt);
                $txt = str_replace("“","",$txt);
                $txt = str_replace("”","",$txt);
                
              $word = explode(" ", $txt);
                $x=0;
  ?>
<div class="row">

    <div class="col-lg-12">
           
           <div class="card card-primary card-outline" onmouseover='sottolinea_text("<?php echo $val["frase"];?>")' onmouseout='sottolinea_text_no("<?php echo $val["frase"];?>")'>
             <div class="card-header" id="textarea<?php echo $val["id_pronouns"]?>">
             <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val['id_pronouns']?>" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
                  
                    <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($txt)?>',<?php echo $val['id_pronouns']?>)" id="play<?php echo $val['id_pronouns']?>">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button>
                </div>
              <p id='card-text<?php echo $val["id_pronouns"]?>'>
              <?php echo $val["frase"];?>
              </p>
              <p id='underline-text<?php echo $val["id_pronouns"]?>' style="display:none;">
              <?php 
              
                foreach ($word as $w){
              ?>
              <span id="word<?php echo $val["id_pronouns"]?>_span_<?php echo $x;?>"><?php echo  $w;?></span>&nbsp;
              <?php
              $x=$x+1;
              }
              ?>
              <span id="word<?php echo $val["id_pronouns"]?>" style="color:blue;display:none;"></span>
               <h5 > </h5>
              
             </div>
             <div class="card-body">
             '<?php echo $val["pronome"];?>' <?php echo $lang["pronomi_domanda"]?>:<br>

             <input type="radio" name="risp<?php echo $val["id_pronouns"]?>" value="1" <?php if ($res ==1){echo "checked";}?>> <?php echo $val["r1"]?><br>
             <input type="radio" name="risp<?php echo $val["id_pronouns"]?>" value="2" <?php if ($res ==2){echo "checked";}?>> <?php echo $val["r2"]?><br>
             <input type="radio" name="risp<?php echo $val["id_pronouns"]?>" value="3" <?php if ($res ==3){echo "checked";}?>> <?php echo $val["r3"]?><br>
             <input type="radio" name="risp<?php echo $val["id_pronouns"]?>" value="4" <?php if ($res ==4){echo "checked";}?> > <?php echo $val["r4"]?><br>

           
<?php 
              $text = $val["frase"];
              $text = str_replace($val["r1"],"<span class='sottolinea'>".$val["r1"]."</span>",$text );
              $text = str_replace($val["r2"],"<span class='sottolinea'>".$val["r2"]."</span>",$text );
              $text = str_replace($val["r3"],"<span class='sottolinea'>".$val["r3"]."</span>",$text );
              $text = str_replace($val["r4"],"<span class='sottolinea'>".$val["r4"]."</span>",$text );
              $text = str_replace($val["pronome"]." ","<span class='sottolinea2'>".$val["pronome"]." </span>",$text );
              echo $text;

?>
      
           </div>
         </div>
         
</div>
</div>

<?php } ?>
     <!-- /.row -->
<input type="submit" class="btn btn-primary" value="Salva" name="pul_salva">
            </form>
            </div>
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

function sottolinea_text(text_v){

console.log(text_v);
//get the inner contents of the element
var text = document.getElementById("text").innerHTML;

//replace the text you want with that same text surrounded by <u> tags
var newtext = text.replace(text_v, "<span class=\"underline\">"+text_v+"</span>");

//put the new underlined text back into the element
document.getElementById("text").innerHTML = newtext;

}
function sottolinea_text_no(text_v){

console.log(text_v);
//get the inner contents of the element
var text = document.getElementById("text").innerHTML;

//replace the text you want with that same text surrounded by <u> tags
var newtext = text.replace( "<span class=\"underline\">"+text_v+"</span>",text_v);

//put the new underlined text back into the element
document.getElementById("text").innerHTML = newtext;

}

const synth = window.speechSynthesis;
 var msg = new SpeechSynthesisUtterance();
 synth.cancel();
 var wordIndex = 0;
var global_words = [];
var idtext ="";
 function play_text(text,id){
  synth.cancel();
  var wordIndex = 0;
var global_words = [];
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
<?php if($_SESSION["lang"]=="_en"){
  ?>
  msg.lang = 'en';
  var v = voices.findIndex(x=>x.lang==='en-US')
  msg.voice = voices[v]; 
  <?php
}else{?>
msg.lang = 'it';
var v = voices.findIndex(x=>x.lang==='it-IT')
  msg.voice = voices[v]; 
<?php } ?>

synth.speak(msg);
} 


msg.onboundary = function(event){
  	var e = document.getElementById('textarea'+idtext);
  	var word = getWordAt(e.textContent,event.charIndex);
    // Show Speaking word : x
  	document.getElementById("word"+idtext).innerHTML = word;
    //Increase index of span to highlight
    console.info(global_words[wordIndex]);
    try{
    	document.getElementById("word"+idtext+"_span_"+wordIndex).style.color = "blue";
    }catch(e){}
    wordIndex++;
};

msg.onend = function(){
		document.getElementById("word"+idtext).innerHTML = "";
    wordIndex = 0;
    $("#play"+idtext).show();
    $("#resume"+idtext).hide();
    $("#card-text"+idtext).show();
  $("#underline-text"+idtext).hide();
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
