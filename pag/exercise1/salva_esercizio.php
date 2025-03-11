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
   $tempo = $data["tempo"];
   // Perform further processing or respond to the request

$qryinstime  = "insert into tab_time set
type_exercise  = 1,
id_exercise  = 1,
id_student = ". $id_alunno .",
id_version=0,
duration = ".$tempo."";
$rsinstime = connetti($qryinstime);

  
  $qry ="select * from tab_question where id_text =".$id_text." and id_exercise=1 and lang='".$language."' order by tab_question.order";
  $rs = connetti($qry);
  while($val = mysqli_fetch_array($rs)){
  
    $qryv ="select * from tab_result where id_student=".$id_alunno." and id_text =".$id_text." and id_exercise=1 and id_question =".$val["id_question"]." and id_version=0";
    $rsv = connetti($qryv);
    $count = mysqli_num_rows($rsv);
    foreach ($risposta as &$value) {
        if ($value["id"]==$val["id_question"]){

            $dasalvare = $value["risposta"];
           
        }
    }
    echo $count;
    if ($count >0){
    
            $qryinsert ="update tab_result set
     
            result = '".addslashes($dasalvare)."',
            id_response=0,
            multi=0
            where
            id_exercise = 1 and
            id_student = ".$id_alunno." and
            id_text =".$id_text." and
            id_question =".$val["id_question"]." and
            id_version=0
            ";
  
    }else{
  
      $qryinsert ="insert into tab_result set
     
      result = '".addslashes($dasalvare)."',
      id_response=0,
      multi=0 ,
      id_exercise = 1 ,
      id_student = ".$id_alunno.",
      id_text =".$id_text." ,
      id_question =".$val["id_question"]." ,
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