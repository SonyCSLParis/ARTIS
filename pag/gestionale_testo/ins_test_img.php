<?php
// Start the session
session_start();
?>
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>
<?php 
  if(isset($_POST["submit"])) {
  $target_dir = "../../img/uploads/";
  $target_file = $target_dir . $_FILES["fileToUpload"]["name"];
  $uploadOk = 1;
  $imageFileType = strtolower($_FILES["fileToUpload"]["type"]);
  // Check if image file is a actual image or fake image
  echo $imageFileType;
    // Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType!="application/pdf") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 1;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

    $url = "http://93.147.158.9:5002/carica_libro_da_img";
    $da = ["file"=> $_FILES["fileToUpload"]["name"]];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Added this on local system to avoid SSL error
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Added this on local system to avoid SSL error
    curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Added this to decode the response
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
      
        'X-locale: it_IT',
    'Pragma: no-cache',
    'Cache-Control: no-cache, no-store'
        
    );
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($da));
   
    $response = curl_exec($ch);

      $_SESSION["id_text_gestionale"]=$response;
         ?>
<script >
 window.location.href = "modifica_testo.php?id=<?php echo $response;?>";
 </script>
<?php
    curl_close($ch);
   



  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
  }

  
?>
<?php include "../../header_gestionale.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
        <div class="col-sm-11">
            <h1 class="m-0" align="center">Inserimento immagini bliblioteca</h1>
           
          </div>
        <div class="col-sm-1">
        <a href="elenco.php"> <i class="fas fa-undo-alt"></i></a>
      <!-- /.col -->
        
        </div><!-- /.row --> <hr>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container" >
       
     





<div class="row">
  <div class="col-lg-12">

    <div class="card card-primary">
<div class="card-header">
<h3 class="card-title">Immagine</h3>


</div>

<div class="card-body" >
<form action="ins_test_img.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>


</div>

</div>
 

   
</div>
</div>
     <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 
</div>
<!-- ./wrapper -->

<?php include "../../scripts.php";?>

</body>
</html>
