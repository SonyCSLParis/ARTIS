<?php
   $filename="risultati.xls";
   header ("Content-Type: application/vnd.ms-excel; charset=UTF-8" );
   header ("Content-Disposition: inline; filename=$filename");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
?>
<?php
// Start the session
session_start();
?>
<?php include "../../admin/conn.php";
include "../../admin/funz.php";
controlla_user();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it><head>
<title>Titolo</title></head>
<body>
<table >
<thead>
<tr>
<th>Esercizio</th>
<th>Libro</th>
<th>Domanda</th>
<th>Risposta</th>
<th>Data</th>
<th>Version</th>
</tr>
</thead>
<tbody>
<?php 
$l="it";

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
$q="select * from tab_student where  id_student=".$_GET["id_student"];
$r = connetti($q);
$v = mysqli_fetch_array($r);

$qry="SELECT id_exercise,id_text FROM artisdb.tab_result where id_student=".$_GET["id_student"].$filtrolibri.$filtroesercizi." group by id_exercise,id_text order by id_text";
$rs = connetti($qry);
while($val=mysqli_fetch_array($rs)){
  ?>
 
  <?php
  if ($val["id_exercise"]==1 || $val["id_exercise"]==2 ){
      $qry1="select * from tab_question where id_exercise = ".$val["id_exercise"]." and id_text =".$val["id_text"]." and lang='".$l."'";
      $rs1=connetti($qry1);
      while($val1=mysqli_fetch_array($rs1)){
          $qry2="Select * from tab_result where id_question =".$val1["id_question"]." order by id_version";
          $rs2=connetti($qry2);
          while($val2=mysqli_fetch_array($rs2)){
              ?>
              <tr  >
              <td >Esercizio <?php echo $val["id_exercise"]?> </td>
              <td><?php echo visualizza_titolo_testo($val["id_text"])?></td>
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
    <tr ></tr>
    <?php 
    $qryp="select * from tab_pronouns where id_text=".$val["id_text"] ."  and lang='".$l."'";
    $rsp = connetti($qryp);
    while($valp=mysqli_fetch_array($rsp)){
      $qryp1 ="select * from tab_response_pronouns where id_pronouns=".$valp["id_pronouns"]." and id_student=".$_GET["id_student"]." and id_text=".$val["id_text"]."";
      $rsp1 =connetti($qryp1);
      while ($valp1=mysqli_fetch_array($rsp1)){
        ?>
        <tr >
        <td >Esercizo 3 </td>
        <td><?php echo visualizza_titolo_testo($val["id_text"])?></td>
            <td><?php echo $valp["frase"]." <br>Pronome: ".$valp["pronome"];?></td>
            <td><?php echo $valp["r".$valp1["response"]];?></td>
            <td><?php echo $valp1["lastUpdated"]?></td>
            <td><?php echo $valp1["id_version"]?></td></tr>
       <?php       
    
      }
    
    }
  
  }
  

    
  

}

?>

<?php

$qrytabtextexe ="select * from tab_text_exe where id_suitable =".$v["id_suitable"];
$rstte = connetti($qrytabtextexe);
while($valtte = mysqli_fetch_array($rstte)){
  ?>
 
  <?php
    $qrymap = "select * from tab_map_exe where id_text =".$valtte["id_text"];
    $rsmap =connetti($qrymap);
    while($valmap = mysqli_fetch_array($rsmap)){?>
<tr ><td >Esercizo 4</td><td> <?php echo $valtte["title"]?></td>

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
 <tr ><td >Esercizo 5 </td><td><?php echo $valtte["word"]?></td>
 <td>Corrette: 
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

</body></html>