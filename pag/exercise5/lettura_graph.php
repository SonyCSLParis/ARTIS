<?php 
header('Content-type: application/json');
include "../../admin/conn.php";
include "../../admin/funz.php";


$qry ="select * from tab_word where id_word=".$_GET["id"];
$rs = connetti($qry);
$x=0;
while($val=mysqli_fetch_array($rs)){
    $array[$x]["id"] =0;
    $array[$x]["word"] =$val["word"];
    $array[$x]["img"]=$val["img"];
    $array[$x]["definition"]=$val["definition"];
    $array[$x]["giusto"]=1;
    $qry1= "select * from tab_synset where id_word=".$_GET["id"]." and giusto=1";
    $rs1 = connetti($qry1);
    while($val1=mysqli_fetch_array($rs1)){
        $x=$x+1;
        $array[$x]["id"] =$val1["id_synset"];
        $array[$x]["word"]=$val1["word"];
        $array[$x]["img"]=$val1["img"];
        $array[$x]["definition"]=$val1["definition"];
        $array[$x]["giusto"]=1;
    }
    $qry1= "select * from tab_synset where id_word=".$_GET["id"]." and giusto=0";
    $rs1 = connetti($qry1);
    while($val1=mysqli_fetch_array($rs1)){
        $x=$x+1;
        $array[$x]["id"] =$val1["id_synset"];
        $array[$x]["word"]=$val1["word"];
        $array[$x]["img"]=$val1["img"];
        $array[$x]["definition"]=$val1["definition"];
        $array[$x]["giusto"]=0;
    }
}

echo json_encode($array);
?>