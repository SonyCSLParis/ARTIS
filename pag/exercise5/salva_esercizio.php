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
   $id_word = $data['id_word'];
   $language = $data['language'];
   $id_alunno = $data["iduser"];
   $risposta = $data["risposta"];
   // Perform further processing or respond to the request
   $tempo = $data["tempo"];
   // Perform further processing or respond to the request

$qryinstime  = "insert into tab_time set
type_exercise  = 5,
id_exercise  = ".$id_word.",
id_student = ". $id_alunno .",
id_version=0,
duration = ".$tempo."";
$rsinstime = connetti($qryinstime);


   if($language=="_en"){
    $language="en";
  }else{
      $language="it";
  }
  
  
    $qryv ="select * from tab_response_synset where id_word =".$id_word." and id_student=".$id_alunno." ";
    echo $qryv;
    $rsv = connetti($qryv);
    $count = mysqli_num_rows($rsv);
    $dasalvare=[];
    print_r($risposta);
   
    
          
   
    echo $count;
    if ($count >0){
    
        $qryinsert ="update tab_response_synset set
  
        response = '".serialize($risposta)."'
        
        
        where
        id_word = ".$id_word." and
        id_student = ".$id_alunno." and
        id_version=0
        ";
  
    }else{
  
      $qryinsert ="insert into  tab_response_synset set
     
       response = '".serialize($risposta)."',
  
      id_word = ".$id_word." ,
      id_student = ".$id_alunno.",
      id_version=0
      ";
      echo $qryinsert;
    
    }
   $rsins = connetti($qryinsert);
  
  



} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo "Invalid JSON data";
}

?>