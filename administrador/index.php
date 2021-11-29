<?php
session_start();
if ($_POST){
    if(($_POST['usuario']=="aladeriva")&&($_POST['contrasena']=="sistema")){ // cambiar con consulta a la bd para usuarios ver aprox 2:30:00 de https://www.youtube.com/watch?v=IZHBMwGIAoI para ver cuáles son los llamados
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']="aladeriva";
        header('Location:inicio.php'); 
    }else{
        $mensaje="Error: El usuario o contraseña son incorrectos";
    }
    
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-4"></div>

        <div class="col-md-4"> <br><br><br>
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">

                <?php if(isset ($mensaje)){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                    <form method="POST">

                    <div class = "form-group">
                    <label>Usuario</label>
                    <input type="text" class="form-control" name="usuario"  placeholder="Ingrese su usuario">
                    </div>
                    <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="contrasena" placeholder="Ingrese su contraseña">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Entrar</button>
                    </form>
                    
                    
                </div>
            </div>
        </div>
        
    </div>
</div>      
</body>
</html>