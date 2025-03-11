
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
 function trova_giusto($var)
 {
  if($var[1]==1){
    return($var & 1);
  }
 
 }

function calcola_risultati($id_ex,$id_te =0){
  $lang="it";
  if($_SESSION["lang"]=="_en"){
    $lang="en";
  }
  $totale=0;
  $risposte=0;
  /// id exercise = 1 e 2 domanda risposta
  // 3 pronomi

  if ($id_ex==1 || $id_ex==2){
    $qrycheck ="select * from tab_question where  id_text =".$_SESSION["id_text"]." and id_exercise= ".$id_ex." and lang ='".$lang."'";
    $rschk =connetti($qrycheck);
    while($valcheck =mysqli_fetch_array($rschk)){

        $idquestion=$valcheck["id_question"];


   
    $qryv ="select * from tab_result where id_student=".$_SESSION["id_alunno"]." and id_question= ".$idquestion." and id_version=0";
    $rsv = connetti($qryv);
    while ($val1 =mysqli_fetch_array($rsv)){
      $totale = $totale+1;
      if ($val1["result"]<>""){
        $risposte = $risposte +1;
      }else{
        if ($val1["multi"]==1 && $val1["id_result"]>0){
          $risposte=$risposte +1;
        }
      }
  
    }
  }
    $risultato = round($totale/5);  
    $ri = round($risposte/$risultato); 
    $r="";
    for($z=0; $z<$ri; $z++){
      $r =$r."<span class='float-right text-sm text-warning'><i class='fas fa-star'></i></span>";

    }

    for($z=0; $z<5-$ri;$z++){
      $r =$r."<span class='float-right text-sm text-muted'><i class='fas fa-star'></i></span>";

    }
}
if ($id_ex==3 ){

$qrycheck="Select * from tab_pronouns where lang='".$lang."'";
$rschk = connetti($qrycheck);
while($valchk = mysqli_fetch_array($rschk)){


  $qryv ="select * from tab_response_pronouns where id_student=".$_SESSION["id_alunno"]." and id_text =".$_SESSION["id_text"]." and id_pronouns= ".$valchk["id_pronouns"]." and id_version=0";
  $rsv = connetti($qryv);
  while ($val1 =mysqli_fetch_array($rsv)){
    $totale = $totale+1;
    if ($val1["response"]<>"0"){
      $risposte = $risposte +1;
    }
  }
}
  $risultato = round($totale/5);  
    $ri = round($risposte/$risultato); 
    $r="";
    for($z=0; $z<$ri; $z++){
      $r =$r."<span class='float-right text-sm text-warning'><i class='fas fa-star'></i></span>";

    }

    for($z=0; $z<5-$ri;$z++){
      $r =$r."<span class='float-right text-sm text-muted'><i class='fas fa-star'></i></span>";

    }
}
if ($id_ex==4 ){


  $qrycheck="Select * from tab_map_exe where id_text=".$id_te."";
  $rschk = connetti($qrycheck);
  while($valchk = mysqli_fetch_array($rschk)){
    $totale = $totale+2;
  
    $qryv ="select * from tab_response_exe4 where id_student=".$_SESSION["id_alunno"]." and id_map =".$valchk["id_map"]." and id_version=0";
    $rsv = connetti($qryv);
    while ($val1 =mysqli_fetch_array($rsv)){
      
      if (strlen($val1["response1"])>0){
        $risposte = $risposte +1;
      }
      if (strlen($val1["response2"])>0){
        $risposte = $risposte +1;
      }
    }
  }

    $risultato = round($totale/5);  
      $ri = round($risposte/$risultato); 
      $r="";
      for($z=0; $z<$ri; $z++){
        $r =$r."<span class='float-right text-sm text-warning'><i class='fas fa-star'></i></span>";
  
      }
  
      for($z=0; $z<5-$ri;$z++){
        $r =$r."<span class='float-right text-sm text-muted'><i class='fas fa-star'></i></span>";
  
      }
  }

  if ($id_ex==5 ){


    $qrycheck="Select * from tab_synset where id_word=".$id_te." and giusto=1";
    $rschk = connetti($qrycheck);
    while($valchk = mysqli_fetch_array($rschk)){
      $totale = $totale+1;
     }


      $qryv ="select * from tab_response_synset where id_student=".$_SESSION["id_alunno"]." and id_word =".$id_te." and id_version=0";
   
      $rsv = connetti($qryv);
      $ris_arr=[];

     
      while ($val1 =mysqli_fetch_array($rsv)){
        $ris_arr = unserialize($val1["response"]);
       
        for  ($x =0;$x<count($ris_arr);$x++ ){
         if( $ris_arr[$x][1]==1){
          $risposte=$risposte+1;
         };

        }
      }
   
  
      $risultato = round($totale/5);  
      if ($risposte>0){
        $risposte=$risposte-1;
      }
   
        $ri = round($risposte/$risultato); 
        $r="";
        for($z=0; $z<$ri; $z++){
          $r =$r."<span class='float-right text-sm text-warning'><i class='fas fa-star'></i></span>";
    
        }
    
        for($z=0; $z<5-$ri;$z++){
          $r =$r."<span class='float-right text-sm text-muted'><i class='fas fa-star'></i></span>";
    
        }
    }
    return  $risposte." / ".$totale." ".$r;

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
            <h1 class="m-0" align="center"><?php echo $lang["esercizi_titolo"]?></h1><hr>
          
            <?php echo $lang["esercizi_esercizio"]?>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
      <div class="row">

 <?php $qry="select * from tab_exercise";
 $rs=connetti($qry);
 while($val=mysqli_fetch_array($rs)){
  if ($val["id_exercise"]!=4 && $val["id_exercise"]!=5){


 if ($exercise_visibilita[$val["id_exercise"]]==1){
  ?>
 
   
<div class="col-lg-6 col-6">

<div class="small-box bg-info">
<div class="inner">
<h3><?php echo strtoupper($val["title".$_SESSION["lang"]])?></h3>

<!-- totale esercizi da fare quelli già fatti-->
<?php echo calcola_risultati($val["id_exercise"])?>



<p><?php echo $val["info".$_SESSION["lang"]]?> </p>
</div>

<a href="<?php echo $base_dir;?>pag/<?php echo $val["link"]?>/index.php" class="small-box-footer">VAI <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<?php
 }
}else{?>

  <?php 
  if($_SESSION["lang"]=="_en"){
    $l = "en";
  }else{
    $l="it";
  }
  $array =$_SESSION['id_suitable'];
  $filtro_suitable =" id_suitable >0 ";  
  foreach ($array as $i => $value) {
      $filtro_suitable = $filtro_suitable. " or id_suitable = ".$array[$i]."" ;
  }
  if ($val["id_exercise"]==4){


      $qryloop ="select * from tab_text_exe where (".$filtro_suitable.") and attiva=1 and language='".$l."'";

      $rsloop = connetti($qryloop);
      while($vall = mysqli_fetch_array($rsloop)){?>
    
          <div class="col-lg-6 col-6">
          <div class="small-box bg-info">
          <div class="inner">
          <h3><?php echo strtoupper($val["title".$_SESSION["lang"]])?></h3>
          <!-- totale esercizi da fare quelli già fatti-->
          <?php echo calcola_risultati($val["id_exercise"],$vall["id_text"])?>
          <p><?php echo $vall["title"]?> </p>
          </div>
          <a href="<?php echo $base_dir;?>pag/<?php echo $val["link"]?>/index.php?id_text=<?php echo $vall["id_text"]?>" class="small-box-footer">VAI <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          </div>

    <?php
    }
  }
  if ($val["id_exercise"]==5){
    $qryloop ="select * from tab_word where (".$filtro_suitable.") and attiva=1 and language='".$l."'";
    $rsloop = connetti($qryloop);
    while($vall = mysqli_fetch_array($rsloop)){?>
        <div class="col-lg-6 col-6">
        <div class="small-box bg-info">
        <div class="inner">
        <h3><?php echo strtoupper($val["title".$_SESSION["lang"]])?></h3>
        <!-- totale esercizi da fare quelli già fatti-->
        <?php echo calcola_risultati($val["id_exercise"],$vall["id_word"])?>
        <p><?php echo $vall["word"]?> </p>
        </div>
        <a href="<?php echo $base_dir;?>pag/<?php echo $val["link"]?>/index.php?id=<?php echo $vall["id_word"]?>" class="small-box-footer">VAI <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
  
  <?php
   }
  
  
  
    }


}


}?>



</div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>
</body>
</html>
