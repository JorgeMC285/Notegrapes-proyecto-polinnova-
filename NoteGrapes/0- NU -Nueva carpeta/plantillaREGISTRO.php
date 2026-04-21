<!DOCTYPE html>
<?php
    session_start();
    //Se realiza la conexion con la base de datos a partir de un usuario -J
    require_once('conexion.php');

    if (isset($_POST['nom']) && isset($_POST['eml']) && isset($_POST['pas']) && isset($_POST['ps2'])) {
        
        // El formulario ha sido enviado, procesar los datos
        // Aquí puedes incluir la lógica para validar y guardar los datos en la base de datos
        
        if (isset($_POST['envCode']) && $_POST['envCode'] === 'true') {
            header("Location: maile.php");
        }else{
            //Comprobación de contraseñas -J
            $pas = $_POST['pas'];
            $ps2 = $_POST['ps2'];
            $acp = false;

            if ($pas != $ps2){
                echo "<script>alert('Las contraseñas no coinciden');</script>";
                echo "<p>Regrese a la pagina anterior para volverlo a intentar</p>";
            }else{
                $nom = $_POST['nom'];
                $eml = $_POST['eml'];

                // Comprobacion para evitar usuarios duplicados -J
                $ver = "SELECT * FROM users WHERE nombre = '$nom' OR email = '$eml'";

                $resul = mysqli_query($conect, $ver);

                if (mysqli_num_rows($resul) > 0) {
                    echo "<script>alert('Datos de su formulario ya son usados, favor de cambiar el nombre, correo o teléfono colocado');</script>";
                    echo "<p>Regrese a la pagina anterior para volverlo a intentar</p>";
                }else{
                    if (empty($nom) || empty($eml)){
                        echo "<script>alert('Los apartados estan vacios, porfavor de llenar el formulario');</script>";
                        echo "<p>Regrese a la pagina anterior para volverlo a intentar</p>";
                    }else{
                        session_regenerate_id(true);
                        $_SESSION['nom'] = $nom;
                        $_SESSION['eml'] = $eml;
                        $acp = true;
                        header("Location: maile.php", urldecode(http_build_query(array($_SESSION['eml'], $_SESSION['nom']))));
                        exit();

                        //Sentencia que se envia a la base de datos -J
                        //$sentencia = "INSERT INTO users(nombre, email, contrasena) VALUES('$nom','$eml', '$pas')";
                        // $funciono  = mysqli_query($conect, $sentencia);

                        //$_SESSION['username'] = $nom;

                        //echo "<script>alert('¡Se guardaron los datos correctamente!');</script>";
                        //echo "<p>Bienvenido $nom :)</p>"; 
                        //Debug -J
                //if($funciono){
                    //echo ':)';
                //}else{
                    //echo ':(';
                //}
                    }
                }    
            }
        }
    }
    
?>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/design.css">
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="plantillaREGISTRO.css">
    <title>Registro de Cuenta</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Mi Logo</h1>
        </div>
        <div class="header-content">
            <p>Registro de Cuenta</p>
        </div>
    </header>
    <main class="">  
        <section id="fd1"class="formDown">
        <form action="plantillaREGISTRO.php" method="post" class="form" id="registro">
            <div class="divForm"> 
                <div class="titleForm">
                    <h2>Registrarse</h2>
                    <hr>
                    </div>
                <div class="datForm">
                    <label for="nombre">Nombre del usuario:</label> 
                    <br>
                    <input class="input" id="nombre" type="text" placeholder="Nombre" name="nom" required>
                    <br>
                    <label for="email">Correo electrónico:</label> 
                    <br>   
                    <input class="input" id="email" type="email" placeholder="example@gmail.com" name="eml"required autocomplete="on">
                    <br>
                    <label for="password">Contraseña:</label>
                    <br>
                    <input class="input" id="password" type="password" placeholder="Contraseña" name="pas" minlength="8"required>
                    <br>
                    <label for="password2">Confirmar Contraseña:</label>
                    <br>
                    <input class="input" id="password2" type="password" placeholder="Confirme su contraseña" name="ps2" minlength="8"required>
                </div>
                <div class="buttonForm">
                    <button class="submit" type="reset">Limpiar información</button>
                    <button type="submit" class="submit">Registrar cuenta</button>
                </div>
            </div>
        </form>
        </section>
<!-- FORMULARIO DEL CÓDIGO DE VERIFICACIÓN -->
        <section class="formCode" id="formCode" style="display: <?php echo empty($_SESSION) ? 'none' : 'block'; ?>;">
            <?php echo $_SESSION['nom']; ?>
            <form action="maile.php" method="post">
                <input type="hidden" name= "envCode" value="true">
                <input class="input" id="nombre" type="hidden" name="nom" value="<?php if (isset($_SESSION['nom'])) { echo $_SESSION['nom']; }else{ echo "error"; } ?>" required>
                <input class="input" type="text" name= "eml" value="<?php if (isset($_SESSION['eml'])) { echo $_SESSION['eml']; }else{ echo ""; } ?>">
                <button class="submit" type="submit">Enviar de nuevo el codigo</button>
            </form>
            <form action="welcome.php">
                <input type="hidden" name= "nom" value="<?php echo isset($_SESSION['nom']) ? $_SESSION['nom'] : ''; ?>">
                <input type="hidden" name= "eml" value="<?php echo isset($_SESSION['eml']) ? $_SESSION['eml'] : ''; ?>">
                <input type="hidden" name= "pas" value="<?php echo isset($_SESSION['pas']) ? $_SESSION['pas'] : ''; ?>">
                <button class="submit" type="submit">Ingresar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2026 Notegrapes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
