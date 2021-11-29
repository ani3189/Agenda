<?php include ("template/cabecera.php"); ?>

<?php
include("administrador/config/bd.php");

$sentenciaSQL= $conexion -> prepare("SELECT * FROM episodios");
$sentenciaSQL -> execute();
$listaEpisodios= $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC); 

?>

<?php
foreach($listaEpisodios as $episodio){
?>

<div class="col-md-3">
    
    <div class="card">
        <img class="card-img-top" src="./images/<?php echo $episodio['imagen']; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?php echo $episodio['nombre']; ?> </h4>
            <p class="card-text"><?php echo $episodio['descripcion']; ?></p>
        </div>
    </div>

</div>
<?php } ?>

<?php include ("template/pie.php"); ?>