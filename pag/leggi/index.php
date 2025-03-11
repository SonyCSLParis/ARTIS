
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
<?php include "../../header.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <div ><h1 class="m-0" align="center"><?php echo $lang["leggi_titolo"]?><button type="button" class="btn btn-tool" onclick="resume_text()" id="resume2" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["leggi_esercizio"])?>',2)" id="play2">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                   
                    </button>
                    </h1> </div> 
           <hr>

            <?php echo $lang["leggi_esercizio"]?> 
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
      while($val=mysqli_fetch_array($rs)){
        $text = $val["text".$_SESSION["lang"]];
        $txt =$val["text".$_SESSION["lang"]];
        $txt =  preg_replace('/\s\s+/', '', $txt);
      
        ?>
      <div class="card card-primary ">
        <div class="card-header">
          <h3 class="card-title"><?php echo $val["title".$_SESSION["lang"]];?></h3>
          <div class="card-tools">
       
          
  
                
          <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume1" style="display:none;">
                    <i class="fas fa-play"></i>
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($txt)?>',1)" id="play1">
                    <i class="fas fa-play"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <i class="fas fa-pause"></i>
                    </button>

                    <span style=" font-weight: 900;
                color: white;
                margin-left: 1rem ;
                background-color: #7f7f7f;
                padding: 5px;
                border-radius: 5px;
                font-size: 70%;
                color: white;
            text-align:center;
                display: inline-block;
                width: 50px;
                vertical-align: bottom;
            " id="velocita">
                    1x
                    </span>

       
  
                  <input type="range" style="width:50px;margin-top:12px;background: #04AA6D;" min="1" max="5" class="custom-range" id="customRange1"  oninput="updateRangeSlider(this)" onchange="updateRangeSlider(this)"> 
         
               
          </div>
        </div>
        <div class='card-body context-menu-one'  id="textarea1">
              <p id='card-text1'>
                <?php echo $text;?>
              </p>
              <p id='underline-text1' style="display:none;">
              <?php 
              $word = explode(" ", $txt);
                $x=0;
                foreach ($word as $w){
              ?>
              <span id="word1_span_<?php echo $x;?>"><?php echo  $w;?></span>&nbsp;
              <?php
              $x=$x+1;
              }
              ?>
              <span id="word1" style="color:blue;display:none;"></span><br><br>
            </p>
            </div>
      </div>
        <?php  }?>
  </div>
</div>

<br>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>
<script> 


const synth = window.speechSynthesis;
synth.cancel();
 var msg = new SpeechSynthesisUtterance();
 var wordIndex = 0;
var global_words = [];
var idtext ="";
 function play_text(text,id){
  synth.cancel();
  var rate =  sessionStorage.getItem("rate");
  idtext = id;
  var words   = text.split(" ");
    global_words = words;
    spokenTextArray = words;
   
  $("#play"+idtext).hide();
  $("#resume"+idtext).show();
  $("#card-text"+idtext).hide();
  $("#underline-text"+idtext).show();

var voices = synth.getVoices();
//console.log(voices);

msg.volume = 0.5; // From 0 to 1
msg.rate = parseFloat(sessionStorage.getItem("rate")) // From 0.1 to 10
msg.pitch = 1; // From 0 to 2
msg.text = text;
<?php if ($_SESSION["lang"]=="_en"){?>
  msg.lang = 'en';
  var v = voices.findIndex(x=>x.lang==='en-US')
  //console.log(v)
  msg.voice = voices[v]; 
<?php
}
?>
<?php if ($_SESSION["lang"]==""){?>
  msg.lang = 'it';
  var v = voices.findIndex(x=>x.lang==='it-IT')
  //console.log(v)
  msg.voice = voices[v]; 
<?php
}
?>
synth.speak(msg);
} 


msg.onboundary = function(event){
 
  	var e = document.getElementById('textarea'+idtext);

  	var word = getWordAt(e.textContent,event.charIndex);
  
  	document.getElementById("word"+idtext).innerHTML = word;
   
   
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
