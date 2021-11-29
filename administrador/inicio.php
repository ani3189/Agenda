<?php include("template/cabecera.php");?>

            <div class="col-md-12">
             
                <div class="jumbotron">
                <h1 class="display-3">Bienvenide <?php echo "@".$nombreUsuario; ?></h1>
                <p class="lead">Vamos a administrar los episodios</p>
                <hr class="my-2">
                <p>Recordá tener la imagen, descripción y nombre del episodio preparados. En breve podrás administrar los links para que los oyentes accedan a YouTube y Spotify</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="seccion/episodios.php" role="button">Administrar Episodios</a>
                </p>
                </div>

            </div>
            
<?php include("template/pie.php");?>