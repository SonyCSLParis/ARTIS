<?php include "../../header.php";?>
<?php

if($_POST[pul] == "Aggiorna"){
	
	$qry="select * from tab_operazioni where sospeso=0 and scadenza=1";
	$rs = connetti($qry);
	while ($val =mysqli_fetch_array($rs)){
		$qrychk = "select * from tab_scadenza_operazioni where IDoperazione =".$val[ID]." and IDcliente =".$_GET[idcliente];
		$rschk = connetti($qrychk);
		if (mysqli_num_rows($rschk) > 0){
			
			$qryup = "update tab_scadenza_operazioni set scadenza =".$_POST['scadenza'.$val[ID]]." , giorno =".$_POST['giorno'.$val[ID]]." , mese =".$_POST['mese'.$val[ID]]." where  IDoperazione =".$val[ID]." and IDcliente = ".$_GET[idcliente]; 
			
			
			
		}else{
			
		$qryup = "insert tab_scadenza_operazioni set scadenza =".$_POST['scadenza'.$val[ID]]." , giorno =".$_POST['giorno'.$val[ID]]." , mese =".$_POST['mese'.$val[ID]].", IDoperazione =".$val[ID]." , IDcliente = ".$_GET[idcliente]; 
		
		
			
		}
		//echo $qryup;
		$rsup = connetti($qryup);
		
		
	}
	
	
}



?>

    <script>
	$(document).ready(function(){
		$(".menu_gestionale").removeClass("active");
        $("#clienti").addClass("active");
		$("#clienti_modifica").addClass("active");
    });
	
	</script>
  
 
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Cliente: <?php echo visualizza_cliente($_GET[idcliente]);?>
            
          </h1>
         <a href="modifica.php"  ><i class="fa fa-undo" style="font-size:36px"></i></a>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          
          
          
          
          <div class="box-body">
          <?php if ($msg <> ""){?>
<div class="callout callout-info">
                    <h4>Info</h4>
                    <p><?php echo $msg?></p>
                  </div>
                  <?php } ?>
                  
                  
                  
                  
          
    <form method="post" action="?idcliente=<?php  echo $_GET[idcliente]?>">              
                <table id="example1" class="table table-bordered table-hover ">
                    <thead>
                    
                    <tr><th>Operazioni</th><th  align="center">Cadenza</th><th  align="center">GG - MM </th></tr>

                      
                    </thead>
                    <tbody>  
                  <?php 

$qry1 = "select * from tab_operazioni where sospeso=0 and scadenza=1 order by nome";
$rs1= connetti($qry1);
while($val1 = mysqli_fetch_array($rs1)){
			$qry2="select * from tab_scadenza_operazioni where IDoperazione=".$val1[ID]." and IDcliente=".$_GET[idcliente];
			$rs2= connetti($qry2);
			$val2 = mysqli_fetch_array($rs2);
			if(mysqli_num_rows($rs2)>0){
				$scadenza = $val2[scadenza];
				$giorno =$val2[giorno];
				$mese = $val2[mese];
				
				
			}else{
				$scadenza = 0;
				$giorno =0;
				$mese = 0;
			}
	
	
						
						?>
 
<tr  ><td><?php echo $val1[nome]?></td>
<td align="center">
<select name="scadenza<?php echo $val1[ID]?>">
<option value="0" <?php if($scadenza==0){ echo " selected";}?>></option>
<option value="1" <?php if($scadenza==1){ echo " selected";}?>>Mensile</option>
<option value="2" <?php if($scadenza==2){ echo " selected";}?>>Trimestrale</option>
<option value="3" <?php if($scadenza==3){ echo " selected";}?>>Semestrale</option>
<option value="4" <?php if($scadenza==4){ echo " selected";}?>>Annuale</option>
	</select>
</td>
<td align="center">	<select name="mese<?php echo $val1[ID]?>">
<option value="0" <?php if($giorno==0){ echo " selected";}?>></option>
<?php for($x=1;$x<32;$x++){
							?>
							
<option value="<?php echo $x?>" <?php if($mese==$x){ echo " selected";}?>><?php echo $x?></option>
					<?php	}
?>
	</select>
	-
<select name="giorno<?php echo $val1[ID]?>">
<option value="0" <?php if($giorno==0){ echo " selected";}?>></option>
<?php for($x=1;$x<13;$x++){
							?>
							
<option value="<?php echo $x?>" <?php if($giorno==$x){ echo " selected";}?>><?php echo $x?></option>
					<?php	}
?>
	</select> 

	
	
	

</td>

</tr>

<?php 

}  ?>

<tr>
<td colspan="5" ><input type="submit" name="pul" value="Aggiorna"></td></tr>




</table>
</td></tr></tbody>
</table>
</form>

                </div>







</div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  
  <script>
	$(function() {
	 $( "#data" ).datepicker({
	  format: 'dd-mm-yy',
	  showAnim: 'slideDown'
	});
	 $('.boxcalcolo').keyup(function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	});
	</script>