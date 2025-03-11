<?php 
header('Content-type: application/json');
include "../../admin/conn.php";
include "../../admin/funz.php";


$qry ="select * from tab_difficult_words where id_df=".$_GET["id"];
$rs = connetti($qry);
$x=0;
while($val=mysqli_fetch_array($rs)){
    $array[$x]["id"] =0;
    $array[$x]["word"] =$val["word"];
    $array[$x]["img"]=$val["img"];
    $array[$x]["definition"]=$val["definition"];
    $array[$x]["giusto"]=1;
    $qry1= "select * from tab_synset_df where id_df=".$_GET["id"]." ";
    $rs1 = connetti($qry1);
    while($val1=mysqli_fetch_array($rs1)){
        $x=$x+1;
        $array[$x]["id"] =$val1["id_synset"];
        $array[$x]["word"]=$val1["word"];
        $array[$x]["img"]=$val1["img"];
        $array[$x]["definition"]=$val1["definition"];
       
    }
    
}

echo json_encode($array);
?>