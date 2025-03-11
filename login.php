
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

     // echo "LOGOUT";
			$_SESSION['codice'] = "";
			$_SESSION['nome'] = "";
			$_SESSION['livello'] = "";
			$_SESSION['id'] = "";
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
<div class="login-box">
  <div class="login-logo">
   <img src="img/logoartis.png" width="250">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Accedi per iniziare la tua sessione</p>
<?php echo $msg;?>
      <form action="login.php?chk=1" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="User" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

  
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<?php include "scripts.php";?>
</body>
</html>
