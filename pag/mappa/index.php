
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
            <h1 class="m-0" align="center"><?php echo $lang["mappa_titolo"]?> 
         </h1>
            <hr>
          
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" align="center">
 
       
 

<div id="container" >

<div class="slideshow-container d-block "   >
    <div class="row" style="padding-top:5px;">
        <div class="col-lg-2" align="center"></div>
        <div class="col-lg-8 card-body box_sopra" id="div_scroll" align="center" >
            <?php 
            $qry ="select * from tab_text where id_text=".$_SESSION["id_text"] ;
            $rs= connetti($qry);
            while($val=mysqli_fetch_array($rs)){?>      
                <p id="text"><?php $tr= $val["text".$_SESSION["lang"]];
                $td = str_replace(array("\r", "\n"), ' ', $tr);
                echo $td;?>
                </p>
              <?php  }?>
        </div>
    </div>
 
    <div class="row " >
      <div class="col-lg-12" align="center">
          <?php 
          if ($_SESSION["lang"]=="_en"){
            $qry="select * from tab_map where id_text=".$_SESSION["id_text"]." and lang='en'";
          }else{
            $qry="select * from tab_map where id_text=".$_SESSION["id_text"]." and lang='it'";
          }
        
          $rs = connetti($qry);
          $pag=0;
          while($val =mysqli_fetch_array($rs)){
            $qry1 ="select * from tab_keyword where id_map=".$val["id_map"]." ";

          $rs1 =connetti($qry1);
          $x=0;
          $keyword=[];
          $img_txt ="";
          $l=$_SESSION["lang"];
          $text = $val["text"];
          while($val1=mysqli_fetch_array($rs1)){
            $img_txt = $img_txt . "<div class='col-sm-12'><img src='".$val1["img"]."' class='img_box' ></div><br>";
            array_push($keyword,$val1["keyw"]);
            $text = str_replace($val1["keyw"],"<span class='sottolinea'>".$val1["keyw"]."</span>",$text);
          }?>
          <?php $txt =str_replace(array("\r", "\n"), '', $val["text"]);;
            $pag =$pag+1;         
                    ?>
            <div class="mySlides ">

                <div class="text">
                    <div class='row'>
                      <div class='col-sm-3'></div>
                      
                        <div class='col-sm-3' >
                          <div class='card card-primary '>
          
                              <div class='card-body box_sotto'   id="textarea<?php echo $val["id_map"]?>">
                                <?php //$p =str_replace(","," ",$txt);
                                $p =str_replace("'","*",$txt);
                                
                                ?>
                              <p id='card-text<?php echo $val["id_map"]?>' onmouseover='sottolinea_text("<?php echo($p)?>")' onmouseout='sottolinea_text_no("<?php echo $p;?>")'>
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
                         
                          <div class='col-sm-3'>
                                      <div class='card card-primary '>
                                      
                                        <div class='card-body box_sotto'  >
                                        
                                          <?php echo $img_txt;?>
                                        
                                        </div>
                                      </div>
                          </div>
                      </div><!-- fine row-->
                      </div><!-- text-->

                      
                      <div class="row "  style="margin-top: 4%;" >
              <div class="col-lg-2">
              <a class="prev" onclick="plusSlides(-1)"><img src="../../img/freccia sx.png"  width="50" ></a>
              </div>
              <div class="col-lg-8" align="center">

              <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val["id_map"]?>" style="display:none;">
  <img src="../../img/play.png" width="50" >
      </button>
      <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($txt)?>',<?php echo $val["id_map"]?>)" id="play<?php echo $val["id_map"]?>">
      <img src="../../img/play.png" width="50"  >
      </button>
      <button type="button" class="btn btn-tool" onclick="pause_text()">
      <img src="../../img/pausa.png" width="50"  >
      </button> 
      <img src="../../img/schermointero.png" class="toggle_fullscreen open_b" style="cursor:pointer;" height="50" >
      <img src="../../img/riducischermo.png" class="toggle_fullscreen close_b" style="cursor:pointer; display:none;" height="50" > 

      <button type="button" class="btn btn-tool open_info" data-toggle="modal" data-target="#modal-lg" >
      <img src="../../img/info.png"  style="cursor:pointer;" height="50" >
                </button>
     
              </div>  
              <div class="col-lg-2">
              <a class="next" onclick="plusSlides(+1)"><img src="../../img/freccia dx.png"  width="50" ></a>
              </div>               
      </div>  
                    
           </div><!-- my slide-->
 
<?php 
$puntini =$puntini."<span class='dot' onclick='currentSlide(".$pag.")'></span>";
}
?>



          </div><!-- fine col-->

          </div><!-- fine row-->
<br>




</div><!-- slideshow container-->
 

      <div class="row "  style="margin-top:70px;" >
              <div class="col-lg-2" >
              </div>
              <div class="col-lg-8" align="center">
                <?php echo $puntini;?>
              </div>  
              <div class="col-lg-2" >
              </div>               
      </div>              
</div>

      </div><!-- /.container-fluid --><br>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
</div>
<!-- ./wrapper -->

<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" align="center"><?php echo $lang["mappa_titolo"]?> </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <?php echo $lang["mappa_esercizio"];
            $nameimg=$lang["mappa_immagini"];
            $mappa_testo=$lang["mappa_testo"];
            ?>
           
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-tool" onclick="resume_text()" id="resumes2" style="display:none;">
            <img src="../../img/play.png" width="50"  >
                    </button>
          <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["mappa_esercizio"])?>','s2')" id="plays2">
          <img src="../../img/play.png" width="50"  >
                    </button>
                    <button type="button" class="btn btn-tool" onclick="pause_text()">
                    <img src="../../img/pausa.png" width="50"  >
                    </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





      
<?php include "../../scripts.php";?>
<script> 

$(".open_info").on('click', function(){
  console.log("prova1111");
  if (document.fullscreenElement) {
    console.log("prova");
    document.exitFullscreen();
    $(".open_b").show();
    $(".close_b").hide();
 
  }

});

$('.toggle_fullscreen').on('click', function(){
  // if already full screen; exit
  // else go fullscreen
  if (document.fullscreenElement) {
    document.exitFullscreen();
    $(".open_b").show();
    $(".close_b").hide();
 
  } else {
    $('#container').get(0).requestFullscreen();
    $(".close_b").show();
    $(".open_b").hide();
  }
});
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
function sottolinea_text(text_v){

  console.log(text_v.length);
  texts = text_v.replace("*", "'");
  console.log(texts)

var text = document.getElementById("text").innerHTML;

var newtext = text.replace(texts, "<span id=\"sottol\" class=\"underline\">"+texts+"</span>");
console.log(newtext)
document.getElementById("text").innerHTML = newtext;
test()
}

function test(){
  var myElement = document.getElementById('sottol');
var topPos = myElement.offsetTop;
document.getElementById('div_scroll').scrollTop = topPos;
//put the new underlined text back into the element
}
function sottolinea_text_no(text_v){

console.log(text_v);
texts = text_v.replace("*", "'");
//get the inner contents of the element
var text = document.getElementById("text").innerHTML;

//replace the text you want with that same text surrounded by <u> tags
var newtext = text.replace( "<span id=\"sottol\" class=\"underline\">"+texts+"</span>",texts);

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



</script>
</body>
</html>
