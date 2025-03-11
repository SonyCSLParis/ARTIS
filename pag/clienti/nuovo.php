<?php include "../../header.php";?>
<?php
if($_POST[pul] == "Salva"){
	
		$qryins = "insert into tab_cliente set 
		
			
			RagioneSociale = '".addslashes($_POST[ragionesociale])."',
			
			Comune = '".addslashes($_POST[comune])."',
			
			Provincia = '".addslashes($_POST[provincia])."',
			
			Indirizzo = '".addslashes($_POST[indirizzo])."',
			
			CAP = '$_POST[cap]',
			CodiceFiscale = '$_POST[codicefiscale]',
			PartitaIva = '$_POST[partitaiva]',
      note = '".addslashes($_POST[note])."',
      codice = '".$_POST[codice]."',
      pec = '".$_POST[pec]."', 
			listino = $_POST[listino],
			iban = $_POST[iban],
			categoria = $_POST[categoria],
			Mail = '$_POST[mail]',fatturazione=".$_POST[fatturazione];
		
		
		$rsins = connetti($qryins);
		$msg = "Nuovo cliente inserito";
	
	
}

?>

    <script>
	$(document).ready(function(){
		$(".menu_gestionale").removeClass("active");
        $("#clienti").addClass("active");
		$("#clienti_nuovo").addClass("active");
    });
	
	</script>
    
  
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Nuovo cliente
            
          </h1>
         
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
                 <form class="form-horizontal" method="post" action="nuovo.php">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="ragionesociale" class="col-sm-2 control-label">Ragione sociale</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="ragionesociale" name="ragionesociale" >
                      </div>
                    </div>
                   <div class="form-group">
                      <label for="comune" class="col-sm-2 control-label">Comune</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="comune" name="comune" >
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <label for="provincia" class="col-sm-2 control-label">Provincia</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="provincia" name="provincia" >
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="indirizzo" class="col-sm-2 control-label">Indirizzo</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="indirizzo" name="indirizzo" >
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="cap" class="col-sm-2 control-label">CAP</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="cap" name="cap" >
                      </div>
                    </div> 
                     <div class="form-group">
                      <label for="codicefiscale" class="col-sm-2 control-label">Codice Fiscale</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="codicefiscale" name="codicefiscale" >
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="partitaiva" class="col-sm-2 control-label">Partia IVA</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="partitaiva" name="partitaiva" >
                      </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="mail" class="col-sm-2 control-label">Mail</label>
                      <div class="col-xs-5">
                        <input type="text" class="form-control" id="mail" name="mail" >
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
                        <input type="text" class="form-control" id="note" name="note" >
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
                
                
                
                
                </div>







</div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  
