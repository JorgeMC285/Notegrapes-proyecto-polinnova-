<?php 

// + registrarUsuario

    function registrarUsuario($nom, $eml, $pas, $conect){

    //Encriptar contraseña    
        $hashPas = password_hash($pas, PASSWORD_DEFAULT);
    //Sentencia que se envia a la base de datos
        $sentencia = "INSERT INTO users(nombre, email, contrasena) VALUES('$nom','$eml', '$hashPas')";
        $funciono  = mysqli_query($conect, $sentencia);

        $_SESSION['username'] = $nom;

        echo "<script>alert('¡Se guardaron los datos correctamente!');</script>";
        echo "<p>Bienvenido $nom :)</p>"; 

        //Debug
        //if($funciono){
            //echo ':)';
        //}else{
            //echo ':(';
        //}

        //echo "<br> 5- esto se hizo en regis.php";
        return true;
    }

// + EliminarUsuarioTemporal

    function eliminarTemp($nam, $Eval, $conect){
        $comand = "DELETE FROM tempusers WHERE ".$nam." = '$Eval'";
        echo $comand;
        $resul  = mysqli_query($conect, $comand);
        if(!$resul){
            echo "<script>alert('Error al eliminar usuario temporal');</script>";
            return false;
        }else{
            return true;

        }
    }

// + RegistrarProyecto
    function registrarProyecto($conect, $tit, $des, $uId){
        if(empty($uId) || empty($tit)){
            echo "<script>alert('No hay usuario o título de proyecto');</script>";
            return false;
        }

        $sen = "INSERT INTO proyects (id_admin, titulo, descripcion) VALUES ($uId, '$tit', '$des')";
        $result = mysqli_query($conect, $sen);
        if(!$result){
            echo "<script>alert('Error al crear el proyecto');</script>";
            return false;
        }
        return true;

    }
?>