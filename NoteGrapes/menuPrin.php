<!DOCTYPE html>
<?php
    require_once('phpFunc/conexion.php');
    require_once('phpFunc/verif.php');
    session_start();

// + Verificar sesión iniciada    
    if(!isset($_SESSION['username']) || !isset($_SESSION['login'])){
        header('Location: index.html');
        exit();
    }
    $nom = $_SESSION['username'];

// + Cerrar sesión
    if(isset($_POST['cerCuen'])){
        
        echo "<script>alert('Nos vemos luego $nom!');</script>";
        unset($_SESSION['username']);
        unset($_SESSION['login']);
        unset($_SESSION['id']);
        unset($_SESSION['latestProyect']);
        unset($_SESSION['color']);
        session_destroy();

        echo"<script>window.location.href = 'index.html';</script>";
        exit();
    }

// + 1- Encontrar proyecto reciente del usuario
    $lpId = null;

    if(!isset($_SESSION['latestProyect'])){
        $uId = obtenerValoresdelUsuario($conect, $nom, "id");
        
        if(!$uId){
            echo "<script>alert('Error al cargar datos del usuario.');
            window.location.href = 'index.html';</script>";
            exit();
        }
        $_SESSION['id'] = $uId;
        
        $resE = encontrarProyectoReciente($conect, $uId, "MAX(id)");
        if($resE){
            $_SESSION['latestProyect'] = $resE;
            $lpId = $_SESSION['latestProyect'];
        }else{
            echo "<script>alert('No tienes proyectos creados.');</script>";
            $lpId = null;
        }
            
    }else{
        $lpId = $_SESSION['latestProyect'];
    }

// + 2- Encontrar colores del usuario
    if(!isset($_SESSION['color'])){
        $uId = $_SESSION['id'];
        $resC = obtenerColor($conect, $uId);
        if($resC){
            $_SESSION['color'] = $resC;
            $col = $_SESSION['color'];
        }
    }
    $col = $_SESSION['color'];
    
// + Por si sale todo mal
    //if(!isset($nom)){
        //echo "<script>alert('Error al iniciar sesión. Realice de nuevo el formulario.');
        //window.location.href = 'index.html';</script>";
        //session_destroy();
        //exit();
    //}
?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo "Menu principal de " . $nom; ?></title>
        <link rel="stylesheet" href="css/colors.css">
        <script src="jscript/buttonColors.js"></script>
        <script>
        // Ejecución inmediata con el color real de este usuario
            const colorUsuario = '<?php echo $col; ?>';
            cambiarColores(colorUsuario);
        </script>
    </head>
    <body>
        <p>¡Bienvenido <?php echo $nom; ?>!</p>
        <p>¿Qué quieres hacer?</p>
        <a href="crearProyect.php">Crear Proyecto</a>
        <br>
        <?php if($lpId != null){ ?>
            <a href="contProyect.php?id=<?php echo $lpId; ?>">Proyecto Reciente</a>
            <br>
            <a href="listProyect.php">Mis Proyectos</a>
        <?php }else{ echo "<p><button disabled>Proyecto Reciente</button></p>
                           <br>
                           <p><button disabled>Mis Proyectos</button></p>"; } ?>
        <br>
        <a href="optsUsuario.php">Ajustes de la Cuenta</a>
        <br>
        <p><form action="menuPrin.php" method="post"><button type="submit" name="cerCuen">Cerrar sesión</button></form></p>
        
    </body>
</html>