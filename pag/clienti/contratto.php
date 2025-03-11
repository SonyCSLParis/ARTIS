<?php
// Start the session
session_start();
include "../admin/conn.php";
include "../admin/funz.php";
controlla_user();
if($_POST[pul] == "Nuovo"){
	if ($_FILES["file_inviato"]["name"] <> ""){
$nome_file_temporaneo = $_FILES["file_inviato"]["tmp_name"];
$nome_file_vero = $_FILES["file_inviato"]["name"];
$tipo_file = $_FILES["file_inviato"]["type"];

// Leggo il contenuto del file
$dati_file = file_get_contents($nome_file_temporaneo);

// Preparo il contenuto del file per la query sql
$dati_file = addslashes($dati_file);
$sqlp = ", ";
}
	$qryins = "insert into tab_dipendenti_documento set
	nomefile = '$nome_file_vero', 
    tipofile = '$tipo_file', 
    dati = '$dati_file',
	tipo =".$_POST[tipo].",
	iddipendente =".$_GET[id];
	$rs = connetti($qryins);
	$msg ="Inserimento avvenuto.";
}
if($_POST[pul] == "Elimina"){
	$qry ="select * from tab_dipendenti_documento where iddipendente=".$_GET[id];
	$rs =connetti($qry);
	while ($val = mysqli_fetch_array($rs)){
		if($_POST['chk'.$val[id]] == 1){
			$qrydel = "delete from tab_dipendenti_documento where id=".$val[id];
			$rsdel = connetti($qrydel);
			$msg ="Eliminazione avvenuta.";
		}
		
	}
	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Real Time Process Management - Roma</title>
<link href="../css/gestionale.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/jquery-ui/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="/jquery-ui/jquery-ui.js"></script>
  <script type="text/javascript" src="/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  
  

  <script>
  $(function() {
    
      $( "#datainizio" ).datepicker({
	  dateFormat: "dd-mm-yy",
	  showAnim: 'slideDown'
	});
	  $( "#datafine" ).datepicker({
	  dateFormat: "dd-mm-yy",
	  showAnim: 'slideDown'
	}); 
$("#frame1").fancybox({
				'width'				: '90%',
				'height'			: '90%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
	
  });
  </script>
</head>

<body>
<div align="center">



<div id="corpo">  
<p class="titolonero">Modifica Dipendenti - Documenti</p>


<div id="box">

<table width="500"  border="1" cellpadding="2" cellspacing="0"  class="txtbianco" >
<form name="upload" enctype="multipart/form-data" method="post" action="?id=<?php echo $_GET[id];?>" > 

<tr class="celletitolo"><td width="50%">Documento</td><td width="50%">Tipo</td></tr>
<tr class="celletitolo"><td><input type="file" name="file_inviato"></td>
<td>
<?php echo select_tipodocumento(0,"tipo")?>
</td>
<td><input type="submit" value="Nuovo" name="pul"></td></tr>
<?php $qry = "select * from tab_dipendenti_documento where iddipendente=".$_GET[id];
$rs= connetti($qry);
$color="";
while ($val = mysqli_fetch_array($rs)){
	
	?>


<tr class="celletitolo"><td><a href="/documento.php?id=<?php echo $val[id]?>" class="linkmenu">Visualizza</a></td>
<td><?php echo visualizza_tipodocumento($val[tipo]); ?></td><td><input type="checkbox" value="1" name="chk<?php echo $val[id]?>"></td></tr>



<?php }  ?>
<tr class="celletitolo"><td colspan="3" align="center"><input type="submit" value="Elimina" name="pul"> </td></tr>
<tr class="celletitolo"><td colspan="3" align="center"><?php echo $msg;?> </td></tr>

</form>
</table>
</div> 
</div> 



</div>
</body>
</html>