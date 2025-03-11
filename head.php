 <title>Artis</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $base_dir;?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $base_dir;?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $base_dir;?>/dist/css/adminlte.css">
  <link rel="stylesheet" href="<?php echo $base_dir;?>/dist/css/style.css">
  <link  rel="stylesheet"  href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.11.0/css/flag-icons.min.css"/>
  <style >
  .slideshow-container {
    <?php if($_SESSION["grafica"]!=""){?>
    
   
  background-image: url("../../img/grafica/<?php echo $_SESSION["grafica"]?>.png");
  <?php }else{?>
background-image: url("../../img/grafica/grigio.png");
<?php
  } ?>

  position: relative;
  margin: 0px;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
</style>