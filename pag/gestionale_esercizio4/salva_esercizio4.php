<?php
include "../../admin/conn.php";
include "../../admin/funz.php";
// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');
// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData,true);
// Check if decoding was successful

if ($data !== null) {
   // Access the data and perform operations
   $id_text = $data['idtext'];
   $language = $data['language'];
   $id_alunno = $data["iduser"];
   $risposta = $data["risposta"];
   // Perform further processing or respond to the request
   $tempo = $data["tempo"];
   // Perform further processing or respond to the request


   $qryinstime  = "insert into tab_time set
   type_exercise  = 4,
   id_exercise  = ".$id_text.",
   id_student = ". $id_alunno .",
   id_version=0,
   duration = ".$tempo."";
   $rsinstime = connetti($qryinstime);


   if($language=="_en"){
    $language="en";
  }else{
      $language="it";
  }
  $qry ="select * from tab_map_exe where id_text =".$id_text." ";
  echo $qry;
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){
  
    $qryv ="select * from tab_response_exe4 where id_map =".$val["id_map"]." and id_student=".$id_alunno." ";
    echo $qryv;
    $rsv = connetti($qryv);
    $count = mysqli_num_rows($rsv);
    $dasalvare=[];
    print_r($risposta[$val["id_map"]]);
   
            

    $dasalvare[0] = $risposta[$val["id_map"]][0];
    $dasalvare[1] = $risposta[$val["id_map"]][1];
          
   
    echo $count;
    if ($count >0){
    
        $qryinsert ="update tab_response_exe4 set
        response1 = '".addslashes($dasalvare[0])."',
        response2 = '".addslashes($dasalvare[1])."'
        where
        id_map = ".$val["id_map"]." and
        id_student = ".$id_alunno." and
        id_version=0
        ";
  
    }else{
  
      $qryinsert ="insert into tab_response_exe4 set
     
       response1 = '".addslashes($dasalvare[0])."',
      response2 = '".addslashes($dasalvare[1])."',
      id_map = ".$val["id_map"]." ,
      id_student = ".$id_alunno.",
      id_version=0
      ";
      echo $qryinsert;
    
    }
   $rsins = connetti($qryinsert);
  }
  



} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo "Invalid JSON data";
}




//CAlcola risultati
/*
$qrycheck ="select * from tab_question where  id_text =".$_SESSION["id_text"]." and id_exercise= 1 and lang='".$language."'";
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

if($totale == $risposte){
  $chkW=1;
}else{
  $chkW=2;
}
 


}*/?>