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

// + Crear Proyecto
    if(isset($_POST['crearProyecto'])){
        $tit = $_POST['tit'];
        $des = $_POST['des'];

        $resR = registrarProyecto($conect, $tit, $des, $uId);

        if($resR){
            echo "<script>alert('Proyecto creado exitosamente');</script>";
        }
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
        <form action="crearProyect.php" method="post" onsubmit="return confirm('¿Seguro que desea crear este proyecto?');">
            <label for="titulo">*Titulo del proyecto:</label>
            <br>
            <input type="text" id="titulo" name="tit" maxlength="100" placeholder="Ingrese el título del proyecto" required>
            <br>

            <label for="descripcion">Descripción del proyecto:</label>
            <br>
            <textarea id="descripcion" name="des" maxlength="255" placeholder="Ingrese la descripción del proyecto (Opcional)"></textarea>
            <br>

            <button class="submit" type="reset">Limpiar</button>
            <button name="crearProyecto" type="submit" class="submit">Crear Proyecto</button>
        </form>
        <a href="menuPrin.php">Regresar</a>
    </body>
</html>