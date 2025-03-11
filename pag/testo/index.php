
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
include "../../header.php";
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center"><?php echo $lang["testo_titolo"]?></h1>
            <hr>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div  >
       
      <form method="get">         




<?php if ($_SESSION["id_text"]>0){?>

<div class="row">
<div class="col-lg-4">
</div>
<div class="col-lg-4">
<?php $qry ="select * from tab_text where id_text=".$_SESSION["id_text"];
                $rs = connetti($qry);
                while($val=mysqli_fetch_array($rs)){
                  $txt= $val["title"];
                
                  $filename= "../../img/libri/".$val["id_text"].".jpg";
                if (file_exists($filename)) {
                }else{
                  $filename=$base_dir."img/no_img_available.png";
                }
              ?>
              
                <div class="card card-primary">

                <div class="card-header">
                <h3 class="card-title"><?php echo $val["title".$_SESSION["lang"]];?></h3>
                <div class="card-tools">
                </div> <br><br>   
                <div  style="background-image: url('<?php echo $filename?>'); background-size: cover; background-repeat: no-repeat;  background-position: center; height: 250px; ;border:solid; ">
                    </div>
                        </a>
                    </div>
                    <div class="card-body" >
                      <div style=" overflow: hidden;
                      display: -webkit-box;
                      -webkit-line-clamp: 3;
                      -webkit-box-orient: vertical;">
                    <?php echo $val["text".$_SESSION["lang"]];?>

                        </div>
              </div>


</div>   
    </div>
    </div>
    <?php }
  } ?>
    <label for="title">
  <?php echo $lang["testo_esercizio"]?>
</label>
<div class="row">

  <?php 
  if($_SESSION["lang"]=="_en"){
    $l = 'en';
  }else{
    $l ='it';
  }
  
  if($_SESSION["id_alunno"]<>"" ){
    $qrysui ="select * from tab_classe where id_student=".$_SESSION["id_alunno"];
    $rssui = connetti($qrysui);
    $chk=0;
    while($valsui = mysqli_fetch_array($rssui)){


    
    $qry ="SELECT * FROM artisdb.tab_text inner join artisdb.tab_confirm on tab_text.id_text=tab_confirm.id_text where leggi=1 and id_suitable=".$valsui["id_suitable"]. " and lang='".$l."'";
    $rs= connetti($qry);
    $num = mysqli_num_rows($rs);
    if($num>0){
      $chk=1;
    }
   
    while($val=mysqli_fetch_array($rs)){?>
    <div class="col-lg-3">
    <div class="card card-primary"<?php if  ($_SESSION["id_text"]==$val["id_text"]){ ?> style="border:solid 4px #3c00fb;  border-radius: 10px; "<?php } ?>>
<div class="card-header">
<h3 class="card-title"><?php echo $val["title".$_SESSION["lang"]];?></h3>
<div class="card-tools">
</div><br><br>
<?php if  ($_SESSION["id_text"]==$val["id_text"]){ ?><?php } ?>
<a href="?title=<?php echo $val["id_text"]?>">

<?php
$filename= "../../img/libri/".$val["id_text"].".jpg";
    

if (file_exists($filename)) {
                }else{
                  $filename=$base_dir."img/no_img_available.png";
                }
              ?>
              
<div  style="background-image: url('<?php echo $filename?>'); background-size: cover; background-repeat: no-repeat;  background-position: center; height: 250px; ;border:solid; ">
</div>
    </a>
</div>
<div class="card-body" >
  <div style=" overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;">
<?php echo $val["text".$_SESSION["lang"]];?>

    </div>



</div>

</div>
  
</div>

    <?php 
    }

    }
    if($chk==0){

      echo "Non ci sono libri";

      
    }

}?>

</div>
 </form>       <!-- /.row -->
      </div><!-- /.container-fluid -->
  <br>  </div>
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
 function play_text(text){

synth.cancel();
  var words   = text.split(" ");
    global_words = words;
    spokenTextArray = words;
  $("#play").hide();
  $("#resume").show();
  drawTextInPanel(words);
var voices = synth.getVoices();
console.log(voices);
msg.voice = voices[1]; 
msg.volume = 0.5; // From 0 to 1
msg.rate = 1; // From 0.1 to 10
msg.pitch = 1; // From 0 to 2
msg.text = text;
msg.lang = 'it';
synth.speak(msg);
} 


msg.onboundary = function(event){
  	var e = document.getElementById('textarea');
  	var word = getWordAt(e.textContent,event.charIndex);
    // Show Speaking word : x
  	document.getElementById("word").innerHTML = word;
    //Increase index of span to highlight
    console.info(global_words[wordIndex]);
    
    try{
    	document.getElementById("word_span_"+wordIndex).style.color = "blue";
    }catch(e){}
    
    wordIndex++;
};

msg.onend = function(){
		document.getElementById("word").innerHTML = "";
    wordIndex = 0;
    document.getElementById("panel").innerHTML = "";
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
