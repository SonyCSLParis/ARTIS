
<?php
// Start the session
session_start();
?>
<?php include "admin/conn.php";
include "admin/funz.php";
?>
<?php 



	
?><!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php include "head.php";?>
</head>
<body class="sidebar-mini sidebar-collapse layout-fixed">
<div class="wrapper">

<?php include "sidebar.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #fff;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0"> ARTIS</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
           
      

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">FAQ</h5>
              </div>
              <div class="card-body">
             <B> Per iniziare a usare ARTIS segui queste istruzioni :</b><br><bR>

<b>1. Selezionare l'alunno<b><br><bR>

Per selezionare un alunno, accedere al menù "Alunno" e cliccare sul pallino nella colonna "Seleziona".<br><bR>

    Se l'alunno è selezionato, il pallino diventa blu.<br>
    Una volta selezionato, l'avatar dell'alunno apparirà sulla barra di navigazione.<br><bR>

<b>2. Selezionare il libro</b><br><bR>

Dal menù "Biblioteca", è possibile visualizzare tutti i libri adatti all'alunno.<br><bR>

    Per selezionare un libro, cliccarci sopra.<br>
    Il libro selezionato verrà evidenziato con una cornice nera.<br>
    L'immagine di copertina del libro apparirà sulla barra di navigazione.<br><bR>

<b>Se nessun libro disponibile in biblioteca</b><br><bR>

Se non sono presenti libri in biblioteca:<br><bR>

    Assicurarsi che i libri siano stati abilitati dal menù "Gestione testi".<br>
    Verificare che all'alunno sia stata assegnata la classe di appartenenza dal menù "Gestione alunni".
  </div>
            </div>


          </div>
          <!-- /.col-md-6 -->
        </div>

     

        </div>
        <!-- /.row -->
        


      
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<?php include "footer.php";?>
</div>
<!-- ./wrapper -->

<?php include "scripts.php";?>

</body>
</html>
