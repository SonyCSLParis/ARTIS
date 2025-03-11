<?php include "../../header.php";?>
<?php
if($_POST[pul] == "Salva"){
	if($_POST[codiceazienda]==""){
		$codiceazienda = 0;
		
	}else{
		$codiceazienda=$_POST[codiceazienda];
	}
		$qryins = "update tab_cliente set 
      attivo =".$_POST[attivo].",  
			Azienda = ".$codiceazienda.",
			RagioneSociale = '".addslashes($_POST[ragionesociale])."',
			
			Comune = '".addslashes($_POST[comune])."',
			
			Provincia = '".addslashes($_POST[provincia])."',
			
			Indirizzo = '".addslashes($_POST[indirizzo])."',
			
			CAP = '$_POST[cap]',
			CodiceFiscale = '$_POST[codicefiscale]',
			PartitaIva = '$_POST[partitaiva]',
			note = '".addslashes($_POST[note])."',
			listino = $_POST[listino],
			iban = $_POST[iban],
      categoria = $_POST[categoria],
      codice = '".$_POST[codice]."',
      pec = '".$_POST[pec]."', 
			responsabile = $_POST[responsabile],
			Mail = '$_POST[mail]'
			,fatturazione=$_POST[fatturazione]
			where ID=".$_GET[id];
		
		
		$rsins = connetti($qryins);
		$msg = "Cliente modificato";
	
	
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
            Modifica cliente
            
          </h1>
          <a href="modifica.php"  ><i class="fa fa-undo" style="font-size:36px"></i></a>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          
          
          <?php $qry = "select * from tab_cliente where ID=".$_GET[id];
$rs = connetti($qry);
while($val= mysqli_fetch_array($rs)){
	?>
          
          <div class="box-body">
          <?php if ($msg <> ""){?>
<div class="callout callout-info">
                    <h4>Info</h4>
                    <p><?php echo $msg?></p>
                  </div>
                  <?php } ?>
                 <form class="form-horizontal" method="post" action="modifica1.php?id=<?php echo $_GET[id]?>">
                  <div class="box-body">
                  <div class="form-group">
                      <label for="attivo" class="col-sm-2 control-label">Attivo</label>
                      <div class="col-xs-5">
                      <select name="attivo">
	<option value="0" <?php if($val[attivo]==0){echo " selected";}?>>NO</option>
	<option value="1" <?php if($val[attivo]==1){echo " selected";}?>>SI</option>
	
	
	</select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="codiceazienda" class="col-sm-2 control-label">Codice Azienda</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="codiceazienda" name="codiceazienda"  value="<?php echo $val[Azienda]?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="ragionesociale" class="col-sm-2 control-label">Ragione sociale</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="ragionesociale" name="ragionesociale"  value="<?php echo $val[RagioneSociale]?>">
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="comune" class="col-sm-2 control-label">Comune</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="comune" name="comune"  value="<?php echo $val[Comune]?>">
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <label for="provincia" class="col-sm-2 control-label">Provincia</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="provincia" name="provincia"   value="<?php echo $val[Provincia]?>">
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="indirizzo" class="col-sm-2 control-label">Indirizzo</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="indirizzo" name="indirizzo"  value="<?php echo $val[Indirizzo]?>">
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="cap" class="col-sm-2 control-label">CAP</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="cap" name="cap"  value="<?php echo $val[CAP]?>">
                      </div>
                    </div> 
                     <div class="form-group">
                      <label for="codicefiscale" class="col-sm-2 control-label">Codice Fiscale</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="codicefiscale" name="codicefiscale"  value="<?php echo $val[CodiceFiscale]?>">
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="partitaiva" class="col-sm-2 control-label">Partia IVA</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="partitaiva" name="partitaiva"  value="<?php echo $val[PartitaIva]?>">
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="mail" class="col-sm-2 control-label">Mail</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="mail" name="mail"  value="<?php echo $val[Mail]?>">
                      </div>
                    </div> 
                    
                      <div class="form-group">
                      <label for="listino" class="col-sm-2 control-label">Listino</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="listino">
                      <option value="0">Nessun listino impostato</option>
                      <?php $qryl = "select * from tab_listino";
					  $rsl = connetti($qryl);
					  while ($vall =mysqli_fetch_array($rsl)){
						echo "<option value='".$vall[ID]."' ";
						if ($vall[ID] == $val[listino]){
							echo "selected";
							
						}
						echo " >".$vall[nome]."</option>";
					  }
					  
					  ?>
					  
					  
                      </select>
                      </div>
                    </div>
                    
                    
                     <div class="form-group">
                      <label for="iban" class="col-sm-2 control-label">IBAN</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="iban">
                      <option value="0">Nessun iban impostato</option>
                      <?php $qryl = "select * from tab_iban";
					  $rsl = connetti($qryl);
					  while ($vall =mysqli_fetch_array($rsl)){
						echo "<option value='".$vall[ID]."' ";
						if ($vall[ID] == $val[iban]){
							echo "selected";
							
						}
						echo " >".$vall[nome]."</option>";
					  }
					  
					  ?>
					  
					  
                      </select>
                      </div>
                    </div>
                   
                   
                    <div class="form-group">
                      <label for="categoria" class="col-sm-2 control-label">Categoria</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="categoria">
                      <option value="0">Nessuna categoria impostata</option>
                      <?php $qryl = "select * from tab_categoria";
					  $rsl = connetti($qryl);
					  while ($vall =mysqli_fetch_array($rsl)){
						echo "<option value='".$vall[ID]."' ";
						if ($vall[ID] == $val[categoria]){
							echo "selected";
							
						}
						echo " >".$vall[nome]."</option>";
					  }
					  
					  ?>
					  
					  
                      </select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="responsabile" class="col-sm-2 control-label">Responsabile</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="responsabile">
                      <option value="0">Nessuna responsabile impostato</option>
                      <?php $qryl7 = "select * from tab_user";
					  $rsl7 = connetti($qryl7);
					  while ($vall7 =mysqli_fetch_array($rsl7)){
						echo "<option value='".$vall7[id]."' ";
						if ($vall7[id] == $val[responsabile]){
							echo "selected";
							
						}
						echo " >".$vall7[nomecognome]."</option>";
					  }
					  
					  ?>
					  
					  
                      </select>
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="fatturazione" class="col-sm-2 control-label">Fatturazione</label>
                       <div class="col-xs-5">
                      <select class="form-control" name="fatturazione">
                      <option value="0" <?php if($val['fatturazione'] == 0){ echo " selected";}?>></option>
                      <option value="1" <?php if($val['fatturazione'] == 1){ echo " selected";}?>>Mensile</option>
					  <option value="3" <?php if($val['fatturazione'] == 3){ echo " selected";}?>>Trimestrale</option>
                      </select>
                      </div>
                    </div>
                     <div class="form-group">
                      <label for="note" class="col-sm-2 control-label">Note</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="note" name="note" value="<?php echo $val[note]?>" >
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="codice" class="col-sm-2 control-label">Codice sdi</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="codice" name="codice" value="<?php echo $val[codice]?>" >
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="pec" class="col-sm-2 control-label">PEC</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="pec" name="pec" value="<?php echo $val[pec]?>" >
                      </div>
                    </div> 
                  </div><!-- /.box-body -->
                  <div class="box-footer col-xs-7">
                    
                    <button type="submit" class="btn btn-primary btn-block" value="Salva" name="pul">Salva</button>
                  </div><!-- /.box-footer -->
                </form>
                
                
              <?php } ?>  
                
                </div>







</div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  
