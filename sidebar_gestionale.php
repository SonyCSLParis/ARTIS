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
  if ($_GET["disattiva"]=="1"){
    $_SESSION["id_text_gestionale"]="";
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


<?php if ($_SESSION["id_text_gestionale"]<>""){
  $qry ="select * from tab_text where id_text=".$_SESSION["id_text_gestionale"];
  $rs = connetti($qry);
  while($val=mysqli_fetch_array($rs)){
    $txt= $val["title"];
  }?>
<li class="nav-item"><hr></li>
  <li class="nav-item"><a href="../gestionale_testo/modifica_testo.php?id=<?php echo $_SESSION["id_text_gestionale"]?>" class="nav-link" style="background-color:#007bff;"> 
    <i class="fas fa-arrow-right" style="color:#fff"></i> <p style="color:#fff" ><?php echo $txt;?></p></a></li>
    <li class="nav-item"><a href="?disattiva=1&id=<?php echo $_SESSION["id_text_gestionale"]?>"  class="nav-link"> <i class="fas fa-times-circle"></i> <p>Deseleziona</p></a></li>
  <?php
 $qrychk ="select * from tab_confirm where id_text=".$_SESSION["id_text_gestionale"];
$rschk = connetti($qrychk);
while ($valchk= mysqli_fetch_array($rschk)){
  if($valchk["lang"]=="en"){
    $estensione="_en";
    $bandiera="gb";
  }else{
    $estensione="";
    $bandiera="it";
  }

?>  <li class="nav-item">
   <a href="../gestionale_testo/ins_img.php?id=<?php echo $_SESSION["id_text_gestionale"]?>" class="nav-link"><i class="fas fa-circle" style="color: <?php echo $clas;?>;"></i>
<p>IMG Biblioteca</p></a>
</li>
<li class="nav-item"><p class="nav-link"><span class="fi fi-<?php echo $bandiera?>"></span></p></li>
<li class="nav-item">
<?php if ($valchk["leggi"]==1){
  $clas = "green";
}else{
  $clas = "red";
}?> 
<a href="../gestionale_testo/modifica_testo.php?id=<?php echo $_SESSION["id_text_gestionale"]?>" class="nav-link"><i class="fas fa-circle" style="color: <?php echo $clas;?>;"></i>
<p>Gestione testo</p></a>
</li>
    <li class="nav-item">
    <?php if ($valchk["visualizza_testo"]==1){
  $clas = "green";
}else{
  $clas = "red";
}?> 
<a href="../gestionale_testo/modifica_mappa<?php echo $estensione?>.php?id=<?php echo $_SESSION["id_text_gestionale"]?>"  class="nav-link"><i class="fas fa-circle" style="color: <?php echo $clas;?>;"></i>
<p>Gestione mappa</p></a>

</li>

<li class="nav-item">
<?php if ($valchk["visualizza_parole"]==1){
  $clas = "green";
}else{
  $clas = "red";
}?> 
<a href="../gestionale_testo/genera_parole<?php echo $estensione?>.php?id=<?php echo $_SESSION["id_text_gestionale"]?>"  class="nav-link"><i class="fas fa-circle" style="color: <?php echo $clas;?>;"></i>
<p>Gestione parole</p></a>

</li>
<li class="nav-item">
<?php if ($valchk["esercizi1"]==1){
  $clas = "green";
}else{
  $clas = "red";
}?> 
<a href="../gestionale_testo/genera_esercizio1<?php echo $estensione?>.php?id=<?php echo $_SESSION["id_text_gestionale"]?>" class="nav-link" ><i class="fas fa-circle" style="color: <?php echo $clas;?>;"></i>
<p>Gestione es. iniziale</p></a>

</li>



<?php


}?>
<li class="nav-item"><hr></li>
<?php
}
?>

<li class="nav-item">
<a href="#" class="nav-link "><i class="fas fa-book-open"></i> <p><?php echo $lang["menu_gestionale"]?><i class="fas fa-angle-left right"></i></p></a> 
<ul class="nav nav-treeview" style="display: none;  ">
      <li class="nav-item">      
        <a href="<?php echo $base_dir?>pag/gestionale_testo/elenco.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Elenco libri</p></a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $base_dir?>pag/gestionale_testo/ins_testo.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Nuovo Libro</p></a>
      </li>
  <!--    <li class="nav-item">
        <a href="<?php echo $base_dir?>pag/gestionale_testo/ins_test_img.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Nuovo Libro da img</p></a>
      </li>
-->
      <li class="nav-item">
      <a class="nav-link"><hr></a>
      </li>
   </ul>
</li>
<li class="nav-item">
<a href="#" class="nav-link "><i class="fas fa-walking"></i> <p>Gestione esercizi<i class="fas fa-angle-left right"></i></p></a> 
<ul class="nav nav-treeview" style="display: none;  ">
      <li class="nav-item">      
        <a href="<?php echo $base_dir?>pag/gestionale_esercizio4/elenco_esercizio4.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Trova parole</p></a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $base_dir?>pag/gestionale_esercizio4/genera_esercizio4.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Nuova parola</p></a>
      </li>
      <li class="nav-item">
      <a class="nav-link"><hr></a>
      </li>
      <li class="nav-item">      
        <a href="<?php echo $base_dir?>pag/gestionale_esercizio5/elenco_esercizio5.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Reti semantiche</p></a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $base_dir?>pag/gestionale_esercizio5/genera_esercizio5.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
        <p>Nuova rete</p></a>
      </li>
      <li class="nav-item">
      <a class="nav-link"><hr></a>
      </li>
   </ul>
</li>
<li class="nav-item">
<a href="#" class="nav-link "><i class="fas fa-users"></i><p> Gestione gruppi<i class="fas fa-angle-left right"></i></p></a> 
<ul class="nav nav-treeview" style="display: none; ">
<li class="nav-item"><a href="<?php echo $base_dir?>pag/gestione_gruppi/elenco.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
<p>Elenco gruppi</p></a></li>
<li class="nav-item"><a href="<?php echo $base_dir?>pag/gestione_gruppi/nuovo.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
<p>Nuovo gruppo</p></a></li>
<li class="nav-item">
      <a class="nav-link"><hr></a>
      </li>
</ul>
</li> 
<li class="nav-item">
    <a href="#" class="nav-link "><i class="fas fa-user"></i><p> <?php echo $lang["menu_gestionale1"]?><i class="fas fa-angle-left right"></i></p></a> 
      <ul class="nav nav-treeview" style="display: none; ">
          <li class="nav-item" ><a href="<?php echo $base_dir?>pag/gestionale_alunni/elenco.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i><p>Elenco alunni</p></a></li>
          <li class="nav-item" ><a href="<?php echo $base_dir?>pag/gestionale_alunni/nuovo.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i><p>Nuovo alunno</p></a></li>
          <li class="nav-item">
      <a class="nav-link"><hr></a>
      </li>
        </ul>
</li>

<li class="nav-item">
<a href="#" class="nav-link "><i class="fas fa-user-cog"></i><p> <?php echo $lang["menu_gestionale2"]?><i class="fas fa-angle-left right"></i></p></a> 
<ul class="nav nav-treeview" style="display: none; ">
<li class="nav-item"><a href="<?php echo $base_dir?>pag/gestionale_utenti/elenco.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
<p>Elenco utenti</p></a></li>
<li class="nav-item"><a href="<?php echo $base_dir?>pag/gestionale_utenti/nuovo.php" class="nav-link"> &nbsp;&nbsp;<i class="fas fa-circle"></i>
<p>Nuovo utente</p></a></li>
<li class="nav-item">
      <a class="nav-link"><hr></a>
      </li>
</ul>
</li> 







<li class="nav-item">
<a href="<?php echo $base_dir?>pag/gestionale_testo/gestione_parole.php" class="nav-link "><i class="fas fa-book-open"></i> <p>Gestione immagini<i class="fas fa-angle-left right"></i></p></a> 
</li>




<li class="nav-item">
            <span class="nav-link">
          <i class="fas fa-universal-access"></i><p>
         
                <a  style="padding-left: 0.8rem ;padding-right:0.2rem;"  onclick="addfont()" role="button" title="Aumenta il font">
                <i class="fas fa-plus-square"></i>
                </a>
                <a  style="padding-left: 0.8rem ;padding-right:0.2rem;"  onclick="minfont()" role="button" title="Diminuisci il font">
        <i class="fas fa-minus-square"></i></a>
          </p>
          </span>
            </li>
          
                <li class="nav-item">
<a class="nav-link" style="padding-right:0.2rem;"  href="<?php echo $base_dir?>/page.php" role="button">
<i class="fas fa-question"></i>
         
    <p> FAQ</p>

</a>
</li>

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
<!--
<br>
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
