<!DOCTYPE html>
<?php
    session_start();
    //Se realiza la conexion con la base de datos a partir de un usuario -J
    require_once('conexion.php');

    if (isset($_POST['nom']) && isset($_POST['eml']) && isset($_POST['pas'])) {
        
        // El formulario ha sido enviado, procesar los datos
        // Aquí puedes incluir la lógica para validar y guardar los datos en la base de datos
        //Comprobación de contraseñas -J
        $_SESSION['nom'] = $_POST['nom'];
        $_SESSION['eml'] = $_POST['eml'];
        $_SESSION['pas'] = $_POST['pas'];

                
        if (empty($_SESSION['nom'])){
            echo "<p>El nombre esta vacio</p>";
            exit();
        }
        if (empty($_SESSION['eml'])){
            echo "<p>El email esta vacio</p>";
            exit();
        }
        if (empty($_SESSION['pas'])){
            echo "<p>La contraseña esta vacia</p>";
            exit();
        }

        //Sentencia que se envia a la base de datos -J
        $sentencia = "INSERT INTO users(nombre, email, contrasena) VALUES('$nom','$eml', '$pas')";
        $funciono  = mysqli_query($conect, $sentencia);

        $_SESSION['username'] = $_SESSION['nom'];

        echo "<script>alert('¡Se guardaron los datos correctamente!');</script>";
        echo "<p>Bienvenido " . $_SESSION['nom'] . " :)</p>"; 
//Debug -J
    //if($funciono){
        //echo ':)';
    //}else{
        //echo ':(';
    //}
    }else{
        echo "<p>Los datos no se han enviado correctamente, porfavor de llenar el formulario</p>";
        echo $_SESSION['nom'];
        echo $_SESSION['eml'];
        echo $_SESSION['pas'];
        exit();
    }
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button onclick="window.location.href='a.html'">Ingresar</button>
</body>
</html>