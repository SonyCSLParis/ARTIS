
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
$id_text = $_GET["id_text"];

?>

<style>
.wordexe4:hover{
  background-color: #ffe76e;
}

  </style>

</head>
<?php include "../../header.php";?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["esercizio4_titolo"]?> 
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
           
                <p id="text">Seleziona le parole chiave frase per frase e confronta la tua scelta con quella del computer.<br>Per selezionare una parola chiave, cliccaci sopra e apparirà sulla tua destra. </p>
          
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
}else{
  $l="it";
}
$array_risposte=[];
$qry ="select * from tab_map_exe where id_text =".$id_text."";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
 
  $pag=$pag+1;
  $array_text =[];
  $t = str_replace("'","' ",$val["text"]);
  $array_text = explode(" ", $t);
 ?>


<div class="mySlides ">
<div class="text">
    <div class="row" >
      <div class="col-sm-3">
      </div>
      <div class="col-sm-3">
           
        <div class="card card-primary " >
            <div class="card-body box_sotto">
              <h5 class="card-title m-0">
                
              <?php for ($x = 0; $x < count($array_text); $x++ ){

                ?>
                <span style="cursor:pointer" onclick="scegli('<?php echo  addslashes($array_text[$x]);?>',<?php echo $val["id_map"]?>) " class="wordexe4"><?php echo $array_text[$x];?> </span>
              <?php } 
              
              
              ?></h5>
            </div>    
        </div>
      </div>
     
   
      <div class="col-sm-3">
           
        <div class="card card-primary  ">
            
          <div class="card-body box_sotto">
          
              
                      <div  name="risposta<?php echo $val["id_map"]?>" id="risposta<?php echo $val["id_map"]?>" ></div>

                      <br>
                      <br>
                      <hr>
                      <br>
                      <br>
                      <div class="card-footer" style="margin-bottom:0;">
        <span id="risultati<?php echo $val["id_map"]?>"></span>      
        </div>  
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
      
  <button type="button" class="btn btn-tool" onclick="resume_text()" id="resume<?php echo $val["id_map"]?>" style="display:none;">
  <img src="../../img/play.png" width="50" >
      </button>
      <button type="button" class="btn btn-tool" onclick="play_text('<?php echo addslashes($val["text"])?>',<?php echo $val["id_map"]?>)" id="play<?php echo $val["id_map"]?>">
      <img src="../../img/play.png" width="50"  >
      </button>
      <button type="button" class="btn btn-tool" onclick="pause_text()">
      <img src="../../img/pausa.png" width="50"  >
      </button> 
      <img <?php if ($_SESSION["lang"]=="_en"){ ?> 
        src="../../img/save.png"
        <?php }else{?>
        src="../../img/salva.png"
          <?php }?> onclick="salva()"  height="50" style="cursor:pointer;">
      <img src="../../img/schermointero.png" class="toggle_fullscreen open_b" style="cursor:pointer;" height="50" >
      <img src="../../img/riducischermo.png" class="toggle_fullscreen close_b" style="cursor:pointer; display:none;" height="50" > 

      <button type="button" class="btn btn-tool open_info" data-toggle="modal" data-target="#modal-lg" >
      <img src="../../img/info.png"  style="cursor:pointer;" height="50" >
                </button>
                <button type="button" class="btn btn-tool open_info" id="result" onclick="show_result(<?php echo $val['id_map']?>)">
      <img src="../../img/pc.png"  style="cursor:pointer;" height="50" >
                </button>
                </div>
       

        <div class="col-lg-2">
        <a class="next" onclick="plusSlides(+1)"><img src="../../img/freccia dx.png"  width="50" ></a>
        </div>               
</div>              
 
  
</div>
<?php
$puntini =$puntini."<span class='dot' onclick='currentSlide(".$pag.")'></span>";

 }
?>
 


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

      <?php include "../../modal.php";?>
<?php include "../../scripts.php";?>


<script> 

array_esatti=[[]]
var timer = 0
var interval = setInterval(function(){
 timer=timer+1;
}, 1000);

function show_result(idmap){

$("#risultati"+idmap).empty();

$("#risultati"+idmap).append("<img src='../../img/pc.png'  height='50' ><br>")
$("#risultati"+idmap).append(array_esatti[idmap][0]+"<br>"+array_esatti[idmap][1]);

}

function salva(){
  var giro = $("#valori").val();
  console.log(arraytext)

 
 

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "salva_esercizio.php");
  xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8")
  const body = JSON.stringify({
  idtext: <?php echo $id_text?>,
  iduser: <?php echo $_SESSION["id_alunno"]?>,
  language: "<?php echo $language ?>",
  risposta: arraytext,
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
<script>
    arraytext =[[]]
    </script>
<?php $qry ="select * from tab_map_exe where id_text =".$id_text." ";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){
  $pag=$pag+1;?>
  <script>
  
    arraytext[<?php echo $val["id_map"]?>] =[];
    $("#valori").val($("#valori").val()+"-<?php echo $val["id_map"]?>")
 console.log(arraytext)
</script>
<?php } ?>
<script>
 
function scegli(parola,idr){
  if (parola.length>0){


 parola =  parola.replace(".","")
 parola =  parola.replace(",","")
 parola =  parola.replace(";","")

  





    $("#risposta"+idr).append('<span style="cursor:pointer" onclick="rem(this,'+idr+')">'+parola+'<br><span>');
    arraytext[idr].push(parola);
  //  $('#modal-l2').modal('show');
  


}
}
function rem(ele,idr){
  $(ele).remove();
 var t = $(ele).text()

const index = arraytext[idr].indexOf(t);
console.log(index)
if (index>=0){
 arraytext[idr].splice(index,1);
}
}

</script>
<?php 
$qry ="select * from tab_map_exe where id_text =".$id_text."";
$rs = connetti($qry);
while($val = mysqli_fetch_array($rs)){?>
  <script>
  array_esatti[<?php echo $val["id_map"]?>]=[];
  
  </script>
  <?php
//carico i risultati
$qry2 ="select * from tab_keyword_exe where id_map=".$val["id_map"];
$rs2 = connetti($qry2);
$pass=[];
while($val2 = mysqli_fetch_array($rs2)){
 
  ?>
  <script>
array_esatti[<?php echo $val["id_map"]?>].push('<?php echo $val2["keyword"]?>')

</script>
<?php
 

}


//carico risposte date
  $qryrisp ="select * from tab_response_exe4 where id_map =".$val["id_map"]." and id_student=".$_SESSION["id_alunno"];
  $rsrisp = connetti($qryrisp);
  while ($valrisp =mysqli_fetch_array($rsrisp)){
    ?>
    <script>
      scegli('<?php echo $valrisp["response1"]?>',<?php echo $valrisp["id_map"]?>);
      scegli('<?php echo $valrisp["response2"]?>',<?php echo $valrisp["id_map"]?>);
      </script>
    <?php
  }
}
?>
