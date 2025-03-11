<!-- REQUIRED SCRIPTS -->
<div class="modal fade" id="modal-search" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Ricerca:<span id="title-search"></span></h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
 <span id="img-search"></span><br>
 <span id="def-search"></span>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>

</div>

</div>

<!-- jQuery -->
<script src="<?php echo $base_dir;?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $base_dir;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo $base_dir;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $base_dir;?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $base_dir;?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $base_dir;?>dist/js/adminlte.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
<!-- AdminLTE for demo purposes -->
<script>
$(".main-sidebar").show();
$(function() {
        $.contextMenu({
            selector: '.context-menu-one', 
            autoHide: true,
            items: {
                "play": {name: "Play", icon: "fas fa-play",callback: function(key, opt){
                  speak_select();
            }},
               
            }
        });

        $('.context-menu-one').on('click', function(e){
            console.log('clicked', this);
            if(this=="play"){
              console.log("play");

            }
        })    
    });


function speak_select(){
  const selObj1 = window.getSelection();
            paroladaricercare = selObj1;
            const synth = window.speechSynthesis;
            synth.cancel();
             var msg = new SpeechSynthesisUtterance();
            var rate =  sessionStorage.getItem("rate");
            var voices = synth.getVoices();
            msg.volume = 0.5; // From 0 to 1
            msg.rate = parseFloat(sessionStorage.getItem("rate")) // From 0.1 to 10
            msg.pitch = 1; // From 0 to 2
            msg.text = paroladaricercare;
            <?php if ($_SESSION["lang"]=="_en"){?>
              msg.lang = 'en';
              var v = voices.findIndex(x=>x.lang==='en-US')
              console.log(v)
              msg.voice = voices[v]; 
            <?php
            }
            ?>
            <?php if ($_SESSION["lang"]==""){?>
              msg.lang = 'it';
              var v = voices.findIndex(x=>x.lang==='it-IT')
              console.log(v)
              msg.voice = voices[v]; 
            <?php
            }
            ?>
            synth.speak(msg);
}


function updateRangeSlider(el){
    var val = el.value;
      console.log(val)
      var rate=1;
if(val==1){
  rate=0.6;
}
if(val==2){
  rate=0.8;
}
if(val==3){
  rate=1;
}
if(val==4){
  rate=1.2;
}
if(val==5){
  rate=1.4;
}
      sessionStorage.setItem("rate",rate);
      $("#velocita").empty()
      $("#velocita").append(rate+"x");
      const synth = window.speechSynthesis;
synth.cancel();
 var msg = new SpeechSynthesisUtterance();
 var wordIndex = 0;
var global_words = [];
var idtext ="";
msg.pitch = rate;
    } 


  var paroladaricercare=""
    function search_word_google() {
  const selObj1 = window.getSelection();

    paroladaricercare = selObj1;
    window.open('https://www.google.com/search?q='+selObj1, '_blank');
   

  
  const selRange = selObj.getRangeAt(0);
  // do stuff with the range
}
function search_word(lang) {
  const selObj = window.getSelection();

input = selObj.toString();
const selRange = selObj.getRangeAt(0);


var lang =lang;


  console.log(input.toString())
  $("#def-search").empty()
  $("#title-search").empty()
  $("#img-search").empty()
  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/get_definition",
    data: JSON.stringify ({word: input,language:lang}),
    success: function(res) { 
     
      $("#def-search").append(res)
 
},
    contentType: "application/json",
  
  });
  $.ajax({
    type: 'POST',
    url: "http://93.147.158.9:5002/see_another",
    data: JSON.stringify ({word: input,language:lang}),
    success: function(data) { 
      var txt="";
     
      $("#title-search").append(input)
   
      
      for (var x in data){
        urlimg=data[x].replace("'","")
        
       
          txt = txt + "<img src='"+urlimg+"' width='100' >";
        
        
      }
      $("#img-search").append(txt)
     
     // alert('data: ' + data);
    
    
    
    },
    contentType: "application/json",
    dataType: 'json'
});
$("#modal-search").modal('show');
}
if (sessionStorage.getItem("darkmode")==1){
  $('body').addClass('dark-mode');
}else{
  $('body').removeClass('dark-mode');
}

if(sessionStorage.getItem("fontsize")!=null){

  adatta(sessionStorage.getItem("fontsize"))

}else{
  console.log("entro");
  $("#velocita").empty()
      $("#velocita").append("1x");
  sessionStorage.setItem("rate",1);
  sessionStorage.setItem("fontsize",0); 
  sessionStorage.setItem("fontsize_opt",18); 
  sessionStorage.setItem("fontsize_h5",16); 
  sessionStorage.setItem("fontsize_h3",24); 
  sessionStorage.setItem("fontsize_h1",24); 
  sessionStorage.setItem("fontsize_sel",18); 
  sessionStorage.setItem("fontsize_wra",18); 

}

function darkmode(){
 if($('body').hasClass("dark-mode")){
  $('body').removeClass('dark-mode');
  sessionStorage.setItem("darkmode", "0");
  
 }else{
  sessionStorage.setItem("darkmode", "1");
  $('body').addClass('dark-mode');


 }
 


}
function minfont(){
  var fontsize = sessionStorage.getItem("fontsize");
  fontsize = parseInt(fontsize)-1;
  sessionStorage.setItem("fontsize", fontsize);
  adatta(fontsize);
}

function addfont(){
  var fontsize = sessionStorage.getItem("fontsize");
  fontsize = parseInt(fontsize)+1;
  sessionStorage.setItem("fontsize", fontsize); 
  adatta(fontsize);
}
function adatta(fontsize){

  font_contentwrapper =  sessionStorage.getItem("fontsize_wra"); 
  console.log(parseInt(fontsize))
  console.log(parseInt(font_contentwrapper) )


  $(".content-wrapper").css("fontSize", (parseInt(font_contentwrapper)  + parseInt(fontsize)).toString()+"px");


  
  
  
  font_option = sessionStorage.getItem("fontsize_opt");
  $("option").css("fontSize", (parseInt(font_option) + parseInt(fontsize)).toString()+"px");

  font_select = sessionStorage.getItem("fontsize_sel");
  $("select").css("fontSize", (parseInt(font_select) + parseInt(fontsize)).toString()+"px");
  $("select").css("line-height", (parseInt(font_select) + parseInt(fontsize)).toString()+"px");

  font_fc = sessionStorage.getItem("fontsize_fc");
  $(".form-control").css("fontSize", (parseInt(font_fc) + parseInt(fontsize)).toString()+"px");
  font_h5 = sessionStorage.getItem("fontsize_h5");
  $("h5").css("fontSize", (parseInt(font_h5)  + parseInt(fontsize)).toString()+"px");

  font_h3 = sessionStorage.getItem("fontsize_h3");
  $("h3").css("fontSize", (parseInt(font_h3) + parseInt(fontsize)).toString()+"px");
  font_h1 =  sessionStorage.getItem("fontsize_h1");
  $("h1").css("fontSize", (parseInt(font_h1) + parseInt(fontsize)).toString()+"px");
}
function chiudil1(){
  $('#modal-l1').modal('hide');
  window.location.href="../esercizi/index.php";
  console.log("entro");
}

</script>



<?php
if ($chkW==1){?>
<script>
$("#modal-l1").modal('show');
</script>

 

<?php 
}
?>

<?php
if ($chkW==2){?>
<script>
$("#modal-l2").modal('show');
</script>

 

<?php 
}
?>