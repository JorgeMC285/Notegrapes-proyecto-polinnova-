<!DOCTYPE html>
<?php 
    require_once('phpFunc/conexion.php');
    require_once('phpFunc/camb.php');
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
    
// + Cambiar colores
    if(!isset($_SESSION['color'])){
        $_SESSION['color'] = "o01";
        $col = $_SESSION['color'];
    }
    if(!isset($col)){
        $col = $_SESSION['color'];
    }

    if(isset($_POST['color'])){
        
        $col  = $_POST['color'];
        $uId  = $_SESSION['id'];
        $resC = actualizarColor($conect, $col, $uId);
        
        if(!$resC){
            echo "<script>alert('Error al actualizar el color.');
            window.location.href = 'menuPrin.php';</script>";
            exit();
        }
        $_SESSION['color'] = $col;   
    }

?>

<html lang="es" class="<?php echo $col; ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/design.css">
        <link rel="stylesheet" href="css/colors.css">
        <script src="jscript/buttonColors.js"></script>
        <title><?php echo $nom; ?></title>
    </head>
    <body>

<!--Cambiar colores-->
        
        <form action="optsUsuario.php" method="post">
            <section class="logoCuen">
                <button id="themeBtn" type="submit" name="color" value="o01" onclick="cambiarColores('o01')">Morado</button>
            </section>
            <section class="logoCuen">
                <button id="themeBtn" type="submit" name="color" value="o02" onclick="cambiarColores('o02')">Azul</button>
            </section>
            <section class="logoCuen">
                <button id="theme2Btn" type="submit" name="color" value="o03" onclick="cambiarColores('o03')">Amarillo</button>
            </section>
            <section class="logoCuen">
                <button id="theme3Btn" type="submit" name="color" value="o04" onclick="cambiarColores('o04')">Rojo</button>  
            </section>
            <section class="logoCuen">
                <button id="theme3Btn" type="submit" name="color" value="o05" onclick="cambiarColores('o05')">Dorado</button>  
            </section>
            <section class="logoCuen">
                <button id="theme3Btn" type="submit" name="color" value="c01" onclick="cambiarColores('c01')">Claro</button>  
            </section>
        </form>

        <section class="logoCuen">
            <a href="menuPrin.php">
                <p class="logText">Ir al menu</p>
                <img src="images/grape.png" alt="Color"> 
            </a>
        </section>
<!--Cambiar datos del usuario--> 

<!--Cerrar sesion-->
        <form action="menuPrin.php" method="post"><button type="submit" name="cerCuen">Cerrar sesión</button></form>

<!--Eliminar cuenta-->

    </body>
</html>