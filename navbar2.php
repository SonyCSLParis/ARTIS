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
           <?php if($_SESSION["id_alunno"]<>"" && $_SESSION["id_text"]<>""){
           if($_SESSION["lang"]==""){
            $filtro= " and lang='it' ";
          }
          if($_SESSION["lang"]=="_en"){
            $filtro= " and lang='en' ";
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

</ul>
<ul class="navbar-nav ml-auto">
       
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
       <?php if($_SESSION["livello"]==3){
         ?>
       
               <a href="#" class="nav-link"><img width="25" src="<?php echo $base_dir;?>img/avatar/<?php echo $_SESSION["img"]?>"></a>
               <?php } ?>
       </li>
       <?php if($_SESSION["livello"]=="1" || $_SESSION["livello"]=="2"){?>
       <li class="nav-item">
       <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" title="Gestione"  onclick="window.scrollTo(0, 0);">
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