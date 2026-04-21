<!DOCTYPE html>
<?php 
    require_once('phpFunc/conexion.php');
    require_once('phpFunc/verif.php');
    require_once('phpFunc/camb.php');
    session_start();
    
// + Verificar sesión iniciada    
    if(!isset($_SESSION['username']) || !isset($_SESSION['login'])){
        header('Location: index.html');
        exit();
    }
    
// + Obtener id desde el link y encontrarlo en la base de datos
    if(isset($_GET['id'])){
        $proyecto = $_GET['id'];
        $resP = encontrarProyecto($proyecto, $conect);
        if(!$resP){
            echo "<script>alert('No se encontró el proyecto.');
                 window.location.href = 'menuPrin.php';</script>";
        }

        $oldTit = $resP['titulo'];
        $oldDes = $resP['descripcion'];
    }

// + Verificar permisos del usuario
    // + Creador del proyecto
    // + Administrador
    // + Otro usuario

// + Enviar cambios realizados al proyecto
    if(isset($_POST['EnviarCambios'])){
        $proyecto = $_POST['EnviarCambios'];
        $tit = $_POST['tit'];
        $des = $_POST['des'];

        $resA = actualizarProyecto($conect, $tit, $des, $proyecto);
        if($resA){
            $oldTit = $tit;
            $oldDes = $des;
            echo "<script>alert('Cambios guardados exitosamente.');</script>";
        }
    }

// + Eliminar proyecto

//En caso de que salga todo mal
    if(!isset($proyecto) || empty($proyecto)){
        header('Location: menuPrin.php');
        exit();
    }
?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $oldTit; ?></title>
    </head>
    <body>
        <form action="editProyect.php" method="POST" onsubmit="return confirm('¿Seguro que desea guardar los cambios realizados?');">
            <label for="titulo">*Titulo:</label>
            <br>
            <input type="text" id="titulo" name="tit" maxlength="100" placeholder="Ingrese el título del proyecto" value="<?php echo $oldTit; ?>" required>
            <br>
            <label for="descripcion">Descripción:</label>
            <br>
            <textarea type="text" id="descripcion" name="des" maxlength="255" placeholder="Ingrese la descripción del proyecto (Opcional)"><?php echo $oldDes; ?></textarea>
            
            
            <br>
            <div>
                <button class="submit" type="reset">Deshacer cambios</button>
            <button name="EnviarCambios" type="submit" value="<?php echo $proyecto; ?>">Guardar cambios</button>
            </div>
            
        </form>
        <a href="contProyect.php?id=<?php echo $proyecto; ?>">Volver al proyecto</a>
    </body>
</html>