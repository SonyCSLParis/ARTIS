
<?php
// Start the session
session_start();
?>
<?php include "admin/conn.php";
include "admin/funz.php";



$ip= IndirizzoIpReale();

$pass = "ko";

	
	$qry = "select * from tab_user where mail like '".$_POST["email"]."' and password like SHA1('".$_POST["password"]."') ";


  $rs = connetti($qry);

	while($val= mysqli_fetch_array($rs)){
		$pass = "ok";
		$codiceid = sha1("S4by5".$val["mail"]."B34n");
		$nome = $val["name"];
		$livello = $val["level"];
		$data = $val["datacreazione"];
		$id =$val["id_user"];
		$id_student= $val["id_student"];
	}

	//password ok
	if($pass =="ok"){
    if($livello==3){
      $_SESSION['id_alunno'] = $id_student;
      $qry="select * from tab_student where id_student=".$id_student;
      $rs= connetti($qry);
      while($val=mysqli_fetch_array($rs)){
        $_SESSION['img'] = $val["avatar"];
        $_SESSION['id_suitable'] = carica_suitable($id_student);
        if ($val["id_grafica"]==0){
          $_SESSION["grafica"] ="";
    
        }
        if ($val["id_grafica"]==1){
          $_SESSION["grafica"] ="spazio";
    
        }
        if ($val["id_grafica"]==2){
          $_SESSION["grafica"] ="bosco";
          
        }
    
      }

    }
   
			$_SESSION['codice'] = $codiceid;
			$_SESSION['nome'] = $nome;
			$_SESSION['livello'] = $livello;
			$_SESSION['id'] = $id;
			
			?>
      <script >

window.location.href = "<?php echo $base_dir;?>/page.php";
</script>
      
      <?php
	
	}
	
	//password ko

		if($pass =="ko" ){

   
			$_SESSION['codice'] = "";
			$_SESSION['nome'] = "";
			$_SESSION['livello'] = "";
			$_SESSION['id'] = "";
      $_SESSION['id_alunno']="";
      $_SESSION['id_text']="";
      if($_GET["chk"]==1){
        $msg = "Nome utente o Password errate";	
     
			
			$qryban = "insert into tab_ban set ip = '".$ip."'";
			$rsban = connetti($qryban); 
    }
		}
	
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <?php include "head.php";?>
</head>
<body class="hold-transition login-page">

<div class="row">
<div class="col-sm-1">
  </div>

<div class="col-sm-10">

<br>
<div align="center">
<img src="img/logoartis.png" width="250"><br><br>
<button class="btn btn-primary " onclick="window.location.replace('login.php');">Effettua il Login alla piattaforma</button>
  </div><br><br>
<div class="row">
<div class="col-sm-12">
<div class="card card-primary card-outline">
              <div class="card-header">
                <h4 class="card-title m-0"><b>Il progetto</b></h4>
              </div>
              <div class="card-body">
             

                <p class="card-text">La comprensione del testo costituisce un compito cognitivo complesso che spesso risulta difficile e frustrante per molti bambini affetti da Disturbo dell’Apprendimento. Quest'abilità, essenziale in molteplici contesti della vita quotidiana, rappresenta inoltre il fondamento del nostro sistema educativo. Nel team di linguaggio di Sony CSL, ci impegniamo a superare questa sfida attraverso la progettazione di tecnologie linguistiche accessibili e inclusive, mirate a supportare terapie e pratiche educative ibride. Presso il CRC – Centro Ricerca e Cura, un centro specializzato nella riabilitazione dei Disturbi del Neurosviluppo, i bambini intraprendono percorsi volti ad accrescere le loro competenze linguistiche e comunicative, apprendendo strategie utili a compensare le difficoltà nell'apprendimento. In linea con questo obiettivo, abbiamo collaborato per progettare e valutare insieme l'efficacia di un'interfaccia di comprensione della lettura, alimentata dall'intelligenza artificiale. Tale interfaccia mira a rendere l'intero processo di lettura e comprensione dei testi più personalizzabile, multimodale e autenticamente inclusivo.</p>
               
              </div>
            </div>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h4 class="card-title m-0"><b>L'interfaccia</b></h4>
              </div>
              <div class="card-body">
             

                <p class="card-text">Questa interfaccia rappresenta la prima dimostrazione di un sistema su cui condurremo una serie di studi con gli utenti presso il CRC, al fine di valutare quanto efficacemente possa migliorare la comprensione del testo nei bambini affetti da disturbi della lettura. </p>
               
              </div>
            </div>
            

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h4 class="card-title m-0"><b>CRC</b></h4>
              </div>
              <div class="card-body">
              <div align="center" style="margin:20px;">         
<img src="img/CRC_logotype-red.png" width="100px"></div>
                <p class="card-text">Il CRC - Centro Ricerca e Cura focalizza le sue risorse nel campo dei disturbi del neurosviluppo, dedicandosi alla diagnosi, agli interventi clinici, alla ricerca e alla formazione per specialisti. Il Centro è attivamente coinvolto in un costante programma di ricerca.</p>
               
              </div>
            </div>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h4 class="card-title m-0"><b>Sony Computer Science Laboratories - Paris</b></h4>
              </div>
              <div class="card-body">
              <div align="center" style="margin:20px;">
              <img src="img/SonyCSL_logo_2line_color_textlogo_black_Large.png" width="100px"></div>
                <p class="card-text">Sony CSL - Paris è un piccolo gruppo di ricerca animato dalle persone e dedicato all'esplorazione di tecnologie che favoriscono società creative, inclusive e sostenibili. Combinando idee innovative con un approccio scientifico, affrontiamo sfide multidisciplinari per realizzare soluzioni d'impatto e centrate sulle persone, per il benessere dell'umanità e del pianeta.</p>
                <p class="card-text">Sony CSL – Paris is a small, people-driven research group dedicated to exploring technologies that foster creative, inclusive, and sustainable societies. Combining innovative ideas with a scientific approach, we tackle multidisciplinary challenges to drive impactful, people-centered solutions for the well-being of both humanity and the planet.</p>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h4 class="card-title m-0"><b>ARASAAC</b></h4>
              </div>
              <div class="card-body">

                <p class="card-text"> I simboli pittografici utilizzati in ARTIS sono di proprietà del Governo dell'Aragona e sono stati creati da Sergio Palao per ARASAAC (<a href="http://www.arasaac.org" target="_new" >http://www.arasaac.org</a>), che li distribuisce sotto la licenza Creative Commons BY-NC-SA .<BR> 
                
                
                The pictographic symbols used in ARTIS are the property of the Government of Aragón and have been created by Sergio Palao for ARASAAC (<a href="http://www.arasaac.org" target="_new" >http://www.arasaac.org</a>), that distributes them under Creative Commons License BY-NC-SA.</p>
               </p>
               
              </div>
            </div>
</div>

  </div>

  </div>

  <div class="col-sm-1">
  </div>
 </div>

<!-- /.login-box -->

<?php include "scripts.php";?>
</body>
</html>
