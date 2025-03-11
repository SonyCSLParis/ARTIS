  <!-- Navbar -->
  <?php if($_GET["lang"]=="en"){
    $_SESSION["lang"]="_en";
  }
    if($_GET["lang"]=="it" || $_SESSION["lang"]==""){
      $_SESSION["lang"]="";
  }
  
  if($_SESSION["lang"]==""){
    include('lang/lang.it.php');
  }
  if($_SESSION["lang"]=="_en"){
    include('lang/lang.en.php');
  }
  
  ?>
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="<?php echo $base_dir?>/page.php" class="navbar-brand">
        <img src="<?php echo $base_dir;?>img/logoartis.png" alt="Artis Logo" class="brand-image " style="opacity: .8">
       
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <?php if($_SESSION["livello"]=="1" || $_SESSION["livello"]=="2"){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/alunno/index.php" class="nav-link"><?php echo $lang["menu_alunno"]?> </a>
          </li>
          <?php } ?>
          <?php if($_SESSION["id_alunno"]<>""){
            ?>
          <li class="nav-item">
          <a href="<?php echo $base_dir?>pag/testo/index.php" class="nav-link"><?php echo $lang["menu_testo"]?></a>
          </li> 
          <?php
        }
        ?>
         <li class="nav-item">
         <?php if($_SESSION["id_alunno"]<>"" && $_SESSION["livello"]<>"3"){?>
            <a href="#" class="nav-link"><img width="25" src="<?php echo $base_dir;?>img/avatar/<?php echo $_SESSION["img"]?>"></a>
          <?php } ?>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link"><?php
            if($_SESSION["id_text"]<>""){
             
                $qry ="select * from tab_text where id_text=".$_SESSION["id_text"];
                $rs = connetti($qry);
                while($val=mysqli_fetch_array($rs)){
                  $txt= $val["title"];
                }
                $filename= $base_dir."img/libri/".$_SESSION["id_text"].".jpg";
                if (file_exists($filename)) {
                }else{
                  $filename=$base_dir."img/Book.png";
                }
              ?>
                <img src="<?php echo $filename?>" width="25" title="<?php echo $txt;?>">
              <?php
            }
            
          ?></a>
          </li>
           <?php if($_SESSION["id_alunno"]<>"" && $_SESSION["id_text"]<>""){
           if($_SESSION["lang"]==""){
            $filtro= " and lang='it' ";
          }
          if($_SESSION["lang"]=="_en"){
            $filtro= " and lang='en' ";
          }
            $qrylink ="select * from tab_confirm where id_text=".$_SESSION["id_text"].$filtro;
            $rslink=connetti($qrylink);
            while($vallink=mysqli_fetch_array($rslink)){

              $linkleggi= $vallink["leggi"];
              $linkvisualizza_testo= $vallink["visualizza_testo"];
              $linkvisualizza_parole=$vallink["visualizza_parole"];

              $linkesercizi1=$vallink["esercizi1"];
              $linkesercizi2=$vallink["esercizi2"];
              $linkesercizi3=$vallink["esercizi3"];
              $linkesercizi4=$vallink["esercizi4"];
              $linkesercizi5=$vallink["esercizi5"];
              $exercise_visibilita=[0,$linkesercizi1,$linkesercizi2,$linkesercizi3,$linkesercizi4,$linkesercizi5];
              if($linkesercizi1==1 || $linkesercizi2==1 || $linkesercizi3==1 || $linkesercizi4==1 || $linkesercizi5==1){
                $linkesercizi=1;
              }else{
                $linkesercizi=0;
              }
            }
            
            ?>

            <?php if($linkleggi==1){?>
          <li class="nav-item">
        
            <a href="<?php echo $base_dir?>pag/leggi/index.php" class="nav-link"><?php echo $lang["menu_leggi"]?></a>
          </li>
          <?php } ?>
          <?php if($linkvisualizza_testo==1){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/mappa/index.php" class="nav-link"><?php echo $lang["menu_mappa"]?></a>
          </li>
          <?php } ?>
          <?php if($linkvisualizza_parole==1){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/parole/index.php" class="nav-link"><?php echo $lang["menu_parole"]?></a>
          </li>
          <?php } ?>
          <?php if($linkesercizi==1){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/esercizi/index.php" class="nav-link"><?php echo $lang["menu_esercizi"]?></a>
          </li>
          <?php } ?>
          <?php } ?>
         
       
        
       
        </ul>

        <ul class="navbar-nav ml-auto">
        <li class="nav-item">

    <!-- a strong element with the custom content, in this case a number -->
    <span style="    font-weight: 900;
    color: white;
    background-color: #7f7f7f;
    padding: 5px;
    border-radius: 5px;
    font-size: 70%;
    color: white;
  text-align:center;
    display: inline-block;
    width: 34px;
    vertical-align: bottom;
" id="velocita">
        1x
          </span>

       
  
                  <input type="range" style="width:50px;margin-top:12px;" min="1" max="5" class="custom-range" id="customRange1"  oninput="updateRangeSlider(this)" onchange="updateRangeSlider(this)"> 
                
        </li>
<li class="nav-item">
<a class="nav-link" style="padding-left: 0.2rem ;padding-right:0.2rem;"  onclick="darkmode()" role="button" title="Attiva/disattiva dark mode">
<i class="fas fa-adjust"></i>
</a>
</li>
<li class="nav-item">
<a class="nav-link"  style="padding-left: 0.2rem ;padding-right:0.2rem;"  onclick="addfont()" role="button" title="Aumenta il font">
<i class="fas fa-plus-square"></i>
</a>
</li>
<li class="nav-item">
<a class="nav-link" style="padding-left: 0.2rem ;padding-right:0.2rem;"  onclick="minfont()" role="button" title="Diminuisci il font">
<i class="fas fa-minus-square"></i>
</a>
</li>


<li class="nav-item" style="margin-left:5px;margin-top: 7px;">
       <a href="?lang=it"><span class="fi fi-it " style="width: 25px;height:20px;<?php if($_SESSION["lang"]==""){?>border: 1px solid rgb(47, 0, 255);<?php }?>"></span></a> 
        
          </li>


          <li class="nav-item" style="margin-left:5px;margin-top: 7px;">
          <a href="?lang=en"><span class="fi fi-gb" style="width: 25px;height:20px;<?php if($_SESSION["lang"]=="_en"){?>border: 1px solid rgb(47, 0, 255);<?php }?>"></span></a>
          </li>
        <li class="nav-item" style="margin-left:5px;margin-top: 7px;">
<?php if($_SESSION["livello"]==3){
  ?>

        <a href="#" class="nav-link"><img width="25" src="<?php echo $base_dir;?>img/avatar/<?php echo $_SESSION["img"]?>"></a>
        <?php } ?>
</li>
<?php if($_SESSION["livello"]=="1" || $_SESSION["livello"]=="2"){?>
<li class="nav-item">
<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" title="Gestione" onclick="window.scrollTo(0, 0);">
<i class="fas fa-th-large"></i>
</a>
</li>
<?php } ?>
<li class="nav-item">
<a class="nav-link" style="padding-right:0.2rem;"  href="<?php echo $base_dir?>/index.php" role="button">
<i class="fas fa-sign-out-alt"></i>
</a>




</li>

</ul>

      </div>


    </div>
    
  </nav>
  <!-- /.navbar -->