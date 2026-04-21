<!DOCTYPE html>
<?php
    require_once('phpFunc/conexion.php');
    require_once('phpFunc/regis.php');
    session_start();

// + Verificar sesión iniciada    
    if(!isset($_SESSION['username']) || !isset($_SESSION['login'])){
        header('Location: index.html');
        exit();
    }
    $uId = $_SESSION['id'];

// + Crear Tarea
    if(isset($_POST['crearTarea'])){
        //$tit = $_POST['tit'];
        //$des = $_POST['des'];

        //$resR = registrarProyecto($conect, $tit, $des, $uId);

        //if($resR){
            //echo "<script>alert('Proyecto creado exitosamente');</script>";
        //}
    }

// + Cargar colores del proyecto
    $col = $_SESSION['color'];
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crear Proyecto</title>
    </head>
    <body>
        <form action="crearTarea.php" method="post" onsubmit="return confirm('¿Seguro que desea crear esta tarea?');">
            <label for="titulo">*Titulo:</label>
            <br>
            <input type="text" id="titulo" name="tit" maxlength="100" placeholder="Ingrese el título de la tarea" required>
            <br>

            <label for="descripcion">Descripción de la tarea:</label>
            <br>
            <textarea id="descripcion" name="des" maxlength="255" placeholder="Ingrese la descripción de la tarea (Opcional)"></textarea>
            <br>

            <button class="submit" type="reset">Limpiar</button>
            <button name="crearTarea" type="submit" class="submit">Crear Tarea</button>
        </form>
        <a href="menuPrin.php">Regresar</a>
    </body>
</html>