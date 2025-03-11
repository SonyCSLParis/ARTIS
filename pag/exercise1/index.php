
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


?>



</head>
<?php include "../../header.php";?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["esercizio1_titolo"]?> 
         </h1>
            <hr>
          
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <!-- Main content -->
    <div class="content" align="center">
    
<div id="container" >

<div class="slideshow-container d-block "   >
    <div class="row" style="padding-top:5px;">
        <div class="col-lg-2" align="center"></div>
        <div class="col-lg-8 card-body box_sopra" align="center" >
            <?php 
            $qry ="select * from tab_text where id_text=".$_SESSION["id_text"] ;
            $rs= connetti($qry);
            while($val=mysqli_fetch_array($rs)){?>      
                <p id="text"><?php echo $val["text".$_SESSION["lang"]];?></p>
              <?php  }?>
        </div>
    </div>



<form method="post" id="salva_esercizio_1">
<input type="hidden" name="valori" id="valori" value="">
 <!-- Slideshow container -->
    <div class="row " >
      <div class="col-lg-12" align="center">
<?php $y=0;
$pag=0;
$l="it";
if($_SESSION["lang"]=="_en"){
  $l="en";
}
$qry ="select * from tab_question where id_text =".$_SESSION["id_text"]." and id_exercise=1 and lang='".$l."' order by tab_question.order";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
  $pag=$pag+1;?>


<div class="mySlides ">
<div class="text">
    <div class="row" >
      <div class="col-sm-3">
      </div>
      <div class="col-sm-3">
           
        <div class="card card-primary " >
            <div class="card-body box_sotto">
              <h5 class="card-title m-0"><?php echo $val["question"]?></h5>
            </div>    
        </div>
      </div>
     
   
      <div class="col-sm-3">
           
        <div class="card card-primary  ">
            
          <div class="card-body box_sotto">
                <?php if ($val["multi"]==1){?>
                <Select name="multipla<?php echo $val["id_question"]?>" class="custom-select form-control-border border-width-2">
                    <option>Seleziona risposta..</option>
                    <?php $qry1="select * from tab_response where id_question=".$val["id_question"];
                    $rs1 = connetti($qry1);
                    while($val1= mysqli_fetch_array($rs1)){
                      $qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_exercise=1 and id_question =".$val["id_question"]." and id_version=0";
                      $rsv = connetti($qryv);
                      $valv = mysqli_fetch_array($rsv);?>
                      <option value="<?php echo $val1["id_response"]?>" <?php if($valv["id_response"]==$val1["id_response"]){ echo "selected";}?>><?php echo $val1["response"];?></option>
                    <?php
                    }
                    ?>
                </select>
                  <?php }else{
                      $qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_exercise=1 and id_question =".$val["id_question"]." and id_version=0";
                      $rsv = connetti($qryv);
                      $valv = mysqli_fetch_array($rsv); ?>
                      <textarea  name="risposta<?php echo $val["id_question"]?>" class="form-control" rows="6"><?php echo $valv["result"]?></textarea>
                      
                  <?php
                  } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  

  <div class="row "  style="margin-top: 4%;" >
        <div class="col-lg-2">
        <a class="prev" onclick="plusSlides(-1)"><img src="../../img/freccia sx.png"  width="50" ></a>
        </div>
        <div class="col-lg-8" align="center">
      
  <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val["id_question"]?>" style="display:none;">
  <img src="../../img/play.png" width="50" >
      </button>
      <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($val["question"])?>',<?php echo $val["id_question"]?>)" id="play<?php echo $val["id_question"]?>">
      <img src="../../img/play.png" width="50"  >
      </button>
      <button type="button" class="btn btn-tool" onclick="pause_text()">
      <img src="../../img/pausa.png" width="50"  >
      </button> 
      <img <?php if ($_SESSION["lang"]=="_en"){ ?> 
        src="../../img/save.png"
        <?php }else{?>
        src="../../img/salva.png"
          <?php }?>

        
        onclick="salva()"  height="50" style="cursor:pointer;">
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
 
  
</div>
<?php
$puntini =$puntini."<span class='dot' onclick='currentSlide(".$pag.")'></span>";

 } ?>
 


     <!-- /.row -->
</div>
</div>
<input type="submit" class="btn btn-primary" value="Salva" name="pul_salva" id="pul_salva" style="display:none;">
            </form>

      <!-- /.container-fluid -->
  

    <div class="row "  >
            
              <div class="col-lg-12" align="center">
                <?php echo $puntini;?><span id="width_1"></span>
              </div>  
                        
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
              <h4 class="modal-title" align="center"><?php echo $lang["esercizio1_titolo"]?> </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <?php echo $lang["esercizio1_esercizio"];
  
            ?>
           
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-tool" onclick="resume_text()" id="resumes2" style="display:none;">
            <img src="../../img/play.png" width="50"  >
              </button>
              <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($lang["esercizio1_esercizio"])?>','s2')" id="plays2">
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
var timer = 0
var interval = setInterval(function(){
 timer=timer+1;
}, 1000);



function salva(){
  var giro = $("#valori").val();
  arr = giro.split("-");
  const form = document.querySelector("#salva_esercizio_1");
  const formData = new FormData(form);
  ris=[]
  for(var x in arr){
    console.log(arr[x])
    if (arr[x]!=""){
      var c = formData.get("risposta"+arr[x])
      var d = formData.get("multipla"+arr[x])
      ris.push({"id":arr[x],"risposta":c,"multipla":d})
    }
  }

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "salva_esercizio.php");
  xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8")
  const body = JSON.stringify({
  idtext: <?php echo $_SESSION["id_text"]?>,
  iduser: <?php echo $_SESSION["id_alunno"]?>,
  language: "<?php echo $l ?>",
  risposta: ris,
  tempo:timer,
  completed: false
});
xhr.onload = () => {
  if (xhr.readyState == 4 && xhr.status == 201) {
    console.log(JSON.parse(xhr.responseText));
  } else {
    console.log(`Error: ${xhr.status}`);
  }
};
xhr.send(body);
timer=0;

}
$(".open_info").on('click', function(){
 
  if (document.fullscreenElement) {
    document.exitFullscreen();
    $(".open_b").show();
    $(".close_b").hide();
  }

});

$('.toggle_fullscreen').on('click', function(){
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

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
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
<?php $qry ="select * from tab_question where id_text =".$_SESSION["id_text"]." and id_exercise=1 and lang='".$l."' order by tab_question.order";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
  $pag=$pag+1;?>
  <script>
    
    $("#valori").val($("#valori").val()+"-<?php echo $val["id_question"]?>")

</script>
<?php } ?>
