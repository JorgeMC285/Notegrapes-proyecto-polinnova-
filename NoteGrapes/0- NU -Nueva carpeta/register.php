<?php
    session_start();
    //Se realiza la conexion con la base de datos a partir de un usuario -J
    require_once('conexion.php');
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
                $acp = true;
    

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if($acp){
        echo "Para continuar con el registro, coloque el codigo mandado al correo '$eml'";
        echo "<form action='regisCode.php' method='post'>";
        echo "<input type='text' name='codigo' placeholder='Ingrese el código'>";
        echo "<button type='submit'>Verificar Código</button>";
        echo "</form>";
    } ?>
</body>
</html>