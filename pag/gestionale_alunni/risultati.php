
<?php
// Start the session
session_start();
?>

<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 


?>
<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >

      <br><br>
      <div class="col-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Alunno: <?php $q ="select * from tab_student where id_student=".$_GET["id_student"];
$r = connetti($q);
$v = mysqli_fetch_array($r);
echo $v["name"];?></h3><br><br>
<form method="POST" action="risultati.php?id_student=<?php echo $v["id_student"]?>">
<select name="libro">
<option value="0">Tutti i libri</option>
<?php $qryst="select * from tab_text where id_suitable=".$v["id_suitable"];
$rsst= connetti($qryst);
while($valst = mysqli_fetch_array($rsst)){
?>
<option value="<?php echo $valst["id_text"]?>" <?php if($_POST["libro"]==$valst["id_text"]){echo "selected";}?>><?php echo $valst["title"]?></option>
<?php
}
?>
</select>
<select name="esercizio">
<option value="0">Tutti gli esercizi</option>
<?php $qryst="select * from tab_exercise ";
$rsst= connetti($qryst);
while($valst = mysqli_fetch_array($rsst)){
?>
<option value="<?php echo $valst["id_exercise"]?>" <?php if($_POST["esercizio"]==$valst["id_exercise"]){echo "selected";}?>><?php echo $valst["title"]?></option>
<?php
}
?>
</select>
<select name="language">
<option>it</option>
<option>en</option>

</select>
<input type="submit" value="Filtra" name="pul_filtra">
</form>


</div>
 
<div class="card-body table-responsive p-0">
<table class="table table-hover ">
<thead>
<tr>

<th>Domanda</th>
<th>Risposta</th>
<th>Data</th>
<th>Version</th>
</tr>
</thead>
<tbody>
<?php 
$l="it";
if ($_POST["pul_filtra"]=="Filtra"){
//libri
if($_POST["libro"]>0){
  $filtrolibri =" and id_text=".$_POST["libro"]." ";
}
if($_POST["esercizio"]>0){
$filtroesercizi=" and id_exercise=".$_POST["esercizio"]." ";
}
if ($_POST["lang"]=="it"){
  $l="it";
}
if ($_POST["lang"]=="en"){
  $l="en";
}
}

$qry="SELECT id_exercise,id_text FROM artisdb.tab_result where id_student=".$_GET["id_student"].$filtrolibri.$filtroesercizi." group by id_exercise,id_text order by id_text";
$rs = connetti($qry);
while($val=mysqli_fetch_array($rs)){
  ?>
  <tr onclick="$('.es<?php echo $val["id_exercise"]?>_<?php echo $val["id_text"]?>').toggle()"><td colspan="4">Esercizo <?php echo $val["id_exercise"]?> <?php echo visualizza_titolo_testo($val["id_text"])?></td></tr>
  <?php
  if ($val["id_exercise"]==1 || $val["id_exercise"]==2 ){
      $qry1="select * from tab_question where id_exercise = ".$val["id_exercise"]." and id_text =".$val["id_text"]." and lang='".$l."'";
      $rs1=connetti($qry1);
      while($val1=mysqli_fetch_array($rs1)){
          $qry2="Select * from tab_result where id_question =".$val1["id_question"]." order by id_version";
          $rs2=connetti($qry2);
          while($val2=mysqli_fetch_array($rs2)){
              ?>
              <tr class="es<?php echo $val["id_exercise"]?>_<?php echo $val["id_text"]?>" style="display:none;">
              <td><?php echo $val1["question"]?></td>
              <td><?php echo $val2["result"]?></td>
              <td><?php 
              if( $val2["id_version"]>0){
                echo $val2["datearc"];
              }else{
                echo $val2["lastUpdated"];
              }
             ?></td>
              <td><?php echo $val2["id_version"]?></td>
            </tr>
              <?php
          } 
      }
  }
  /// esercizio 3 dopo il 2
  if($val["id_exercise"]==2){

    ?>
    <tr onclick="$('.es3_<?php echo $val["id_text"]?>').toggle()"><td colspan="4">Esercizo 3 <?php echo visualizza_titolo_testo($val["id_text"])?></td></tr>
    <?php 
    $qryp="select * from tab_pronouns where id_text=".$val["id_text"] ."  and lang='".$l."'";
    $rsp = connetti($qryp);
    while($valp=mysqli_fetch_array($rsp)){
      $qryp1 ="select * from tab_response_pronouns where id_pronouns=".$valp["id_pronouns"]." and id_student=".$_GET["id_student"]." and id_text=".$val["id_text"]."";
      $rsp1 =connetti($qryp1);
      while ($valp1=mysqli_fetch_array($rsp1)){
        ?>
        <tr class="es3_<?php echo  $val["id_text"]?>" style="display:none;"><td><?php echo $valp["frase"]." <br>Pronome: ".$valp["pronome"];?></td><td><?php echo $valp["r".$valp1["response"]];?></td><td><?php echo $valp1["lastUpdated"]?></td><td><?php echo $valp1["id_version"]?></td></tr>
       <?php       
    
      }
    
    }
  
  }
  

    
  

}

$qrytabtextexe ="select * from tab_text_exe where id_suitable =".$v["id_suitable"];
$rstte = connetti($qrytabtextexe);
while($valtte = mysqli_fetch_array($rstte)){
  ?>
 <tr onclick="$('.es4_<?php echo $valtte["id_text"]?>').toggle()"><td colspan="4">Esercizo 4 <?php echo $valtte["title"]?></td></tr>
  <?php
    $qrymap = "select * from tab_map_exe where id_text =".$valtte["id_text"];
    $rsmap =connetti($qrymap);
    while($valmap = mysqli_fetch_array($rsmap)){?>

<tr class="es4_<?php echo  $valtte["id_text"]?>" style="display:none;">
  <td><?php  echo $valmap["text"]." <br>Corrette: ";?>

<?php
        
          $qryd = "select * from tab_keyword_exe where id_map=".$valmap["id_map"]."";
          $rsd = connetti($qryd);
          while( $vald = mysqli_fetch_array($rsd)){
              echo $vald["keyword"]." ";
          }
?>
</td>

    
  <?php 
          $qryesercizio4 ="select * from tab_response_exe4 where id_student = ".$v["id_student"]." and id_map=".$valmap["id_map"]."";
          $rsexe4 = connetti($qryesercizio4);
          while($vale4 =mysqli_fetch_array($rsexe4)){
          echo "<td>".$vale4["response1"]." ".$vale4["response2"]."</td>";

          echo "<td>".$vale4["lastUpdated"]."</td><td>".$vale4["id_version"]."</td>";

        }?>
</tr>
        <?php
    }

}



$qrytabtextexe ="select * from tab_word where id_suitable =".$v["id_suitable"];
$rstte = connetti($qrytabtextexe);
while($valtte = mysqli_fetch_array($rstte)){
  $word = $valtte["word"];
  ?>
 <tr onclick="$('.es5_<?php echo $valtte["id_word"]?>').toggle()"><td colspan="4">Esercizo 5 <?php echo $valtte["word"]?></td></tr>
 <tr class="es5_<?php echo  $valtte["id_word"]?>" style="display:none;"><td>Corrette: 
 <?php
    $qrymap = "select * from tab_synset where id_word =".$valtte["id_word"]." and giusto=1";
    $rsmap =connetti($qrymap);
    while($valmap = mysqli_fetch_array($rsmap)){?>


  <?php  echo $valmap["word"];?>

<?php }
echo "<br> Sbagliate: ";
    $qrymap = "select * from tab_synset where id_word =".$valtte["id_word"]." and giusto=0";
    $rsmap =connetti($qrymap);
    while($valmap = mysqli_fetch_array($rsmap)){?>


  <?php  echo $valmap["word"]?>

<?php }
        
?>
</td>

    
  <?php 
          $qryesercizio4 ="select * from tab_response_synset where id_student = ".$v["id_student"]." and id_word=".$valtte["id_word"]."";
          $rsexe4 = connetti($qryesercizio4);
          while($vale4 =mysqli_fetch_array($rsexe4)){
          echo "<td>";
         
            $resp = unserialize($vale4["response"]);
           
            foreach ($resp as $x) {
              if ($x[0]==0){
                echo $word."<br>";
              }else{

             
              $qrysyn="select * from tab_synset where id_synset=".$x[0];
            
              $rssyn = connetti($qrysyn);
              while($valsyn=mysqli_fetch_array($rssyn)){
                echo $valsyn["word"]."<br>";
              }
            }
            
            }
           

          echo "</td>";

          echo "<td>".$vale4["lastUpdated"]."</td><td>".$vale4["id_version"]."</td>";

        }?>
</tr>
        <?php
    

}




?>


</tbody>
</table>

   <!-- /.col-md-6 -->
  
</div>

     
</div>

        <form method="POST" action="xls.php?id_student=<?php echo $v["id_student"]?>">
<input type="hidden" name="libro" value="<?php echo $_POST["libro"]?>">
<input type="hidden" name="esercizio" value="<?php echo $_POST["esercizio"]?>">
<input type="hidden" name="language" value="<?php echo $_POST["language"]?>">


<input type="submit" value="Esporta" name="pul_esporta">
</form>   
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="modal-img" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-l">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Avatar</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">

<?php

$handler = opendir('../../img/avatar/');

if (false !== $handler) {

    while ($file = readdir($handler)) {
      if ($file<>"." && $file <> ".." ){
        echo "<img src='../../img/avatar/".$file."' onclick=\"$('#img_av').attr('value','".$file."');$('#img').attr('src','../../img/avatar/".$file."');\" width='100'>";
      }
       
    }
}
closedir($handler);
?>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>

</div>

</div>

 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>

</body>
</html>
