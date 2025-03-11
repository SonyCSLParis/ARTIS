
<?php
// Start the session
session_start();

?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 
function illumina_keyword($idmap,$text,$lang){

$qry ="select * from tab_keyword where id_map=".$idmap;

$rs =connetti($qry);
$x=0;
$keyword=[];
while($val=mysqli_fetch_array($rs)){

  $img_txt = $img_txt . "<div class='col-lg-6'><img src='".$val["img"]."' width='250px;'></div>";
  array_push($keyword,$val["keyw".$lang]);

 $text = str_replace($val["keyw".$lang],"<span class='sottolinea'>".$val["keyw".$lang]."</span>",$text);


}


return "


  <div class='row'>

    <div class='col-lg-6'>
      <div class='card card-primary card-outline'>
        <div class='card-header'><h5 class='card-title m-0'>Immagini</h5></div>
        <div class='card-body' style='height:300px;'>
          <div  class='row' >
            ".$img_txt."
          </div>
        </div>
      </div>
    </div>
    <div class='col-lg-6'>
      <div class='card card-primary card-outline'>
        <div class='card-header'><h5 class='card-title m-0'>Testo</h5></div>
        <div class='card-body'  style='height:300px;' ><p class='card-text'  >
        ".$text."</p></div>
      </div>
    </div>
</div>

";

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
            <h1 class="m-0" align="center"><?php echo $lang["mappa_titolo"]?> <button type="button" class="btn btn-tool" onclick="resume_text()" id="resumes2" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["mappa_esercizio"])?>','s2')" id="plays2">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button></h1>
           <hr>
            <?php echo $lang["mappa_esercizio"];
            $nameimg=$lang["mappa_immagini"];
            $mappa_testo=$lang["mappa_testo"];
            ?>
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
      $qry ="select * from tab_text where id_text=".$_SESSION["id_text"] ;
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
        <?php  }?>
  </div>
</div>

<div class="row" style="height:360px;overflow-y:scroll;">
  <div class="col-lg-12">
      <?php 
      if ($_SESSION["lang"]=="_en"){
        $qry="select * from tab_map where id_text=".$_SESSION["id_text"]." and lang='en'";
      }else{
        $qry="select * from tab_map where id_text=".$_SESSION["id_text"]." and lang='it'";
      }
     
      $rs = connetti($qry);
      while($val =mysqli_fetch_array($rs)){
        
        $qry1 ="select * from tab_keyword where id_map=".$val["id_map"]." ";

      $rs1 =connetti($qry1);
      $x=0;
      $keyword=[];
      $img_txt ="";
      $l=$_SESSION["lang"];
      $text = $val["text"];
      while($val1=mysqli_fetch_array($rs1)){

        $img_txt = $img_txt . "<div class='col-sm-6'><img src='".$val1["img"]."' class='col-md-6'></div>";
        array_push($keyword,$val1["keyw"]);

      $text = str_replace($val1["keyw"],"<span class='sottolinea'>".$val1["keyw"]."</span>",$text);
      }?>


      <div class='row'>

        <div class='col-sm-6'>
          <div class='card card-primary card-outline'>
            <div class='card-header'><h5 class='card-title m-0'><?php echo  $nameimg;?></h5></div>
            <div class='card-body' style='height:300px;'>
              <div  class='row'>
              <?php echo $img_txt;?>
              </div>
            </div>
          </div>
        </div>
        <div class='col-sm-6'>
          <div class='card card-primary card-outline'>
            <div class='card-header'><h5 class='card-title m-0'><?php echo $mappa_testo;?></h5>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="apri(<?php echo $val['id_map']?>)">
            <i class="fas fa-plus"></i>
            </button>
                    <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val['id_map']?>" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
                    <?php $txt =$val["text"];
                 
                    ?>
                    <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($txt)?>',<?php echo $val['id_map']?>)" id="play<?php echo $val['id_map']?>">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button>
                </div>
              </div>
              <div class='card-body' style='height: 290px;' id="textarea<?php echo $val["id_map"]?>">
              <p id='card-text<?php echo $val["id_map"]?>' onmouseover='sottolinea_text("<?php echo addslashes($txt);?>")' onmouseout='sottolinea_text_no("<?php echo addslashes($txt);?>")'>
                <?php echo $text;?>
              </p>
              <p id='underline-text<?php echo $val["id_map"]?>' style="display:none;">
              <?php 
              $word = explode(" ", $txt);
                $x=0;
                foreach ($word as $w){
              ?>
              <span id="word<?php echo $val["id_map"]?>_span_<?php echo $x;?>"><?php echo  $w;?></span>&nbsp;
              <?php
              $x=$x+1;
              }
              ?>
              <span id="word<?php echo $val["id_map"]?>" style="color:blue;display:none;"></span><br><br>
            </p>
            <div class="card-footer " id="simply<?php echo $val["id_map"]?>" style="display:none;"><?php echo $val["text_simp"];?></div>
            </div>
          
          </div>
        </div>
      </div>
<?php 
}
?>

</div>
</div><br>
      </div><!-- /.container-fluid --><br>
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
function apri(idt){
$("#simply"+idt).toggle();

}

const synth = window.speechSynthesis;
synth.cancel();
 var msg = new SpeechSynthesisUtterance();
 var wordIndex = 0;
var global_words = [];
var idtext ="";
 function play_text(text,id){
  wordIndex=0;
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

console.log(voices.findIndex(x=>x.lang==='it-IT'));

msg.volume = 0.5; // From 0 to 1
msg.rate = sessionStorage.getItem("rate"); // From 0.1 to 10
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


/*
 const synth = window.speechSynthesis;
 function play_text(text){
 console.log(text);
  $("#play").hide();
  $("#resume").show();
  var msg = new SpeechSynthesisUtterance();
var voices = synth.getVoices();

msg.voice = voices[1]; 


msg.volume = 0.5; // From 0 to 1
msg.rate = 1; // From 0.1 to 10
msg.pitch = 1; // From 0 to 2
msg.text = text;
msg.lang="en";

speechSynthesis.cancel();
synth.speak(msg);
} 
function pause_text(){
  synth.pause();
}
function resume_text(){
  synth.resume();
}

*/
</script>
</body>
</html>
