<?php include ("../template/cabecera.php"); ?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtDescripcion=(isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include ("../config/bd.php");

switch($accion){

    case "Agregar":

        $sentenciaSQL= $conexion -> prepare("INSERT INTO episodios (nombre, descripcion, imagen) VALUES (:nombre,:descripcion,:imagen);");
        $sentenciaSQL -> bindParam(':nombre',$txtNombre);
        $sentenciaSQL -> bindParam(':descripcion',$txtDescripcion);

        $fecha= new DateTime();
        $nombreArchivo= ($txtImagen!="")?$fecha -> getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen != ""){
            

            move_uploaded_file($tmpImagen, "../../images/".$nombreArchivo);

        }

        $sentenciaSQL -> bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL -> execute();
        header("location:episodios.php");
        break;

    case "Modificar":

        $sentenciaSQL= $conexion -> prepare("UPDATE episodios SET nombre=:nombre, descripcion=:descripcion  WHERE id=:id" );
        $sentenciaSQL -> bindParam(':nombre',$txtNombre);
        $sentenciaSQL -> bindParam(':descripcion',$txtDescripcion);
        $sentenciaSQL -> bindParam(':id',$txtID);
        $sentenciaSQL -> execute();

        if($txtImagen!=""){

            $fecha= new DateTime();
            $nombreArchivo= ($txtImagen!="")?$fecha -> getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen, "../../images/".$nombreArchivo);

            $sentenciaSQL= $conexion -> prepare("SELECT imagen FROM episodios WHERE id=:id" );
            $sentenciaSQL -> bindParam(':id',$txtID);
            $sentenciaSQL -> execute();
            $episodio= $sentenciaSQL -> fetch(PDO::FETCH_LAZY); 

            if( isset($episodio["imagen"]) &&($episodio["imagen"]!="imagen.jpg") ){

                if(file_exists("../../images/".$episodio["imagen"])){

                    unlink("../../images/".$episodio["imagen"]);
                }
            }   

            $sentenciaSQL= $conexion -> prepare("UPDATE episodios SET imagen=:imagen WHERE id=:id" );
            $sentenciaSQL -> bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL -> bindParam(':id',$txtID);
            $sentenciaSQL -> execute();
        }    
        header("location:episodios.php");
        break;

    case "Cancelar":
        header("location:episodios.php");
        break;        

    case "Seleccionar":
        $sentenciaSQL= $conexion -> prepare("SELECT * FROM episodios WHERE id=:id" );
        $sentenciaSQL -> bindParam(':id',$txtID);
        $sentenciaSQL -> execute();
        $episodio= $sentenciaSQL -> fetch(PDO::FETCH_LAZY); 

        $txtNombre=$episodio['nombre'];
        $txtDescripcion=$episodio['descripcion'];
        $txtImagen=$episodio['imagen'];

        break;   

    case "Borrar":

        $sentenciaSQL= $conexion -> prepare("SELECT imagen FROM episodios WHERE id=:id" );
        $sentenciaSQL -> bindParam(':id',$txtID);
        $sentenciaSQL -> execute();
        $episodio= $sentenciaSQL -> fetch(PDO::FETCH_LAZY); 

        if( isset($episodio["imagen"]) &&($episodio["imagen"]!="imagen.jpg") ){

            if(file_exists("../../images/".$episodio["imagen"])){

                unlink("../../images/".$episodio["imagen"]);
            }
        }   

        $sentenciaSQL= $conexion -> prepare("DELETE FROM episodios WHERE id=:id");
        $sentenciaSQL -> bindParam(':id',$txtID);
        $sentenciaSQL -> execute();
        header("location:episodios.php");
        break;       
}

$sentenciaSQL= $conexion -> prepare("SELECT * FROM episodios");
$sentenciaSQL -> execute();
$listaEpisodios= $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC); 

?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de Episodio
        </div>

        <div class="card-body">
        
        <form method="POST" enctype="multipart/form-data" >
            
    <div class = "form-group">
    <label for="exampleInputEmail1">ID:</label>
    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
    </div>

    <div class = "form-group">
    <label for="exampleInputEmail1">Nombre:</label>
    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
    </div>

    <div class = "form-group">
    <label for="exampleInputEmail1">Descripción:</label>
    <input type="text" required class="form-control" value="<?php echo $txtDescripcion; ?>" name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion">
    </div>

    <div class = "form-group">
    <label for="exampleInputEmail1">Imagen:</label>
    <br>
    <?php if($txtImagen!=""){ ?>
        <img class="img-thumbnail rounded" src="../../images/<?php echo $txtImagen; ?>" width="100" alt="">
    <?php } ?>


    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
    </div>

        <div class="btn-group" role="group" aria-label="">
            <button type="submit" name="accion" <?php echo($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
            <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
            <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
        </div>

    </form>

        </div>

    </div>

    
  
    
</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaEpisodios as $episodio) {?>
            <tr>
                <td><?php echo $episodio['id'] ?></td>
                <td><?php echo $episodio['nombre'] ?></td>
                <td><?php echo $episodio['descripcion'] ?></td>
                <td>
                
                <img class="img-thumbnail rounded" src="../../images/<?php echo $episodio['imagen'];?>" width="100" alt="">
                
                </td>                
                <td>

                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $episodio['id'] ?>" />
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                </form>

                </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include ("../template/pie.php"); ?>
