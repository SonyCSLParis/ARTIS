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


<aside class="main-sidebar sidebar-primary " style="background-color:#ccc;">
<div align="center">
<a href="<?php echo $base_dir?>/page.php" class="navbar-brand">
        <img src="<?php echo $base_dir;?>img/logoartis.png" alt="Artis Logo" class="brand-image " style="opacity: .8" width="50">
       
      </a>
</div>
<div class="sidebar">
<!--
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
<div class="image">
<img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
</div>
<div class="info">
<a href="#" class="d-block">Alexander Pierce</a>
</div>
</div>
-->


<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item"><a href="#" class="nav-link" alt="allarga"><i class="fas fa-arrows-alt-h"></i></a></li>
<li class="nav-item">
         <?php if($_SESSION["id_alunno"]<>"" && $_SESSION["livello"]<>"3"){?>
            <a href="#" class="nav-link"><img width="25" src="<?php echo $base_dir;?>img/avatar/<?php echo $_SESSION["img"]?>"></a>
          <?php } ?>
      
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
                <p><?php echo $txt;?></p>
              <?php
            }
            
          ?></a>
          </li>

<?php if($_SESSION["livello"]=="1" || $_SESSION["livello"]=="2"){?>
    <li class="nav-item">
<a href="<?php echo $base_dir?>pag/alunno/index.php" class="nav-link">
<i class="fas fa-users"></i>
    <p>
            <?php echo $lang["menu_alunno"]?> 
</p></a></li>
          <?php } ?>


          <?php if($_SESSION["id_alunno"]<>""){
            ?>
          <li class="nav-item">
          <a href="<?php echo $base_dir?>pag/testo/index.php" class="nav-link">
            <i class="fas fa-book"></i>
          <p>
            <?php echo $lang["menu_testo"]?></p></a></li> 
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
              $exercise_visibilita=[0,$linkesercizi1,$linkesercizi2,$linkesercizi3,$linkesercizi4];
              if($linkesercizi1==1 || $linkesercizi2==1 || $linkesercizi3==1 || $linkesercizi4==1){
                $linkesercizi=1;
              }else{
                $linkesercizi=0;
              }
            }
            
            ?>

            <?php if($linkleggi==1){?>
          <li class="nav-item">
        
            <a href="<?php echo $base_dir?>pag/leggi/index.php" class="nav-link"><i class="fas fa-book-reader"></i>
            <p><?php echo $lang["menu_leggi"]?></p></a>
          </li>
          <?php } ?>
          <?php if($linkvisualizza_testo==1){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/mappa/index.php" class="nav-link"><i class="fas fa-comment-alt"></i>
            <p><?php echo $lang["menu_mappa"]?></p></a>
          </li>
          <?php } ?>
          <?php if($linkvisualizza_parole==1){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/parole/index.php" class="nav-link"><i class="fas fa-walking"></i>
            <p><?php echo $lang["menu_parole"]?></p></a>
          </li>
          <?php } ?>
          <?php if($linkesercizi==1){?>
          <li class="nav-item">
            <a href="<?php echo $base_dir?>pag/esercizi/index.php" class="nav-link"><i class="fas fa-walking"></i>
            <p><?php echo $lang["menu_esercizi"]?></p></a>
          </li>
          <?php } ?>
          <?php } ?>



          <?php if($_SESSION["livello"]=="1" || $_SESSION["livello"]=="2"){?>
              <li class="nav-item">
              <a href="<?php echo $base_dir?>pag/gestionale_testo/elenco.php" class="nav-link">
              <i class="fas fa-th-large"></i> <p>Gestione</p>
              </a>
              </li>
           <?php } ?>
                <li class="nav-item">
                <span class="nav-link">
                <i class="fas fa-language"></i>
     <p>  <a href="?lang=it"><span class="fi fi-it " style="  margin-left: 1rem ;width: 25px;height:20px;<?php if($_SESSION["lang"]==""){?>border: 1px solid rgb(47, 0, 255);<?php }?>"></span></a> 
        
          
          <a href="?lang=en"><span class="fi fi-gb" style="  margin-left: 1rem ;width: 25px;height:20px;<?php if($_SESSION["lang"]=="_en"){?>border: 1px solid rgb(47, 0, 255);<?php }?>"></span></a>
          </p>
          <span>  
        </li>







<!--
 
<li class="nav-item">
<a class="nav-link" style="padding-right:0.2rem;"  href="<?php echo $base_dir?>/index.php" role="button">
<i class="fas fa-question"></i>
         
    <p> FAQ</p>
        </a>

   
</li>
          -->   
          <li class="nav-item">
<a class="nav-link" style="padding-right:0.2rem;"  href="<?php echo $base_dir?>/index.php" role="button">
<i class="fas fa-sign-out-alt"></i>
<p>Log out</p>
</a>




</li>

</ul>
<br>
</nav>

</div>
<br>
<!--
<div align="center" style="bottom: 0px;">
<div align="center">
<a href="<?php echo $base_dir?>/page.php" class="navbar-brand">
<img src="<?php echo $base_dir;?>img/SonyCSL_logo_2line_color_textlogo_black_Large.png" width="50">

       
      </a>
</div>
<div align="center" >
<a href="<?php echo $base_dir?>/page.php" class="navbar-brand">
<img src="<?php echo $base_dir;?>img/CRC_logotype-red.png" width="50">

       
      </a>
</div>
          </div>
          -->
</aside>
