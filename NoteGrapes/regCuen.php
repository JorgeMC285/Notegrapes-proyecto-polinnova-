
<?php
// Codigo de PHP hecho por Jorge Antonio Macias Castro
    require_once('phpFunc/conexion.php');
    require_once("phpFunc/verif.php");
    require_once("phpFunc/regis.php");
    require_once("phpFunc/mail.php");
    session_start();
// + Eliminar sesión temporal (esto para evitar errores al recargar la página)
    if(!isset($_POST['EnviarDat']) && !isset($_POST['EnviarCod'])){
        unset($_SESSION['temp_nom']);
        unset($_SESSION['temp_eml']);
        unset($_SESSION['temp_pas']);
    }

// + Enviar formulario de datos de usuario
    if(isset($_POST['EnviarDat'])){
        $nom = $_POST['nom'];
        $eml = $_POST['eml'];
        $pas = $_POST['pas'];
        $ps2 = $_POST['ps2'];

    //1- Verificar formulario
        $resV = verificarDatos($nom, $eml, $pas, $ps2, $conect);
        if($resV){
    //2- Enviar correo            
            $resE = enviarCorreo($nom, $eml, $conect);
            if($resE){
    //3- Crear sesión temporal para registro
                $_SESSION['temp_nom'] = $nom;
                $_SESSION['temp_eml'] = $eml;
                $_SESSION['temp_pas'] = $pas;
            }
        }
    }

// + Comprobar codigo de verificacion
    if(isset($_POST['EnviarCod'])){
    //1- Verificar datos desesión temporal
        if(!isset($_SESSION['temp_nom']) || !isset($_SESSION['temp_eml']) || !isset($_SESSION['temp_pas'])){
            echo "<script>alert('No se encontraron datos de registro, por favor vuelva a llenar el formulario.');</script>";
            header('Location: regCuen.php');
            exit();
        }else{
            $nom = $_SESSION['temp_nom'];
            $eml = $_SESSION['temp_eml'];
            $pas = $_SESSION['temp_pas'];
            $cod = $_POST['code'];

    //2- Verificar codigo
            $resC = verificarCodigo($eml, $cod, $conect);
            if($resC){
    //3- Registrar usuario
                $resR = registrarUsuario($nom, $eml, $pas, $conect);
                if($resR){
    //4- Eliminar codigo temporal
                    $fil = "correo";
                    $resT = eliminarTemp($fil, $eml, $conect);
                    if($resT){
    //5- Eliminar sesión temporal
                        session_regenerate_id(true);
                        $_SESSION['username'] = $nom;
                        $_SESSION['login']    = true;

                        unset($_SESSION['temp_nom']);
                        unset($_SESSION['temp_eml']);
                        unset($_SESSION['temp_pas']);
                        
                        header("Location: menuPrin.php");
                        exit();
                    }
                }
            }else{
                $fil = "correo";
                $resT = eliminarTemp($fil, $eml, $conect);

                unset($_SESSION['temp_nom']);
                unset($_SESSION['temp_eml']);
                unset($_SESSION['temp_pas']);
            }
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
    <title>Registrarse</title>
</head>
    <body class="bodyForms">
        
        <section class="patUp">
            <main class="mainForms">
            <section class="miniMenu">
                <a class="aLarg" href="index.html">← Ir al inicio</a>
            </section>
            
                <section class="patLR"></section> 
                <section class="contForms">
            <!-- FORMULARIO -->
                
                <div class="divForm"> 
                    <form  action="regCuen.php" method="post" class="form" id="registro">        
                        <div class="titleForm">
                            <h2>Registrarse</h2>
                            <hr>
                        </div>
                <!-- DATOS -->
                        <div class="datForm">
                            <label for="nombre">Nombre del usuario:</label> 
                            <br>
                            <input name="nom" class="input" id="nombre" type="text" placeholder="Nombre" maxlength="30" required>
                            <br>
                            <label for="email">Correo electrónico:</label> 
                            <br>   
                            <input name="eml" class="input" id="email" type="email" placeholder="example@gmail.com" required autocomplete="on">
                            <br>
                            <label for="password">Contraseña:</label>
                            <br>
                            <input name="pas" class="input" id="password" type="password" placeholder="Contraseña" required minlength="8">
                            <br>
                            <label for="password2">Confirmar Contraseña:</label>
                            <br>
                            <input name="ps2" class="input" id="password2" type="password" placeholder="Confirme su contraseña" required minlength="8">
                        </div>
                <!-- BOTONES -->
                        <div class="buttonForm">
                            <button class="submit" type="reset">Limpiar</button>
                            <button name="EnviarDat" type="submit" class="submit">Registrarse</button>
                        </div>
                    </form>
            <!-- -->  

            <!-- FORMULARIO DE CODIGO -->            
                    <form action="regCuen.php" method="post" class="form" id="verificacion">
                        <div class="codForm" style="display: <?php if (isset($resE)) {echo $resE ? 'block' : 'none';}else{echo 'none';} ?>;">
                            <div class ="datFormC">
                                <br>
                                <hr>
                                <label for="code">Código de verificación:</label>
                                <input name="code" class="input" id="code" type="password" placeholder="XXXXXX" required>
                                <br> 
                            </div>
                <!--BOTONES C-->             
                            <div class="buttonForm">
                                <button type="button"  class="submit" onclick="cancelar()">Cancelar</button>         
                                <button name="EnviarCod" type="submit" class="submit">Enviar codigo</button>
                            </div>
                            
                        </div>
                        <div class="buttonRedirect">
                            <p>¿Ya tienes una cuenta? <a class="aSmall" href="iniCuen.php">Inicia sesión</a></p>
                        </div>
                    </form>
                </div>    
            <!-- -->
            </section>
            <section class="patLR">
                <section class="patUp">   
                </section> 
            </section>
            
            </main>
            <footer class= "footForms">
                <p>&copy; 2026 Notegrapes. Todos los derechos reservados.</p>
            </footer>
        </section>
    </body>
</html>