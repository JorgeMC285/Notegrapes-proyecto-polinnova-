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
    $uId = $_SESSION['id'];
    $col = 'id';
    $ord = 'ASC';

// + Encontrar proyectos
    $resO = obtenerProyectosUsuario($conect, $uId, $col, $ord);
    if(!$resO){
        echo "<script>alert('No se tienen proyectos registrados.');
             window.location.href = 'menuPrin.php';</script>";
        exit();
    }
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mis Proyectos</title>
    </head>
    <body>
        <h4>Mis Proyectos</h4>
        <table>
            <tr>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php while($fil = mysqli_fetch_assoc($resO)) { ?>
                <tr>
                    <td><a href="contProyect.php?id=<?php echo $fil['id']; ?>"><?php echo htmlspecialchars($fil['titulo'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                    <td><?php echo htmlspecialchars($fil['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
<!-- ESTO ES TEMPORALLLLLLLLLLLLLLL-->
                    <td>Administrador</td> 
<!---->
                    <td>
                        <a href="editProyect.php?id=<?php echo $fil['id']; ?>"><button>Editar</button></a>
                        <button>Eliminar</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <h4>Proyectos que colaboro</h4>
        <a href="menuPrin.php">Regresar al menu</a>
        <a href=""></a>
    </body>
</html>