<!DOCTYPE html>
<?php
// Codigo de PHP hecho por Jorge Antonio Macias Castro
    require_once('phpFunc/conexion.php');
    require_once("phpFunc/verif.php");
    require_once("phpFunc/regis.php");
    require_once("phpFunc/mail.php");
    session_start();

// + Envia formulario de datos de usuario
    if(isset($_POST['EnviarDat'])){
        
        $nom = $_POST['nom'];
        $pas = $_POST['pas'];

    //1- Encontrar nombre o correo
        $col1 = "nombre";
        $col2 = "email";
        $resE = encontrarDatos($nom, $col1, $col2, $conect);
        if($resE){
    //2- Verificar contraseña
            $resEn = verificarContrasena($nom, $pas, $conect);
            if($resEn){
                session_regenerate_id(true);
                $_SESSION['username'] = $resE;
                $_SESSION['login']    = true;
                header("Location: menuPrin.php");
                exit();
            }else{
                echo "<script>alert('Contraseña incorrecta');</script>";
            }
        }else{
            echo "<script>alert('El Nombre o correo electrónico no se encuentra registrado.');</script>";
        }
    }
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/design.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/grape.png">
    <script src= "jscript/buttonsAct.js"></script>
    <title>Iniciar sesión</title>
</head>
    
        <main class="mainForms">
            
            <section class="patLR">
                <section class="patUp">   
                </section> 
            </section>
            <body class="bodyForms">
                <section class="miniMenu">
                    <a class="aLarg" href="index.html">← Ir al inicio</a>
                </section>
            <section class="contForms">
                <!-- FORMULARIO -->
        <form  action="iniCuen.php" method="post" class="form" id="inicio">

            <div class="divForm"> 

                <div class="titleForm">
                    <h2>Iniciar sesión</h2>
                    <hr>
                </div>
    <!-- DATOS -->
                <div class="datForm">
                    <label for="nombre">Nombre del usuario o Correo:</label> 
                    <br>
                    <input name="nom" class="input" id="nombre" type="text" placeholder="Nombre o correo@example.com"  required>
                    <br>
                    <label for="password">Contraseña:</label>
                    <br>
                    <input name="pas" class="input" id="password" type="password" placeholder="Contraseña" required minlength="8">
                    <br>
                </div>
    <!-- BOTONES -->
                <div class="buttonForm">
                    <button class="submit" type="reset">Limpiar</button>
                    <button name="EnviarDat" type="submit" class="submit">Iniciar sesión</button>
                    
                </div>
                <div class="buttonRedirect">
                    <p>¿No tienes una cuenta? <a class="aSmall" href="regCuen.php">Registrate</a></p>
                </div>
            </div>
        </form>
<!---->
            </section>
            <section class="patLR">
                <section class="patUp">   
                </section> 
            </section>
            
        </main>
        <footer class= "footForms">
                <p>&copy; 2026 Notegrapes. Todos los derechos reservados.</p>
            </footer>
    </body>
</html>