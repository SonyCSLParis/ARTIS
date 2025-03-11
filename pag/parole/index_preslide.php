
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>


<?php

function illumina_keyword($idmap,$text,$lan){

$qry ="select * from tab_keyword where id_map=".$idmap;

$rs =connetti($qry);
$x=0;
$keyword=[];
while($val=mysqli_fetch_array($rs)){

  $img_txt = $img_txt . "<div class='col-lg-6'><img src='".$val["img"]."' width='250px;'></div>";
  array_push($keyword,$val["keyw".$lan]);

 $text = str_replace($val["keyw".$lan],"<span class='sottolinea'>".$val["keyw".$lan]."</span>",$text);


}


return "


  <div class='row'>

    <div class='col-lg-6'>
      <div class='card card-primary card-outline'>
        <div class='card-header'><h5 class='card-title m-0'>Immagini</h5></div>
        <div class='card-body' style='height:300px;'>
          <div  class='row'>
            ".$img_txt."
          </div>
        </div>
      </div>
    </div>
    <div class='col-lg-6'>
      <div class='card card-primary card-outline'>
        <div class='card-header'><h5 class='card-title m-0'>Testo</h5></div>
        <div class='card-body' style='height:300px;'><p class='card-text'>
        ".$text."</p></div>
      </div>
    </div>
</div>

";

}
?>
<?php 
include "../../header.php";
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["pd_titolo"]?> <button type="button" class="btn btn-tool" onclick="resume_text()" id="resumes2" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["pd_esercizio"])?>','s2')" id="plays2">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button></h1> <hr>
                    <?php echo $lang["pd_esercizio"]?>
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
  if($_SESSION["lang"]=="_en"){
    $l = "en";
  }else{
    $l="it";
  }
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
<button type="button"  class="btn btn-tool" onclick="search_word('<?php echo $l ?>');"><i class="fa fa-search"></i></button>
<!--
<button type="button"  class="btn btn-tool" onclick="search_word_google();"><i class="fab fa-google"></i></button>
    -->
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
<div class="row" style="height:360px;overflow-y:scroll;">
  <div class="col-lg-12">
  <table class="table table-hover ">
<thead>
<tr>
<th><?php echo $lang["pd_t1"]?></th>

<th><?php echo $lang["pd_t2"]?></th>
<th>
<?php echo $lang["pd_t3"]?></th>
<th><?php echo $lang["pd_t4"]?></th>

<th><?php echo $lang["pd_t5"]?></th>
<th><?php echo $lang["pd_t6"]?></th>
<th><?php echo $lang["pd_t7"]?></th>
</tr>
</thead>
<tbody>
<?php 
$lan ="it";
if($_SESSION["lang"]=="_en"){
  $lan="en";
}
$qry="select * from tab_difficult_words where id_text=".$_SESSION["id_text"]." and lang='".$lan."'";
$rs = connetti($qry);
while($val =mysqli_fetch_array($rs)){
  ?>

<tr><td>

<img id="img<?php echo $val["id_df"];?>" src="<?php echo $val["img"];?>" width="100" style="border-style: solid;"></td>
<td onmouseover='sottolinea_text("<?php echo $val["word"];?>")' onmouseout='sottolinea_text_no("<?php echo $val["word"];?>")'>
<?php echo $val["word"] ?>
</td>
  <td>
    <a href="?parola=<?php echo $val["word"] ?>"><i class="fas fa-project-diagram"></i></a>
</td>

<td>
<?php echo $val["definition"] ?>
</td>
<td>
<button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val['id_df']?>" style="display:none;">
        <i class="fas fa-play"></i>
        </button>
        <?php $txt =$val["definition"] ;
        $txt = str_replace("’","",$txt);
        $txt = str_replace("“","",$txt);
        $txt = str_replace("”","",$txt);
        ?>
        <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($txt)?>',<?php echo $val['id_df']?>)" id="play<?php echo $val['id_df']?>">
        <i class="fas fa-play"></i>
        </button>
        <button type="button" class="btn btn-tool" onclick="pause_text()">
        <i class="fas fa-pause"></i>
        </button>
</td>
<td>
<?php echo $val["frase"] ?>
</td>


<td>
<button type="button" class="btn btn-tool" onclick="resume_text()" id="resume-<?php echo $val['id_df']?>" style="display:none;">
        <i class="fas fa-play"></i>
        </button>
        <?php $txt =$val["frase"];
        $txt = str_replace("’","",$txt);
        $txt = str_replace("“","",$txt);
        $txt = str_replace("”","",$txt);
        ?>
        <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($txt)?>','-'+<?php echo $val['id_df']?>)" id="play-<?php echo $val['id_df']?>">
        <i class="fas fa-play"></i>
        </button>
        <button type="button" class="btn btn-tool" onclick="pause_text()">
        <i class="fas fa-pause"></i>
        </button>
</td>
</tr>
 
     <!-- /.row -->

<?php 
}
?>
</tbody>
</table>

</div>
</div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>






  <div class="modal fade" id="modal-graph" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title"><?php echo $lang["pd_t3"];?>: <span id="parola"><span></h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">

 <?php $t=time();?>

<iframe src="../../graph.php?<?php echo $t;?>" style="border:0px ;width:100%;height: 800px;align:center;"></iframe>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>

</div>

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
var newtext = text.replaceAll(text_v, "<span class=\"underline\">"+text_v+"</span>");

//put the new underlined text back into the element
document.getElementById("text").innerHTML = newtext;

}
function sottolinea_text_no(text_v){

console.log(text_v);
//get the inner contents of the element
var text = document.getElementById("text").innerHTML;

//replace the text you want with that same text surrounded by <u> tags
var newtext = text.replaceAll( "<span class=\"underline\">"+text_v+"</span>",text_v);

//put the new underlined text back into the element
document.getElementById("text").innerHTML = newtext;

}

const synth = window.speechSynthesis;
synth.cancel();
 var msg = new SpeechSynthesisUtterance();
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
  //	var e = document.getElementById('textarea'+idtext);
 // 	var word = getWordAt(e.textContent,event.charIndex);
    // Show Speaking word : x
 // 	document.getElementById("word"+idtext).innerHTML = word;
    //Increase index of span to highlight
 //   console.info(global_words[wordIndex]);
  //  try{
  //  	document.getElementById("word"+idtext+"_span_"+wordIndex).style.color = "blue";
  //  }catch(e){}
  //  wordIndex++;
};

msg.onend = function(){
		//document.getElementById("word"+idtext).innerHTML = "";
    //wordIndex = 0;
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
<?php 
if($_GET["parola"]<>""){


$url1 = 'http://93.147.158.9:5002/get_sem_graph_csv';
$ch1 = curl_init( $url1 );
echo $lang;
$payload1 = json_encode( array( "word"=> $_GET["parola"] ,"language"=> $lan) );
curl_setopt( $ch1, CURLOPT_POSTFIELDS, $payload1 );
curl_setopt( $ch1, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, true );
$result1 = curl_exec($ch1); 
?>
<script>
  $("#parola").empty();
  $("#parola").append('<?php echo $_GET["parola"]?>');
$('#modal-graph').modal('show');
</script>
<?php
}
?>
</body>
</html>
