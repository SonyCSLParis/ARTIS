<?php




//   funzioni login //
function controlla_ban($ip){
	$qry ="select * from tab_ban where ip like '".$ip."'";
	$rs= connetti($qry);
	//echo "ss".mysqli_num_rows($rs);
	if (mysqli_num_rows($rs) > 2){
		return false;
	}else{
		return true;
	}
}

function controllo_accesso($id_student){

	$qry ="select * from tab_user where id_student=".$id_student;
	$rs = connetti($qry);
	while ($val=mysqli_fetch_array($rs)){
		$id_user = $val["id_user"];
		return "modifica1.php?id=".$id_user;
	}
	return "nuovo.php?id_student=".$id_student;

}
function IndirizzoIpReale()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function controlla_user(){
	$id = $_SESSION['codice'];
	
	$qry = "select * from tab_user";
	$rs = connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
		$codice = sha1("S4by5".$val['mail']."B34n");
		if ($codice == $id){
			$chk = "ok";
			break;
		}else{
			$chk = "ko";
		}
	}
	if ($chk <> "ok"){
		header("location: /artis/index.php");
	}
}

function invio_mail($posta,$subject,$testo){

	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
  	try {
	// SMTP server
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true;  
	  	$mail->SMTPSecure = "tls";
	  	$mail->Host = "smtp.gmail.com";
	  	$mail->Port = 587;
		$mail->SMTPDebug = 1;               // set the SMTP port for the GMAIL server
		$mail->Username   = "softwareartis@gmail.com"; // SMTP account username
		$mail->Password   = "zuujlpsojbzewkxj";        // SMTP account password
		$mail->SetFrom('softwareartis@gmail.com', 'Sistema di registrazione ');
		$mail->AddAddress($posta,$posta);
		$mail->AddBCC("softwareartis@gmail.com","softwareartis@gmail.com");
		$mail->Subject = $subject;
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$cc="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<title>Artis</title>
		</head>
		<body >".$testo."</body>
		</html>";
		$mail->IsHTML(true);
		$mail->MsgHTML ($cc);
  
		$mail->Send();
		$err = "Message Sent OK</p>\n";
		
	  } catch (phpmailerException $e) {
		return 0;
	  $err =  $e->errorMessage(); //Pretty error messages from PHPMailer
	  } catch (Exception $e) {
		return 0;
	  $err = $e->getMessage(); //Boring error messages from anything else!
	  } 
	$mail->SmtpClose();
	unset($mail);
	
  return 1;
}

function controlla_attivo($campo,$lang,$id_text){

	$qry="select * from tab_confirm where id_text =".$id_text." and lang='".$lang."'";
	$rs = connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
		if ($campo==1 && $val["leggi"]==1){
			return "<div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
		}
		if ($campo==2 && $val["visualizza_testo"]==1){
			return "<div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
		}
		if ($campo==3 && $val["visualizza_parole"]==1){
			return "<div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
		}
		if ($campo==4 && $val["esercizi1"]==1){
			return "<div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
		}
		if ($campo==5 && $val["esercizi2"]==1){
			return "<div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
		}
		if ($campo==6 && $val["esercizi3"]==1){
			return "<div  class='circlegreen' title='Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
		}

	}

return "<div  class='circlered' title='Non Attivo'  style='float:left;margin-left:10px;margin-right:10px;'></div>";
}


function carica_suitable($id_student){
	$qry="select * from tab_classe where id_student=".$id_student;
	$rs = connetti($qry);
	$txt=[];
	while($val = mysqli_fetch_array($rs)){
		
			array_push($txt,$val["id_suitable"]);
		
		
	}
	return $txt;
  }






function visualizza_suitable($id){
	$qry="select * from tab_classe where id_student=".$id;
	$rs = connetti($qry);
	$txt="";
	while($val = mysqli_fetch_array($rs)){
		$qry1 ="select * from tab_suitable where id_suitable=".$val["id_suitable"];
		$rs1 = connetti($qry1);
		while($val1 = mysqli_fetch_array($rs1)){
			$txt = $txt . $val1["suitable"]."<br>";
		
		}
	}
	return $txt;
  }

  function visualizza_classe($id){
	
		$qry1 ="select * from tab_suitable where id_suitable=".$id;
		$rs1 = connetti($qry1);
		while($val1 = mysqli_fetch_array($rs1)){
			$txt =  $val1["suitable"];
		
		}
	
	return $txt;
  }
function id_user(){
	$id = $_SESSION['codice'];
	$qry = "select * from tab_user";
	$rs = connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
		$codice = sha1("S4by5".$val[nome]."B34n");
		if ($codice == $id){
			$chk = $val[id];
			break;
		}else{
			$chk = "";
		}
	}
	return $chk;
}
function visualizza_user(){
	$id = $_SESSION['codice'];
	$qry = "select * from tab_user";
	$rs = connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
		$codice = sha1("S4by5".$val[nome]."B34n");
		if ($codice == $id){
			$chk = $val[nome];
			break;
		}else{
			$chk = "";
		}
	}
	return $chk;
}
function visulizza_livello($id){
	if($id==1){
		$liv = "Amministratore";
	}
	if($id==2){
		$liv = "Logopedista";
	}
	if($id==3){
		$liv = "Studente";
	}
	return $liv;

}
function visualizza_studente($id){

	$qry = "select * from tab_student where id_student =".$id;
	$rs = connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
	
	
			$name = $val["name"];
	
	}
	return $name;
}
function visualizza_user_id($id){

	$qry = "select * from tab_user where id_user=".$id;
	$rs = connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
		
			$res = $val["name"]." ".$val["surname"];
		
	}
	return $res;
}


function visualizza_titolo_testo($id_text){
	$qry="select * from tab_text where id_text=".$id_text;
	$rs = connetti($qry);
	while ($val=mysqli_fetch_array($rs)){
		$titolo = $val["title".$_SESSION["lang"]];

	}
	return $titolo;
}

// funzioni GENERALI 

function zerozero($numero){
	
	$nume = explode(".",$numero);
	
	if (strlen($nume[1]) ==2 ){
		return $nume[0] .".". $nume[1]."";
	}
	if (strlen($nume[1]) ==1 ){
		return $nume[0] .".". $nume[1]."0";
	}
	if (strlen($nume[1]) ==0 ){
		return $nume[0] .".00";
	}
}

function is_simple_password($password){
		
			if (strlen($password) >= 8   ){
				$chkpp = 1 ;
			}else{
				$chkpp = 0 ;
			}
			$arr = array("@", ";", ".", ",", "-", "_");	
				
				if (preg_match("^[@#-_*]^",$password) || $chkpp1==1){
					$chkpp1 = 1 ;
				}else{
					$chkpp1 = 0 ;
				}
			if (preg_match("^[0-9]^",$password) || $chkpp2==1){
					$chkpp2 = 1 ;
				}else{
					$chkpp2 = 0 ;
				}
	
	
			if ($chkpp ==1 && $chkpp1 == 1 && $chkpp2 == 1){
				return true;
			}else{
				return false;
			}
			
	}
function convertiDataPerVisualizzareADMY($dataEur){
	if($dataEur<>""){
  list ($y, $m, $d) = explode ("-", $dataEur);
  return "$d-$m-$y";
	}
}
function convertiDataPerVisualizzareADMY2($dataEur){
	if($dataEur<>""){
  list ($y, $m, $d) = explode ("-", $dataEur);
  return "$d/$m/$y";
	}
}

function convertiDataPerDBAYDM($dataEur){
  list ($d, $m, $y) = explode ("/", $dataEur);
  return "$y-$m-$d";
}

function convertiDataPerDBAYDM2($dataEur){
if($dataEur<>""){	
  list ($d, $m, $y) = explode ("-", $dataEur);
  return "$y-$m-$d";
}else{
	return "0000-00-00";
}
}
function isemail($email) {
    return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
}
function dateadd($data,$giorni){
$date = $data;
$newdate = strtotime ( '+'.$giorni.' day' , strtotime ( $date ) ) ; // facciamo l'operazione
$newdate = date ( 'd-m-Y' , $newdate ); //trasformiamo la data nel formato accettato dal db YYYY-MM-DD

return $newdate;
}

function datedif($data,$giorni){
$date = $data;
$newdate = strtotime ( '-'.$giorni.' day' , strtotime ( $date ) ) ; // facciamo l'operazione
$newdate = date ( 'd-m-Y' , $newdate ); //trasformiamo la data nel formato accettato dal db YYYY-MM-DD

return $newdate;
}
function password_scaduta($dt1,$dt2){
	$ok =0;
    $y1 = substr($dt1,0,4);
    $m1 = substr($dt1,5,2);
    $d1 = substr($dt1,8,2);
    $h1 = 0;
    $i1 = 0;
    $s1 = 0;   

    $y2 = substr($dt2,0,4);
    $m2 = substr($dt2,5,2);
    $d2 = substr($dt2,8,2);
    $h2 = 0;
    $i2 = 0;
    $s2 = 0;   

    $r1=date('U',mktime($h1,$i1,$s1,$m1,$d1,$y1));
    $r2=date('U',mktime($h2,$i2,$s2,$m2,$d2,$y2));
    $ris = ($r2-$r1);
	//echo $ris;
	if ($ris > 7889231  ){
		$ok = 1;
	}
	if ($ok == 1){
		return true;
	}else{
		return false;
	}
	

}

?>